<?php declare(strict_types = 1);

namespace CashMachine\CashMachine\Tests\DomainModel;

use CashMachine\CashMachine\DomainModel\CashMachine;
use CashMachine\CashMachine\DomainModel\CashMachine\Card;
use CashMachine\CashMachine\DomainModel\CashMachine\Exception\CardIsNotValidException;
use CashMachine\CashMachine\Tests\DomainModel\FixtureBuilders\CardBuilder;
use CashMachine\CashMachine\Tests\DomainModel\FixtureBuilders\CashMachineBuilder;
use Library\MoneyFactory;
use Money\Money;
use PHPUnit\Framework\TestCase;

final class CashMachineTest extends TestCase
{
	public function testCanInitializeWithMoney(): void
	{
		$cashMachineBuilder = CashMachineBuilder::withSomeParameters();

		$cashMachine = $this->whenInitializeWithAmount($cashMachineBuilder);

		$this->thenCashMachineInitializedWithBalance($cashMachine, $cashMachineBuilder);
	}

	public function testRequestMoneyWithCard_WhenCardIsNotValid_ShouldNotDispenseMoney(): void
	{
		$cashMachine = $this->givenCashMachineWithBalance(100000);

		$card = $this->givenCard(false, 10000);

		$this->willFailWith(CardIsNotValidException::class);

		$this->whenRequestMoney($cashMachine, $card, MoneyFactory::CZK(1000));
	}

	private function whenInitializeWithAmount(CashMachineBuilder $builder): CashMachine
	{
		return $builder->build();
	}

	private function thenCashMachineInitializedWithBalance(
		CashMachine $cashMachine,
		CashMachineBuilder $cashMachineBuilder
	): void {
		self::assertEquals($cashMachineBuilder->getId(), $cashMachine->getId());
		self::assertEquals($cashMachineBuilder->getBalance(), $cashMachine->getBalance());
	}

	private function whenRequestMoney(CashMachine $cashMachine, Card $card, Money $money): void
	{
		$cashMachine->requestMoney($card, $money);
	}

	private function givenCashMachineWithBalance(float $czkBalance): CashMachine
	{
		$cashMachine = CashMachineBuilder::withSomeParameters()
			->setBalance(MoneyFactory::CZK($czkBalance))
			->build();

		return $cashMachine;
	}

	private function givenCard(bool $isValid, float $amount): Card
	{
		$card = CardBuilder::withSomeParameters()
			->setIsValid($isValid)
			->setBalance(MoneyFactory::CZK($amount))
			->build();

		return $card;
	}

	private function willFailWith(string $exceptionClassName): void
	{
		$this->expectException($exceptionClassName);
	}
}
