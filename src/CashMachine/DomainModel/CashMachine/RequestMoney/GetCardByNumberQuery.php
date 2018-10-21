<?php declare(strict_types = 1);

namespace CashMachine\CashMachine\DomainModel\CashMachine\RequestMoney;

use CashMachine\CashMachine\DomainModel\CashMachine\Card;

interface GetCardByNumberQuery
{
	public function query(string $cardNumber): Card;
}
