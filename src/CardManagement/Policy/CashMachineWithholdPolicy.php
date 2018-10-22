<?php declare(strict_types = 1);

namespace CashMachine\CardManagement\Policy;

use CashMachine\CardManagement\DomainModel\Card\WithholdMoney\WithholdAmountFromCardCommand;
use CashMachine\CardManagement\DomainModel\Card\WithholdMoney\WithholdAmountFromCardCommandHandler;
use CashMachine\CashMachine\DomainModel\CashMachine\RequestMoney\MoneyRequestFromCashMachineAccepted;

final class CashMachineWithholdPolicy
{
	/**
	 * @var WithholdAmountFromCardCommandHandler
	 */
	private $handler;

	public function __construct(WithholdAmountFromCardCommandHandler $withholdAmountFromCardCommandHandler)
	{
		$this->handler = $withholdAmountFromCardCommandHandler;
	}

	public function onMoneyRequestFromCashMachineAccepted(MoneyRequestFromCashMachineAccepted $event): void
	{
		$command = WithholdAmountFromCardCommand::fromValues(
			$event->getCardId(),
			$event->getAmount()
		);
		$this->handler->handle($command);
	}
}
