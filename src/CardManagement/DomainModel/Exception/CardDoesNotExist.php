<?php declare(strict_types = 1);

namespace CashMachine\CardManagement\DomainModel\Exception;

use Exception;
use Ramsey\Uuid\UuidInterface;
use Throwable;

final class CardDoesNotExist extends Exception
{
	public function __construct(UuidInterface $uuid, int $code = 0, ?Throwable $previous = null)
	{
		parent::__construct(
			sprintf('Card with id %s does not exist.', $uuid->toString()),
			$code,
			$previous
		);
	}
}
