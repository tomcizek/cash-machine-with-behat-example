<?php declare(strict_types = 1);

namespace CashMachine\CashMachine\Infrastructure\FakePersistence;

use CashMachine\CashMachine\DomainModel\CashMachine;
use CashMachine\CashMachine\DomainModel\CashMachine\Exception\CashMachineDoesNotExist;
use Ramsey\Uuid\UuidInterface;

final class InMemoryCashMachineRepository implements CashMachine\CashMachineRepository
{
	/**
	 * @var string[] serialized array of CashMachine[]
	 */
	private $cashMachines = [];

	public function save(CashMachine $cashMachine): void
	{
		$this->cashMachines[$cashMachine->getId()->toString()] = serialize($cashMachine);
	}

	public function load(UuidInterface $cashMachineId): CashMachine
	{
		if (! isset($this->cashMachines[$cashMachineId->toString()])) {
			throw new CashMachineDoesNotExist($cashMachineId);
		}
		/** @var CashMachine $cashMachine */
		$cashMachine = unserialize($this->cashMachines[$cashMachineId->toString()], [CashMachine::class]);

		return $cashMachine;
	}
}
