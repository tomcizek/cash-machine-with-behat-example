<?php declare(strict_types = 1);

namespace CashMachine\CashMachine\Policy;

use CashMachine\CashMachine\DomainModel\CashMachine\RequestMoney\CardHasInsufficientBalanceMoneyRequestDeclined;

final class ShowMessagePolicy
{
	/**
	 * @var string[]
	 */
	private $showedMessages = [];

	public function onCardHasInsufficientBalanceMoneyRequestDeclined(CardHasInsufficientBalanceMoneyRequestDeclined $event): void
	{
		$this->showedMessages[] = 'Insufficient card balance.';
	}

	/**
	 * @return string[]
	 */
	public function getShowedMessages(): array
	{
		return $this->showedMessages;
	}
}
