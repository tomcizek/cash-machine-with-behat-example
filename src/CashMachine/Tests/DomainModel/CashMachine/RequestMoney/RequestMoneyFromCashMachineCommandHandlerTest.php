<?php declare(strict_types = 1);

namespace CashMachine\CashMachine\Tests\DomainModel\CashMachine\RequestMoney;

use CashMachine\CashMachine\DomainModel\CashMachine;
use CashMachine\CashMachine\DomainModel\CashMachine\Card;
use CashMachine\CashMachine\DomainModel\CashMachine\CashMachineRepository;
use CashMachine\CashMachine\DomainModel\CashMachine\RequestMoney\MoneyRequestFromCashMachineAccepted;
use CashMachine\CashMachine\DomainModel\CashMachine\RequestMoney\RequestMoneyFromCashMachineCommand;
use CashMachine\CashMachine\DomainModel\CashMachine\RequestMoney\RequestMoneyFromCashMachineCommandHandler;
use CashMachine\CashMachine\Infrastructure\FakePersistence\FakeGetCardByNumberQuery;
use CashMachine\CashMachine\Infrastructure\FakePersistence\InMemoryCashMachineRepository;
use CashMachine\CashMachine\Tests\DomainModel\FixtureBuilders\CardBuilder;
use CashMachine\CashMachine\Tests\DomainModel\FixtureBuilders\CashMachineBuilder;
use Library\MessageBus\EventBusSpy;
use Library\MoneyFactory;
use PHPUnit\Framework\TestCase;

final class RequestMoneyFromCashMachineCommandHandlerTest extends TestCase
{
	/**
	 * @var CashMachineRepository
	 */
	private $cashMachineRepository;

	/**
	 * @var FakeGetCardByNumberQuery
	 */
	private $cardNumberQuery;

	/**
	 * @var EventBusSpy
	 */
	private $eventBus;

	/**
	 * @var RequestMoneyFromCashMachineCommandHandler
	 */
	private $sut;

	protected function setUp(): void
	{
		parent::setUp();

		$this->cashMachineRepository = new InMemoryCashMachineRepository();
		$this->cardNumberQuery = new FakeGetCardByNumberQuery();
		$this->eventBus = new EventBusSpy();

		$this->sut = new RequestMoneyFromCashMachineCommandHandler(
			$this->cashMachineRepository,
			$this->cardNumberQuery,
			$this->eventBus
		);
	}

	public function testCanHandle(): void
	{
		$cashMachine = $this->givenCashMachineExists(100000);

		$card = $this->givenCardExists(true, 10000);

		$requestedMoney = MoneyFactory::CZK(1000);

		$this->whenHandle(
			RequestMoneyFromCashMachineCommand::fromValues(
				$cashMachine->getId(),
				$card->getNumber(),
				$requestedMoney
			)
		);

		$this->thenCorrectEventDispatched(
			MoneyRequestFromCashMachineAccepted::fromValues(
				$cashMachine->getId(),
				$card->getId(),
				$requestedMoney
			)
		);
	}

	private function whenHandle(RequestMoneyFromCashMachineCommand $command): void
	{
		$this->sut->handle($command);
	}

	private function givenCashMachineExists(float $czkBalance): CashMachine
	{
		$cashMachine = CashMachineBuilder::withSomeParameters()
			->setBalance(MoneyFactory::CZK($czkBalance))
			->build();

		$this->cashMachineRepository->save($cashMachine);

		return $cashMachine;
	}

	private function givenCardExists(bool $isValid, float $czkBalance): Card
	{
		$card = CardBuilder::withSomeParameters()
			->setBalance(MoneyFactory::CZK($czkBalance))
			->setIsValid($isValid)
			->build();

		$this->cardNumberQuery->willReturn($card);

		return $card;
	}

	private function thenCorrectEventDispatched(MoneyRequestFromCashMachineAccepted $event): void
	{
		$dispathed = $this->eventBus->getDispatched();

		self::assertEquals($dispathed[0], $event);
	}
}
