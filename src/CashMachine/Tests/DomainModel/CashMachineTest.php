<?php declare(strict_types = 1);

namespace CashMachine\CashMachine\Tests\DomainModel;

use CashMachine\CashMachine\DomainModel\CashMachine;
use CashMachine\CashMachine\Tests\DomainModel\FixtureBuilders\CashMachineBuilder;
use PHPUnit\Framework\TestCase;

final class CashMachineTest extends TestCase
{
	public function testCanInitializeWithMoney(): void
	{
		$cashMachineBuilder = CashMachineBuilder::withSomeParameters();

		$cashMachine = $this->whenInitializeWithAmount($cashMachineBuilder);

		$this->thenCashMachineInitializedWithBalance($cashMachine, $cashMachineBuilder);
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
}
