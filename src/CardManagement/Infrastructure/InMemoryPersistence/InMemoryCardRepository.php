<?php declare(strict_types = 1);

namespace CashMachine\CardManagement\Infrastructure\InMemoryPersistence;

use CashMachine\CardManagement\DomainModel\Card;
use CashMachine\CardManagement\DomainModel\CardRepository;
use CashMachine\CardManagement\DomainModel\Exception\CardDoesNotExist;
use Ramsey\Uuid\UuidInterface;

final class InMemoryCardRepository implements CardRepository
{
	/**
	 * @var string[] serialized array of Card[]
	 */
	private $cards = [];

	public function save(Card $card): void
	{
		$this->cards[$card->getId()->toString()] = serialize($card);
	}

	public function load(UuidInterface $cardId): Card
	{
		if (! isset($this->cards[$cardId->toString()])) {
			throw new CardDoesNotExist($cardId);
		}

		/** @var Card $card */
		$card = unserialize($this->cards[$cardId->toString()], [Card::class]);

		return $card;
	}

	/**
	 * @return Card[]
	 */
	public function loadAll(): array
	{
		$unserialized = [];
		foreach ($this->cards as $card) {
			$unserialized = unserialize($card, [Card::class]);
		}

		return $unserialized;
	}
}
