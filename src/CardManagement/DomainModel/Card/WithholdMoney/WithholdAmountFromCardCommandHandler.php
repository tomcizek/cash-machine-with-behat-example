<?php declare(strict_types = 1);

namespace CashMachine\CardManagement\DomainModel\Card\WithholdMoney;

use CashMachine\CardManagement\DomainModel\CardRepository;

final class WithholdAmountFromCardCommandHandler
{
	/**
	 * @var CardRepository
	 */
	private $cardRepository;

	public function __construct(CardRepository $cardRepository)
	{
		$this->cardRepository = $cardRepository;
	}

	public function handle(WithholdAmountFromCardCommand $command): void
	{
		$card = $this->cardRepository->load($command->getCardId());
		$card->withholdMoney($command->getAmount());
		$this->cardRepository->save($card);
	}
}
