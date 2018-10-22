<?php declare(strict_types = 1);

namespace CashMachine\CardManagement\Tests\DomainModel\Card\WithholdMoney;

use CashMachine\CardManagement\DomainModel\Card;
use CashMachine\CardManagement\DomainModel\Card\WithholdMoney\WithholdAmountFromCardCommand;
use CashMachine\CardManagement\DomainModel\Card\WithholdMoney\WithholdAmountFromCardCommandHandler;
use CashMachine\CardManagement\DomainModel\CardRepository;
use CashMachine\CardManagement\Infrastructure\InMemoryPersistence\InMemoryCardRepository;
use CashMachine\CardManagement\Tests\DomainModel\Card\FixtureBuilders\CardBuilder;
use Library\MoneyFactory;
use Money\Money;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;

final class WithholdAmountFromCardCommandHandlerTest extends TestCase
{
	/**
	 * @var CardRepository
	 */
	private $cardRepository;

	/**
	 * @var WithholdAmountFromCardCommandHandler
	 */
	private $sut;

	protected function setUp(): void
	{
		parent::setUp();

		$this->cardRepository = new InMemoryCardRepository();

		$this->sut = new WithholdAmountFromCardCommandHandler(
			$this->cardRepository
		);
	}

	public function testCanHandle(): void
	{
		$card = $this->givenCardExists(10000);

		$withdrawedMoney = MoneyFactory::CZK(1000);

		$this->whenHandle(
			WithholdAmountFromCardCommand::fromValues(
				$card->getId(),
				$withdrawedMoney
			)
		);

		$this->thenCorrectBalanceOnCard($card->getId(), MoneyFactory::CZK(9000));
	}

	private function whenHandle(WithholdAmountFromCardCommand $command): void
	{
		$this->sut->handle($command);
	}

	private function givenCardExists(float $czkBalance): Card
	{
		$card = CardBuilder::withSomeParameters()
			->setBalance(MoneyFactory::CZK($czkBalance))
			->setIsValid(true)
			->build();

		$this->cardRepository->save($card);

		return $card;
	}

	private function thenCorrectBalanceOnCard(
		UuidInterface $cardId,
		Money $expectedBalance
): void {
		$card = $this->cardRepository->load($cardId);

		self::assertEquals($expectedBalance, $card->getBalance());
	}
}
