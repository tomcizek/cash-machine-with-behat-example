<?php declare(strict_types = 1);

namespace CashMachine\CardManagement\Tests\DomainModel;

use CashMachine\CardManagement\DomainModel\Card;
use CashMachine\CardManagement\Tests\DomainModel\Card\FixtureBuilders\CardBuilder;
use Library\MoneyFactory;
use PHPUnit\Framework\TestCase;

final class CardTest extends TestCase
{
	public function testWithholdMoneyFromCard_ShouldWithholdMoney(): void
	{
		$card = $this->givenCard(false, 10000);

		$this->whenWithholdMoney($card, 1000);

		$this->thenCardBalanceIs($card, 9000);
	}

	private function givenCard(bool $isValid, float $amount): Card
	{
		$card = CardBuilder::withSomeParameters()
			->setIsValid($isValid)
			->setBalance(MoneyFactory::CZK($amount))
			->build();

		return $card;
	}

	private function whenWithholdMoney(Card $card, float $czk): void
	{
		$card->withholdMoney(MoneyFactory::CZK($czk));
	}

	private function thenCardBalanceIs(Card $card, float $czk): void
	{
		self::assertEquals(MoneyFactory::CZK($czk), $card->getBalance());
	}
}
