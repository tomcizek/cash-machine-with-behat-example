<?php declare(strict_types = 1);

namespace CashMachine\CashMachine\DomainModel\CashMachine\RequestMoney;

use CashMachine\CashMachine\DomainModel\CashMachine\CashMachineRepository;
use Library\MessageBus\EventBus;

final class RequestMoneyFromCashMachineCommandHandler
{
	/**
	 * @var CashMachineRepository
	 */
	private $cashMachineRepository;

	/**
	 * @var GetCardByNumberQuery
	 */
	private $getCardByNumberQuery;

	/**
	 * @var EventBus
	 */
	private $eventBus;

	public function __construct(
		CashMachineRepository $cashMachineRepository,
		GetCardByNumberQuery $getCardByNumberQuery,
		EventBus $eventBus
	) {
		$this->cashMachineRepository = $cashMachineRepository;
		$this->getCardByNumberQuery = $getCardByNumberQuery;
		$this->eventBus = $eventBus;
	}

	public function handle(RequestMoneyFromCashMachineCommand $command): void
	{
		$cashMachine = $this->cashMachineRepository->load($command->getCashMachineId());

		$card = $this->getCardByNumberQuery->query($command->getCardNumber());

		$cashMachine->requestMoney($card, $command->getAmount());

		$this->eventBus->dispatch(
			MoneyRequestFromCashMachineAccepted::fromValues(
				$cashMachine->getId(),
				$card->getId(),
				$command->getAmount()
			)
		);
	}
}
