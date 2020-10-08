<?php

namespace Insly\CarCalculator;

/**
 * Class CalculationStrategy
 * @package Insly\CarCalculator
 */
class CalculationStrategy implements InstallmentCalculationStrategy
{
    private int $paymentsCount;

    public function __construct(int $paymentsCount) {
        $this->paymentsCount = $paymentsCount;
    }

    /**
     * @return float[]
     */
    public function makePayments(float $price): array {
        $payments = $this->paymentsCount;
        $amount = $price;

        if ($payments == 1) return [$amount];

        if ($payments == 2) {
            return $this->makeFor2($amount);
        }

        $monthlyPayment = floor($amount/$payments);

        /**
         * if $amount can be divided equally
         */
        if ($amount % $payments == 0) {
            return array_fill(0, $payments, $monthlyPayment);
        }

        /**
         * otherwise
         * get leftover for last 2 months
         * and get calculation for 2 months;
         * then join it to current result;
         */
        $payments -= 2;
        $result = array_fill(0, $payments, $monthlyPayment);
        $amount -= ($monthlyPayment * $payments);

        $result = array_merge($result, $this->makeFor2($amount));
        return $result;
    }

    public function getCount(): int {
        return $this->paymentsCount;
    }

    /**
     * @return float[]
     */
    private function makeFor2(float $amount): array {
        $month1Value = floor($amount/2);
        $month2Value = $amount - $month1Value;
        return [$month1Value, $month2Value];
    }
}
