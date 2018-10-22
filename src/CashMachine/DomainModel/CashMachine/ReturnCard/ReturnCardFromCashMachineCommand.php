<?php declare(strict_types = 1);

namespace CashMachine\CashMachine\DomainModel\CashMachine\ReturnCard;

use Ramsey\Uuid\UuidInterface;

final class ReturnCardFromCashMachineCommand
{
	/**
	 * @var UuidInterface
	 */
	private $cashMachineId;

	private function __construct()
	{
	}

	public static function fromCashMachineId(
		UuidInterface $cashMachineId
	): self {
		$instance = new self();
		$instance->cashMachineId = $cashMachineId;

		return $instance;
	}

	public function getCashMachineId(): UuidInterface
	{
		return $this->cashMachineId;
	}
}
