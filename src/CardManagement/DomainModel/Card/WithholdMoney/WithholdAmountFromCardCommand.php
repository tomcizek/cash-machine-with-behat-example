<?php declare(strict_types = 1);

namespace CashMachine\CardManagement\DomainModel\Card\WithholdMoney;

use Money\Money;
use Ramsey\Uuid\UuidInterface;

final class WithholdAmountFromCardCommand
{
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

	public static function fromValues(
		UuidInterface $cardId,
		Money $amount
	): self {
		$instance = new self();
		$instance->cardId = $cardId;
		$instance->amount = $amount;

		return $instance;
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
