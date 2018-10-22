<?php declare(strict_types = 1);

namespace CashMachine\CashMachine\DomainModel\CashMachine\ReturnCard;

use Ramsey\Uuid\UuidInterface;

interface CardReturner
{
	public function returnCard(UuidInterface $cashMachineId): void;
}
