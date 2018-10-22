<?php declare(strict_types = 1);

namespace CashMachine\CashMachine\Infrastructure\RealWorldOutput;

use CashMachine\CashMachine\DomainModel\CashMachine\ReturnCard\CardReturner;
use Ramsey\Uuid\UuidInterface;

final class SpyCardReturner implements CardReturner
{
	/**
	 * @var UuidInterface[]
	 */
	private $returned = [];

	public function returnCard(UuidInterface $cashMachineId): void
	{
		$this->returned[] = $cashMachineId;
	}

	/**
	 * @return UuidInterface[]
	 */
	public function getReturned(): array
	{
		return $this->returned;
	}
}
