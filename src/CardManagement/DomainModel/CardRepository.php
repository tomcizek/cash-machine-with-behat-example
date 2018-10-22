<?php declare(strict_types = 1);

namespace CashMachine\CardManagement\DomainModel;

use Ramsey\Uuid\UuidInterface;

interface CardRepository
{
	public function save(Card $card): void;

	public function load(UuidInterface $cardId): Card;

	/**
	 * @return Card[]
	 */
	public function loadAll(): array;
}
