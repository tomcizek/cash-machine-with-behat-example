<?php declare(strict_types = 1);

namespace CashMachine\CashMachine\DomainModel\CashMachine\DispenseMoney;

final class DispenseMoneyFromCashMachineCommandHandler
{
	/**
	 * @var MoneyDispenser
	 */
	private $moneyDispenser;

	public function __construct(MoneyDispenser $moneyDispenser)
	{
		$this->moneyDispenser = $moneyDispenser;
	}

	public function handle(DispenseMoneyFromCashMachineCommand $command): void
	{
		$this->moneyDispenser->dispense($command->getAmount());
	}
}
