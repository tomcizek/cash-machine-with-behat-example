<?php declare(strict_types = 1);

namespace Library\MessageBus;

use ReflectionClass;

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
		$reflect = new ReflectionClass($message);
		$methodName = 'on' . $reflect->getShortName();
		foreach ($this->listeners[get_class($message)] as $listener) {
			$listener->{$methodName}($message);
		}
	}
}
