<?php declare(strict_types = 1);

namespace CashMachine\CashMachine\Tests\DomainModel\FixtureBuilders;

use CashMachine\CashMachine\DomainModel\CashMachine;
use Library\MoneyFactory;
use Money\Money;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class CashMachineBuilder
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

	public static function withSomeParameters(): self
	{
		$instance = new self();
		$instance->setId(Uuid::uuid4());
		$instance->setBalance(MoneyFactory::CZK(100));

		return $instance;
	}

	public function build(): CashMachine
	{
		return CashMachine::initializeWithAmount(
			$this->id,
			$this->balance
		);
	}

	public function getId(): UuidInterface
	{
		return $this->id;
	}

	public function setId(UuidInterface $id): self
	{
		$this->id = $id;

		return $this;
	}

	public function getBalance(): Money
	{
		return $this->balance;
	}

	public function setBalance(Money $balance): self
	{
		$this->balance = $balance;

		return $this;
	}
}
