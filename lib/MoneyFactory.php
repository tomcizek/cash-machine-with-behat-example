<?php declare(strict_types = 1);

namespace Library;

use Money\Currency;
use Money\Money;

final class MoneyFactory
{
	public static function CZK(float $amount): Money
	{
		return new Money($amount * 100, new Currency('czk'));
	}
}
