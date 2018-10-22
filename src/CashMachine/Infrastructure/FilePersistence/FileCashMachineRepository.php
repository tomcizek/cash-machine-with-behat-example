<?php declare(strict_types = 1);

namespace CashMachine\CashMachine\Infrastructure\FilePersistence;

use CashMachine\CashMachine\DomainModel\CashMachine;
use CashMachine\CashMachine\DomainModel\CashMachine\Exception\CashMachineDoesNotExist;
use Library\DirPathProvider;
use Ramsey\Uuid\UuidInterface;

final class FileCashMachineRepository implements CashMachine\CashMachineRepository
{
	private const DATABASE_FILE_NAME = 'FileCashMachineRepository';

	/**
	 * @var string
	 */
	private $pathToFile;

	public function __construct()
	{
		$this->pathToFile = DirPathProvider::getLibDir() . '/../database/' . self::DATABASE_FILE_NAME;
	}

	public function save(CashMachine $cashMachine): void
	{
		if (! file_exists($this->pathToFile)) {
			file_put_contents($this->pathToFile, json_encode([]));
		}

		$string = file_get_contents($this->pathToFile);
		assert(is_string($string));
		$arrayOfSerializedCashMachines = json_decode($string, true);
		$arrayOfSerializedCashMachines[$cashMachine->getId()->toString()] = serialize($cashMachine);

		file_put_contents($this->pathToFile, json_encode($arrayOfSerializedCashMachines));
	}

	public function load(UuidInterface $cashMachineId): CashMachine
	{
		$string = file_get_contents($this->pathToFile);
		assert(is_string($string));
		$arrayOfSerializedCashMachines = json_decode($string, true);

		if (! isset($arrayOfSerializedCashMachines[$cashMachineId->toString()])) {
			throw new CashMachineDoesNotExist($cashMachineId);
		}

		return unserialize($arrayOfSerializedCashMachines[$cashMachineId->toString()], [CashMachine::class]);
	}
}
