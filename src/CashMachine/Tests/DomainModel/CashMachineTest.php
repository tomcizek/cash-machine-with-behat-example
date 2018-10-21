<?php declare(strict_types = 1);

namespace CashMachine\CashMachine\Tests\DomainModel;

use CashMachine\CashMachine\DomainModel\CashMachine;
use CashMachine\CashMachine\DomainModel\CashMachine\Card;
use CashMachine\CashMachine\DomainModel\CashMachine\Exception\CardHasInsufficientBalanceException;
use CashMachine\CashMachine\DomainModel\CashMachine\Exception\CardIsNotValidException;
use CashMachine\CashMachine\DomainModel\CashMachine\Exception\CashMachineHasInsufficientBalanceException;
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

	public function testRequestMoneyWithCard_WhenCardHasInsufficientBalance_ShouldNotDispenseMoney(): void
	{
		$cashMachine = $this->givenCashMachineWithBalance(100000);

		$card = $this->givenCard(true, 100);

		$this->willFailWith(CardHasInsufficientBalanceException::class);

		$this->whenRequestMoney($cashMachine, $card, MoneyFactory::CZK(1000));
	}

	public function testRequestMoneyWithCard_WhenCashMachineHasInsufficientBalance_ShouldNotDispenseMoney(): void
	{
		$cashMachine = $this->givenCashMachineWithBalance(100);

		$card = $this->givenCard(true, 1000);

		$this->willFailWith(CashMachineHasInsufficientBalanceException::class);

		$this->whenRequestMoney($cashMachine, $card, MoneyFactory::CZK(1000));
	}

	public function testRequestMoneyWithCard_WithValidCardAndSufficientBalance_ShouldNotDispenseMoney(): void
	{
		$cashMachine = $this->givenCashMachineWithBalance(1000);

		$card = $this->givenCard(true, 1000);

		$this->whenRequestMoney($cashMachine, $card, MoneyFactory::CZK(1000));

		$this->thenCashMachineBalanceIs($cashMachine, 0);
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

	private function thenCashMachineBalanceIs(CashMachine $cashMachine, float $balance): void
	{
		self::assertEquals(MoneyFactory::CZK($balance), $cashMachine->getBalance());
	}
}
