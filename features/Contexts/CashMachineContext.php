<?php declare(strict_types = 1);

namespace CashMachine\Features\Contexts;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use CashMachine\CashMachine\Tests\DomainModel\FixtureBuilders\CardBuilder;
use CashMachine\CashMachine\Tests\DomainModel\FixtureBuilders\CashMachineBuilder;
use Library\MoneyFactory;

/**
 * Defines application features from the specific context.
 */
final class CashMachineContext implements Context
{
	/**
	 * @var CardBuilder
	 */
	private $cardBuilder;

	/**
	 * @var CashMachineBuilder
	 */
	private $cashMachineBuilder;

	public function __construct()
	{
		$this->cardBuilder = CardBuilder::withSomeParameters();
		$this->cashMachineBuilder = CashMachineBuilder::withSomeParameters();
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
		throw new PendingException();
	}

	/**
	 * @Then the ATM should dispense cZK :arg1
	 */
	public function theAtmShouldDispenseCzk($arg1): void
	{
		throw new PendingException();
	}

	/**
	 * @Then the card balance should be cZK :arg1
	 */
	public function theCardBalanceShouldBeCzk($arg1): void
	{
		throw new PendingException();
	}

	/**
	 * @Then the card should be returned
	 */
	public function theCardShouldBeReturned(): void
	{
		throw new PendingException();
	}

	/**
	 * @Then the ATM should not dispense any money
	 */
	public function theAtmShouldNotDispenseAnyMoney(): void
	{
		throw new PendingException();
	}

	/**
	 * @Then the ATM should say there are insufficient funds
	 */
	public function theAtmShouldSayThereAreInsufficientFunds(): void
	{
		throw new PendingException();
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
}
