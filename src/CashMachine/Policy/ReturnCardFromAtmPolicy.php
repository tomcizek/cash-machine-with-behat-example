<?php declare(strict_types = 1);

namespace CashMachine\CashMachine\Policy;

use CashMachine\CashMachine\DomainModel\CashMachine\RequestMoney\MoneyRequestFromCashMachineAccepted;
use CashMachine\CashMachine\DomainModel\CashMachine\ReturnCard\ReturnCardFromCashMachineCommand;
use CashMachine\CashMachine\DomainModel\CashMachine\ReturnCard\ReturnCardFromCashMachineCommandHandler;

final class ReturnCardFromAtmPolicy
{
	/**
	 * @var ReturnCardFromCashMachineCommandHandler
	 */
	private $returnCardFromCashMachineCommandHandler;

	public function __construct(
		ReturnCardFromCashMachineCommandHandler $returnCardFromCashMachineCommandHandler
	) {
		$this->returnCardFromCashMachineCommandHandler = $returnCardFromCashMachineCommandHandler;
	}

	public function onMoneyRequestFromCashMachineAccepted(MoneyRequestFromCashMachineAccepted $event): void
	{
		$command = ReturnCardFromCashMachineCommand::fromCashMachineId(
			$event->getCashMachineId()
		);
		$this->returnCardFromCashMachineCommandHandler->handle($command);
	}
}
