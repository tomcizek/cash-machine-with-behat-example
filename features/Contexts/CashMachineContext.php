<?php declare(strict_types = 1);

namespace CashMachine\Features\Contexts;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;

/**
 * Defines application features from the specific context.
 */
final class CashMachineContext implements Context
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

    /**
     * @Given the card balance is cZK :arg1
     */
    public function theCardBalanceIsCzk($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Given the card is valid
     */
    public function theCardIsValid()
    {
        throw new PendingException();
    }

    /**
     * @Given the machine contains enough money
     */
    public function theMachineContainsEnoughMoney()
    {
        throw new PendingException();
    }

    /**
     * @When the Card Holder requests cZK :arg1
     */
    public function theCardHolderRequestsCzk($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then the ATM should dispense cZK :arg1
     */
    public function theAtmShouldDispenseCzk($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then the card balance should be cZK :arg1
     */
    public function theCardBalanceShouldBeCzk($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then the card should be returned
     */
    public function theCardShouldBeReturned()
    {
        throw new PendingException();
    }

    /**
     * @Then the ATM should not dispense any money
     */
    public function theAtmShouldNotDispenseAnyMoney()
    {
        throw new PendingException();
    }

    /**
     * @Then the ATM should say there are insufficient funds
     */
    public function theAtmShouldSayThereAreInsufficientFunds()
    {
        throw new PendingException();
    }

    /**
     * @Given the card is disabled
     */
    public function theCardIsDisabled()
    {
        throw new PendingException();
    }

    /**
     * @Then the ATM should retain the card
     */
    public function theAtmShouldRetainTheCard()
    {
        throw new PendingException();
    }

    /**
     * @Then the ATM should say the card has been retained
     */
    public function theAtmShouldSayTheCardHasBeenRetained()
    {
        throw new PendingException();
    }
}
