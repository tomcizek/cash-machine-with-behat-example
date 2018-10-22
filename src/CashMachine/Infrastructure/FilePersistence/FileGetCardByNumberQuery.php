<?php declare(strict_types = 1);

namespace CashMachine\CashMachine\Infrastructure\FilePersistence;

use CashMachine\CardManagement\DomainModel\CardRepository;
use CashMachine\CashMachine\DomainModel\CashMachine\Card;
use CashMachine\CashMachine\DomainModel\CashMachine\RequestMoney\Exception\CardWithGivenNumberNotFoundException;
use CashMachine\CashMachine\DomainModel\CashMachine\RequestMoney\GetCardByNumberQuery;

final class FileGetCardByNumberQuery implements GetCardByNumberQuery
{
	/**
	 * @var CardRepository
	 */
	private $cardRepository;

	public function __construct(CardRepository $cardRepository)
	{
		$this->cardRepository = $cardRepository;
	}

	public function query(string $cardNumber): Card
	{
		foreach ($this->cardRepository->loadAll() as $card) {
			if ($card->getNumber() === $cardNumber) {
				return Card::fromParameters(
					$card->getId(),
					$card->getNumber(),
					$card->isValid(),
					$card->getBalance()
				);
			}
		}

		throw new CardWithGivenNumberNotFoundException($cardNumber);
	}
}
