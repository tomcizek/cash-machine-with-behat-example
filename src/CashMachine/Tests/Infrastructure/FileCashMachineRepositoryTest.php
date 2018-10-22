<?php declare(strict_types = 1);

namespace CashMachine\CashMachine\Tests\Infrastructure;

use CashMachine\CashMachine\Infrastructure\FilePersistence\FileCashMachineRepository;
use CashMachine\CashMachine\Tests\DomainModel\FixtureBuilders\CashMachineBuilder;
use Library\MoneyFactory;
use PHPStan\Testing\TestCase;

final class FileCashMachineRepositoryTest extends TestCase
{
	/**
	 * @var FileCashMachineRepository
	 */
	private $sut;

	protected function setUp(): void
	{
		parent::setUp();

		$this->sut = new FileCashMachineRepository();
	}

	public function testSave_WhenOneAlready_ShouldSaveProperly(): void
	{
		$cashMachine1 = CashMachineBuilder::withSomeParameters()->setBalance(MoneyFactory::CZK(1))->build();
		$cashMachine2 = CashMachineBuilder::withSomeParameters()->setBalance(MoneyFactory::CZK(2))->build();

		$this->sut->save($cashMachine1);
		$this->sut->save($cashMachine2);

		self::assertEquals($cashMachine1, $this->sut->load($cashMachine1->getId()));
		self::assertEquals($cashMachine2, $this->sut->load($cashMachine2->getId()));
	}
}
