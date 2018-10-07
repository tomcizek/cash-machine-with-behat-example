<?php declare(strict_types = 1);

namespace CashMachine\Features;

use Behat\Behat\Context\Context;

/**
 * Defines application features from the specific context.
 */
final class FeatureContext implements Context
{
	/**
	 * Initializes context.
	 *
	 * Every scenario gets its own context instance.
	 * You can also pass arbitrary arguments to the
	 * context constructor through behat.yml.
	 */
	public function __construct()
	{
	}
}
