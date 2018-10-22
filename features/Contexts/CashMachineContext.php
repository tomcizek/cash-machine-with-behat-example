<?php declare(strict_types = 1);

namespace CashMachine\Features\Contexts;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use CashMachine\CardManagement\DomainModel\Card\WithholdMoney\WithholdAmountFromCardCommandHandler;
use CashMachine\CardManagement\DomainModel\CardRepository;
use CashMachine\CardManagement\Infrastructure\FilePersistence\FileCardRepository;
use CashMachine\CardManagement\Policy\CashMachineWithholdPolicy;
use CashMachine\CardManagement\Tests\DomainModel\Card\FixtureBuilders\CardBuilder;
use CashMachine\CashMachine\DomainModel\CashMachine\CashMachineRepository;
use CashMachine\CashMachine\DomainModel\CashMachine\DispenseMoney\DispenseMoneyFromCashMachineCommandHandler;
use CashMachine\CashMachine\DomainModel\CashMachine\RequestMoney\CardHasInsufficientBalanceMoneyRequestDeclined;
use CashMachine\CashMachine\DomainModel\CashMachine\RequestMoney\MoneyRequestFromCashMachineAccepted;
use CashMachine\CashMachine\DomainModel\CashMachine\RequestMoney\RequestMoneyFromCashMachineCommand;
use CashMachine\CashMachine\DomainModel\CashMachine\RequestMoney\RequestMoneyFromCashMachineCommandHandler;
use CashMachine\CashMachine\DomainModel\CashMachine\ReturnCard\ReturnCardFromCashMachineCommandHandler;
use CashMachine\CashMachine\Infrastructure\FilePersistence\FileCashMachineRepository;
use CashMachine\CashMachine\Infrastructure\FilePersistence\FileGetCardByNumberQuery;
use CashMachine\CashMachine\Infrastructure\RealWorldOutput\SpyCardReturner;
use CashMachine\CashMachine\Infrastructure\RealWorldOutput\SpyMoneyDispenser;
use CashMachine\CashMachine\Policy\DispenseMoneyFromAtmPolicy;
use CashMachine\CashMachine\Policy\ReturnCardFromAtmPolicy;
use CashMachine\CashMachine\Policy\ShowMessagePolicy;
use CashMachine\CashMachine\Tests\DomainModel\FixtureBuilders\CashMachineBuilder;
use Library\MessageBus\SimpleEventBus;
use Library\MoneyFactory;
use PHPUnit\Framework\Assert;

/**
 * Defines application features from the specific context.
 */
final class CashMachineContext extends Assert implements Context
{
	/**
	 * @var CardBuilder
	 */
	private $cardBuilder;

	/**
	 * @var CashMachineBuilder
	 */
	private $cashMachineBuilder;

	/**
	 * @var CashMachineRepository
	 */
	private $cashMachineRepository;

	/**
	 * @var CardRepository
	 */
	private $cardRepository;

	/**
	 * @var RequestMoneyFromCashMachineCommandHandler
	 */
	private $requestMoneyFromCashMachineCommandHandler;

	/**
	 * @var SpyMoneyDispenser
	 */
	private $spyMoneyDispenser;

	/**
	 * @var SpyCardReturner
	 */
	private $spyCardReturner;

	/**
	 * @var ShowMessagePolicy
	 */
	private $showMessagePolicy;

	public function __construct()
	{
		$this->buildDependencies();
	}

	/**
	 * @Given the card balance is cZK :arg1
	 */
	public function theCardBalanceIsCzk($arg1): void
	{
		$this->cardBuilder->setBalance(MoneyFactory::CZK((float) $arg1));
	}

	/**
	 * @Given the card is valid
	 */
	public function theCardIsValid(): void
	{
		$this->cardBuilder->setIsValid(true);
	}

	/**
	 * @Given the machine contains enough money
	 */
	public function theMachineContainsEnoughMoney(): void
	{
		$this->cashMachineBuilder->setBalance(
			MoneyFactory::CZK(666666666)
		);
	}

	/**
	 * @When the Card Holder requests cZK :arg1
	 */
	public function theCardHolderRequestsCzk($arg1): void
	{
		$this->cashMachineRepository->save($this->cashMachineBuilder->build());
		$this->cardRepository->save($this->cardBuilder->build());

		$this->requestMoneyFromCashMachineCommandHandler->handle(
			RequestMoneyFromCashMachineCommand::fromValues(
				$this->cashMachineBuilder->getId(),
				$this->cardBuilder->getNumber(),
				MoneyFactory::CZK((float) $arg1)
			)
		);
	}

	/**
	 * @Then the ATM should dispense cZK :arg1
	 */
	public function theAtmShouldDispenseCzk($arg1): void
	{
		$dispensedAmounts = $this->spyMoneyDispenser->getDispensedAmounts();

		self::assertCount(1, $dispensedAmounts, 'Atm dispensed more than one time.');

		self::assertEquals(MoneyFactory::CZK((float) $arg1), $dispensedAmounts[0]);
	}

	/**
	 * @Then the card balance should be cZK :arg1
	 */
	public function theCardBalanceShouldBeCzk($arg1): void
	{
		$card = $this->cardRepository->load($this->cardBuilder->getId());

		self::assertEquals(MoneyFactory::CZK((float) $arg1), $card->getBalance());
	}

	/**
	 * @Then the card should be returned
	 */
	public function theCardShouldBeReturned(): void
	{
		self::assertCount(1, $this->spyCardReturner->getReturned());
	}

	/**
	 * @Then the ATM should not dispense any money
	 */
	public function theAtmShouldNotDispenseAnyMoney(): void
	{
		$dispensedAmounts = $this->spyMoneyDispenser->getDispensedAmounts();

		self::assertCount(0, $dispensedAmounts, 'Atm actually dispensed some money.');
	}

	/**
	 * @Then the ATM should say there are insufficient funds
	 */
	public function theAtmShouldSayThereAreInsufficientFunds(): void
	{
		$messages = $this->showMessagePolicy->getShowedMessages();

		self::assertCount(1, $messages, 'No message has been shown.');

		self::assertEquals('Insufficient card balance.', $messages[0]);
	}

	/**
	 * @Given the card is disabled
	 */
	public function theCardIsDisabled(): void
	{
		throw new PendingException();
	}

	/**
	 * @Then the ATM should retain the card
	 */
	public function theAtmShouldRetainTheCard(): void
	{
		throw new PendingException();
	}

	/**
	 * @Then the ATM should say the card has been retained
	 */
	public function theAtmShouldSayTheCardHasBeenRetained(): void
	{
		throw new PendingException();
	}

	private function buildDependencies(): void
	{
		$this->cardBuilder = CardBuilder::withSomeParameters();
		$this->cashMachineBuilder = CashMachineBuilder::withSomeParameters();

		$this->cashMachineRepository = new FileCashMachineRepository();

		$this->cardRepository = new FileCardRepository();
		$getCardByNumberQuery = new FileGetCardByNumberQuery($this->cardRepository);

		$this->spyMoneyDispenser = new SpyMoneyDispenser();

		$dispenseMoneyFromCashMachineCommandHandler = new DispenseMoneyFromCashMachineCommandHandler(
			$this->spyMoneyDispenser
		);

		$withholdAmountFromCardCommandHandler = new WithholdAmountFromCardCommandHandler($this->cardRepository);

		$this->spyCardReturner = new SpyCardReturner();

		$returnCardHandler = new ReturnCardFromCashMachineCommandHandler($this->spyCardReturner);

		$this->showMessagePolicy = new ShowMessagePolicy();

		$eventBus = new SimpleEventBus(
			[
				MoneyRequestFromCashMachineAccepted::class => [
					new DispenseMoneyFromAtmPolicy($dispenseMoneyFromCashMachineCommandHandler),
					new CashMachineWithholdPolicy($withholdAmountFromCardCommandHandler),
					new ReturnCardFromAtmPolicy($returnCardHandler),
				],
				CardHasInsufficientBalanceMoneyRequestDeclined::class => [
					new ReturnCardFromAtmPolicy($returnCardHandler),
					$this->showMessagePolicy,
				],
			]
		);

		$this->requestMoneyFromCashMachineCommandHandler = new RequestMoneyFromCashMachineCommandHandler(
			$this->cashMachineRepository,
			$getCardByNumberQuery,
			$eventBus
		);
	}
}
