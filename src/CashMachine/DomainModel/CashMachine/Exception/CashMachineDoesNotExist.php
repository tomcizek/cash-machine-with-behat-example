<?php declare(strict_types = 1);

namespace CashMachine\CashMachine\DomainModel\CashMachine\Exception;

use Exception;
use Ramsey\Uuid\UuidInterface;
use Throwable;

final class CashMachineDoesNotExist extends Exception
{
	public function __construct(UuidInterface $uuid, int $code = 0, ?Throwable $previous = null)
	{
		parent::__construct(
			sprintf('Cash Machine with id %s does not exist.', $uuid->toString()),
			$code,
			$previous
		);
	}
}
