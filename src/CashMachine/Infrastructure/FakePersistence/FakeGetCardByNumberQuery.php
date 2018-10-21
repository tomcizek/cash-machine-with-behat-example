<?php declare(strict_types = 1);

namespace CashMachine\CashMachine\Infrastructure\FakePersistence;

use CashMachine\CashMachine\DomainModel\CashMachine\Card;
use CashMachine\CashMachine\DomainModel\CashMachine\RequestMoney\GetCardByNumberQuery;

final class FakeGetCardByNumberQuery implements GetCardByNumberQuery
{
	/**
	 * @var Card
	 */
	private $willReturn;

	public function willReturn(Card $card): void
	{
		$this->willReturn = $card;
	}

	public function query(string $cardNumber): Card
	{
		return $this->willReturn;
	}
}
