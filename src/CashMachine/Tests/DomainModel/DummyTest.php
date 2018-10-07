<?php declare(strict_types = 1);

namespace CashMachine\CashMachine\Tests\DomainModel;

use CashMachine\CashMachine\DomainModel\Dummy;
use PHPUnit\Framework\TestCase;

final class DummyTest extends TestCase
{
	public function testDummy(): void
	{
		$dummy = new Dummy();
		self::assertTrue($dummy->dummy());
	}
}
