<?php declare(strict_types = 1);

namespace CashMachine\CashMachine\Policy;

use CashMachine\CashMachine\DomainModel\CashMachine\DispenseMoney\DispenseMoneyFromCashMachineCommand;
use CashMachine\CashMachine\DomainModel\CashMachine\DispenseMoney\DispenseMoneyFromCashMachineCommandHandler;
use CashMachine\CashMachine\DomainModel\CashMachine\RequestMoney\MoneyRequestFromCashMachineAccepted;

final class DispenseMoneyFromAtmPolicy
{
	/**
	 * @var DispenseMoneyFromCashMachineCommandHandler
	 */
	private $dispenseMoneyFromCashMachineCommandHandler;

	public function __construct(
		DispenseMoneyFromCashMachineCommandHandler $dispenseMoneyFromCashMachineCommandHandler
	) {
		$this->dispenseMoneyFromCashMachineCommandHandler = $dispenseMoneyFromCashMachineCommandHandler;
	}

	public function onMoneyRequestFromCashMachineAccepted(MoneyRequestFromCashMachineAccepted $event): void
	{
		$command = DispenseMoneyFromCashMachineCommand::fromValues(
			$event->getCashMachineId(),
			$event->getAmount()
		);
		$this->dispenseMoneyFromCashMachineCommandHandler->handle($command);
	}
}
