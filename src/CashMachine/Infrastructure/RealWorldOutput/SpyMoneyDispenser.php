<?php declare(strict_types = 1);

namespace CashMachine\CashMachine\Infrastructure\RealWorldOutput;

use CashMachine\CashMachine\DomainModel\CashMachine\DispenseMoney\MoneyDispenser;
use Money\Money;

final class SpyMoneyDispenser implements MoneyDispenser
{
	/**
	 * @var Money[]
	 */
	private $dispensedAmounts = [];

	public function dispense(Money $money): void
	{
		$this->dispensedAmounts[] = $money;
	}

	/**
	 * @return Money[]
	 */
	public function getDispensedAmounts(): array
	{
		return $this->dispensedAmounts;
	}
}
