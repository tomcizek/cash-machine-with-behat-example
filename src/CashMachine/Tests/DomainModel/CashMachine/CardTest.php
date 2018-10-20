<?php declare(strict_types = 1);

namespace CashMachine\CashMachine\Tests\DomainModel\CashMachine;

use CashMachine\CashMachine\DomainModel\CashMachine\Card;
use CashMachine\CashMachine\Tests\DomainModel\FixtureBuilders\CardBuilder;
use PHPUnit\Framework\TestCase;

final class CardTest extends TestCase
{
	public function testCanCreate(): void
	{
		$cardBuilder = CardBuilder::withSomeParameters();

		$card = $this->whenCreateCard($cardBuilder);

		$this->thenExpectedCardCreated($cardBuilder, $card);
	}

	private function whenCreateCard(CardBuilder $cardBuilder): Card
	{
		return $cardBuilder->build();
	}

	private function thenExpectedCardCreated(CardBuilder $cardBuilder, Card $card): void
	{
		self::assertEquals($cardBuilder->getId(), $card->getId());
		self::assertEquals($cardBuilder->getNumber(), $card->getNumber());
		self::assertEquals($cardBuilder->isValid(), $card->isValid());
		self::assertEquals($cardBuilder->getBalance(), $card->getBalance());
	}
}
