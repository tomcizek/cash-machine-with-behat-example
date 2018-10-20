<?php declare(strict_types = 1);

namespace CashMachine\CashMachine\DomainModel;

use Money\Money;
use Ramsey\Uuid\UuidInterface;

final class CashMachine
{
	/**
	 * @var UuidInterface
	 */
	private $id;

	/**
	 * @var Money
	 */
	private $balance;

	private function __construct()
	{
	}

	public static function initializeWithAmount(UuidInterface $id, Money $money): self
	{
		$instance = new self();
		$instance->id = $id;
		$instance->balance = $money;

		return $instance;
	}

	public function getId(): UuidInterface
	{
		return $this->id;
	}

	public function getBalance(): Money
	{
		return $this->balance;
	}
}
