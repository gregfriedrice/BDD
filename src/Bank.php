<?php

/**
 * @author    Mobile Squad <mobile@worldfirst.com>
 * @copyright 2017 World First Ltd. All rights reserved.
 */
class Bank {
    /**
     * @param float $amount
     * @param string $fromAccount
     * @param string $toAccount
     */
    public function transfer($amount, $fromAccount, $toAccount)
    {
        if ($amount < 5) {
            throw new Exception('Cannot transfer less than 5 GBP');
        }

        $percentageFee = 0;
        if ($amount >= 100) {
            $percentageFee = 0.01 * $amount;
        }

        $flatFee = 0;
        if ($fromAccount === 'premium') {
            $flatFee = 0.30;
        }

        $fromBalance = file_get_contents($fromAccount);
        $toBalance = file_get_contents($toAccount);

        if ($amount > $fromBalance) {
            throw new Exception('Insufficient funds');
        }

        file_put_contents($fromAccount, $fromBalance - $amount - $percentageFee - $flatFee);
        file_put_contents($toAccount, $toBalance + $amount);
    }
}
