<?php declare(strict_types = 1);

namespace Library\MessageBus;

final class SimpleEventBus extends EventBus
{
	/**
	 * @var mixed[]
	 */
	private $listeners = [];

	/**
	 * @param mixed[] $routesAndListeners
	 */
	public function __construct(array $routesAndListeners)
	{
		$this->listeners = $routesAndListeners;
	}

	/**
	 * @param mixed $message
	 */
	public function dispatch($message): void
	{
		if (! isset($this->listeners[get_class($message)])) {
			return;
		}
		foreach ($this->listeners[get_class($message)] as $listener) {
			$listener->process($message);
		}
	}
}
