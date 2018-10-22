<?php declare(strict_types = 1);

namespace CashMachine\CashMachine\DomainModel\CashMachine\ReturnCard;

final class ReturnCardFromCashMachineCommandHandler
{
	/**
	 * @var CardReturner
	 */
	private $cardReturner;

	public function __construct(CardReturner $moneyDispenser)
	{
		$this->cardReturner = $moneyDispenser;
	}

	public function handle(ReturnCardFromCashMachineCommand $command): void
	{
		$this->cardReturner->returnCard($command->getCashMachineId());
	}
}
