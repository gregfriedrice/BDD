<?php

namespace Direct;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /**
     * @var \Exception
     */
    private $lastException;

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
     * @Given I have a Current account with balance :balance GBP
     */
    public function iHaveACurrentAccountWithBalanceGbp($balance)
    {
        file_put_contents('current', $balance);
    }

    /**
     * @Given I have a Premium account with balance :balance GBP
     */
    public function iHaveAPremiumAccountWithBalanceGbp($balance)
    {
        file_put_contents('premium', $balance);
    }

    /**
     * @When I transfer :amount GBP from my Current account to my Premium account
     */
    public function iTransferGbpFromMyCurrentAccountToMyPremiumAccount($amount)
    {
        $bank = new \Bank();
        try {
            $bank->transfer($amount, 'current', 'premium');
        } catch (\Exception $e) {
            $this->lastException = $e;
        }
    }

    /**
     * @Then my Current account balance should be :balance GBP
     */
    public function myCurrentAccountBalanceShouldBeGbp($balance)
    {
        $actual = file_get_contents('current');
        \PHPUnit\Framework\Assert::assertEquals($balance, $actual, 'Expected ' . $balance . ', got ' . $actual);
    }

    /**
     * @Then my Premium account balance should be :balance GBP
     */
    public function myPremiumAccountBalanceShouldBeGbp($balance)
    {
        $actual = file_get_contents('premium');
        \PHPUnit\Framework\Assert::assertEquals($balance, $actual, 'Expected ' . $balance . ', got ' . $actual);
    }

    /**
     * @Then I should be told I do not have sufficient funds to complete the transfer
     */
    public function iShouldBeToldIDoNotHaveSufficientFundsToCompleteTheTransfer()
    {
        \PHPUnit\Framework\Assert::assertEquals('Insufficient funds', $this->lastException->getMessage());
    }

    /**
     * @When I transfer :amount GBP from my Premium account to my Current account
     */
    public function iTransferGbpFromMyPremiumAccountToMyCurrentAccount($amount)
    {
        $bank = new \Bank();
        $bank->transfer($amount, 'premium', 'current');
    }

    /**
     * @Then I should be told the transfer amount is below the minimum
     */
    public function iShouldBeToldTheTransferAmountIsBelowTheMinimum()
    {
        \PHPUnit\Framework\Assert::assertEquals('Cannot transfer less than 5 GBP', $this->lastException->getMessage());
    }
}
