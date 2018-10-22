<?php declare(strict_types = 1);

namespace CashMachine\CashMachine\DomainModel\CashMachine\DispenseMoney;

use Money\Money;

interface MoneyDispenser
{
	public function dispense(Money $money): void;
}
