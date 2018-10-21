<?php declare(strict_types = 1);

namespace CashMachine\CardManagement\DomainModel;

use Money\Money;
use Ramsey\Uuid\UuidInterface;

final class Card
{
	/**
	 * @var UuidInterface
	 */
	private $id;

	/**
	 * @var string
	 */
	private $number;

	/**
	 * @var bool
	 */
	private $isValid;

	/**
	 * @var Money
	 */
	private $balance;

	private function __construct()
	{
	}

	public static function fromParameters(UuidInterface $id, string $number, bool $isValid, Money $balance): self
	{
		$instance = new self();
		$instance->number = $number;
		$instance->id = $id;
		$instance->isValid = $isValid;
		$instance->balance = $balance;

		return $instance;
	}

	public function getNumber(): string
	{
		return $this->number;
	}

	public function getId(): UuidInterface
	{
		return $this->id;
	}

	public function isValid(): bool
	{
		return $this->isValid;
	}

	public function getBalance(): Money
	{
		return $this->balance;
	}

	public function withholdMoney(Money $amount): void
	{
		$this->balance = $this->balance->subtract($amount);
	}
}
