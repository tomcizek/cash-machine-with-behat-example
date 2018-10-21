<?php declare(strict_types = 1);

namespace CashMachine\CashMachine\DomainModel\CashMachine\RequestMoney;

use Money\Money;
use Ramsey\Uuid\UuidInterface;

final class MoneyRequestFromCashMachineAccepted
{
	/**
	 * @var UuidInterface
	 */
	private $cashMachineId;

	/**
	 * @var UuidInterface
	 */
	private $cardId;

	/**
	 * @var Money
	 */
	private $amount;

	private function __construct()
	{
	}

	public static function fromValues(UuidInterface $cashMachineId, UuidInterface $cardId, Money $amount): self
	{
		$instance = new self();

		$instance->cashMachineId = $cashMachineId;
		$instance->cardId = $cardId;
		$instance->amount = $amount;

		return $instance;
	}

	public function getCashMachineId(): UuidInterface
	{
		return $this->cashMachineId;
	}

	public function getCardId(): UuidInterface
	{
		return $this->cardId;
	}

	public function getAmount(): Money
	{
		return $this->amount;
	}
}
