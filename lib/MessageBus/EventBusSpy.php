<?php declare(strict_types = 1);

namespace Library\MessageBus;

final class EventBusSpy extends EventBus
{
	/**
	 * @var mixed[]
	 */
	private $dispatched = [];

	/**
	 * @param mixed $message
	 */
	public function dispatch($message): void
	{
		$this->dispatched[] = $message;
	}

	/**
	 * @return mixed[]
	 */
	public function getDispatched(): array
	{
		return $this->dispatched;
	}
}
