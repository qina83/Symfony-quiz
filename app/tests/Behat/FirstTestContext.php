<?php

declare(strict_types=1);

namespace App\Tests\Behat;


use Behat\Behat\Context\Context;
use Webmozart\Assert\Assert;

/**
 * This context class contains the definitions of the steps used by the demo
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
final class FirstTestContext implements Context
{

    private int $number;

    /**
     * @When user choose :number
     */
    public function userChooseNumber(int $number)
    {
        $this->number = $number;
    }

    /**
     * @Then user must read :square
     */
    public function userMustReadSquare(int $square)
    {
        Assert::same($square, $this->number * $this->number);
    }
}
