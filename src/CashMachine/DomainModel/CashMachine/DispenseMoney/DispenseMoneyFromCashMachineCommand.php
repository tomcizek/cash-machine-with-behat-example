<?php declare(strict_types = 1);

namespace CashMachine\CashMachine\DomainModel\CashMachine\DispenseMoney;

use Money\Money;
use Ramsey\Uuid\UuidInterface;

final class DispenseMoneyFromCashMachineCommand
{
	/**
	 * @var UuidInterface
	 */
	private $cashMachineId;

	/**
	 * @var Money
	 */
	private $amount;

	private function __construct()
	{
	}

	public static function fromValues(
		UuidInterface $cashMachineId,
		Money $amount
	): self {
		$instance = new self();
		$instance->cashMachineId = $cashMachineId;
		$instance->amount = $amount;

		return $instance;
	}

	public function getCashMachineId(): UuidInterface
	{
		return $this->cashMachineId;
	}

	public function getAmount(): Money
	{
		return $this->amount;
	}
}
