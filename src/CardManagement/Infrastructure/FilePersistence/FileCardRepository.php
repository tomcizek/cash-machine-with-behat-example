<?php declare(strict_types = 1);

namespace CashMachine\CardManagement\Infrastructure\FilePersistence;

use CashMachine\CardManagement\DomainModel\Card;
use CashMachine\CardManagement\DomainModel\CardRepository;
use CashMachine\CardManagement\DomainModel\Exception\CardDoesNotExist;
use Library\DirPathProvider;
use Ramsey\Uuid\UuidInterface;

final class FileCardRepository implements CardRepository
{
	private const DATABASE_FILE_NAME = 'FileCardRepository';

	/**
	 * @var string
	 */
	private $pathToFile;

	public function __construct()
	{
		$this->pathToFile = DirPathProvider::getLibDir() . '/../database/' . self::DATABASE_FILE_NAME;
	}

	public function save(Card $card): void
	{
		if (! file_exists($this->pathToFile)) {
			file_put_contents($this->pathToFile, json_encode([]));
		}

		$string = file_get_contents($this->pathToFile);
		assert(is_string($string));
		$arrayOfSerializedCards = json_decode($string, true);
		$arrayOfSerializedCards[$card->getId()->toString()] = serialize($card);

		file_put_contents($this->pathToFile, json_encode($arrayOfSerializedCards));
	}

	public function load(UuidInterface $cardId): Card
	{
		$string = file_get_contents($this->pathToFile);
		assert(is_string($string));
		$arrayOfSerializedCards = json_decode($string, true);

		if (! isset($arrayOfSerializedCards[$cardId->toString()])) {
			throw new CardDoesNotExist($cardId);
		}

		return unserialize($arrayOfSerializedCards[$cardId->toString()], [Card::class]);
	}

	/**
	 * @return Card[]
	 */
	public function loadAll(): array
	{
		$string = file_get_contents($this->pathToFile);
		assert(is_string($string));
		$arrayOfSerializedCards = json_decode($string, true);
		$arrayOfDeserializedCards = [];
		foreach ($arrayOfSerializedCards as $serializedCard) {
			$arrayOfDeserializedCards[] = unserialize($serializedCard, [Card::class]);
		}

		return $arrayOfDeserializedCards;
	}
}
