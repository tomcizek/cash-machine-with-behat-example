<?php declare(strict_types = 1);

namespace CashMachine\CashMachine\DomainModel\CashMachine\RequestMoney\Exception;

use CashMachine\CashMachine\DomainModel\CashMachine\Exception\CashMachineException;
use Throwable;

final class CardWithGivenNumberNotFoundException extends CashMachineException
{
	public function __construct(string $number, int $code = 0, ?Throwable $previous = null)
	{
		parent::__construct(
			sprintf('Card with number %s does not exist.', $number),
			$code,
			$previous
		);
	}
}
