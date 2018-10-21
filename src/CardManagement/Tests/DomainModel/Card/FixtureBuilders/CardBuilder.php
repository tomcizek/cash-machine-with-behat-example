<?php declare(strict_types = 1);

namespace CashMachine\CardManagement\Tests\DomainModel\Card\FixtureBuilders;

use CashMachine\CardManagement\DomainModel\Card;
use Library\MoneyFactory;
use Money\Money;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class CardBuilder
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

	public static function withSomeParameters(): self
	{
		$instance = new self();

		$instance->setId(Uuid::uuid4());
		$instance->setIsValid(true);
		$instance->setNumber(bin2hex(random_bytes(10)));
		$instance->setBalance(MoneyFactory::CZK(100));

		return $instance;
	}

	public function build(): Card
	{
		return Card::fromParameters(
			$this->id,
			$this->number,
			$this->isValid,
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

	public function getNumber(): string
	{
		return $this->number;
	}

	public function setNumber(string $number): self
	{
		$this->number = $number;

		return $this;
	}

	public function isValid(): bool
	{
		return $this->isValid;
	}

	public function setIsValid(bool $isValid): self
	{
		$this->isValid = $isValid;

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
