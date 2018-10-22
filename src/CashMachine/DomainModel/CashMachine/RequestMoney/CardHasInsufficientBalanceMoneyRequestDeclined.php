<?php declare(strict_types = 1);

namespace CashMachine\CashMachine\DomainModel\CashMachine\RequestMoney;

use Money\Money;
use Ramsey\Uuid\UuidInterface;

final class CardHasInsufficientBalanceMoneyRequestDeclined
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
	private $requestedAmount;

	private function __construct()
	{
	}

	public static function fromValues(UuidInterface $cashMachineId, UuidInterface $cardId, Money $requestedAmount): self
	{
		$instance = new self();

		$instance->cashMachineId = $cashMachineId;
		$instance->cardId = $cardId;
		$instance->requestedAmount = $requestedAmount;

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

	public function getRequestedAmount(): Money
	{
		return $this->requestedAmount;
	}
}
