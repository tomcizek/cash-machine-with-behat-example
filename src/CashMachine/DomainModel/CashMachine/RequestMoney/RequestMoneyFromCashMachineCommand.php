<?php declare(strict_types = 1);

namespace CashMachine\CashMachine\DomainModel\CashMachine\RequestMoney;

use Money\Money;
use Ramsey\Uuid\UuidInterface;

final class RequestMoneyFromCashMachineCommand
{
	/**
	 * @var UuidInterface
	 */
	private $cashMachineId;

	/**
	 * @var string
	 */
	private $cardNumber;

	/**
	 * @var Money
	 */
	private $amount;

	private function __construct()
	{
	}

	public static function fromValues(
		UuidInterface $cashMachineId,
		string $cardNumber,
		Money $amount
	): self {
		$instance = new self();
		$instance->cashMachineId = $cashMachineId;
		$instance->cardNumber = $cardNumber;
		$instance->amount = $amount;

		return $instance;
	}

	public function getCashMachineId(): UuidInterface
	{
		return $this->cashMachineId;
	}

	public function getCardNumber(): string
	{
		return $this->cardNumber;
	}

	public function getAmount(): Money
	{
		return $this->amount;
	}
}
