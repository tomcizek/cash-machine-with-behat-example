<?php declare(strict_types = 1);

namespace CashMachine\CashMachine\DomainModel\CashMachine;

use CashMachine\CashMachine\DomainModel\CashMachine;
use Ramsey\Uuid\UuidInterface;

interface CashMachineRepository
{
	public function save(CashMachine $cashMachine): void;

	public function load(UuidInterface $cashMachineId): CashMachine;
}
