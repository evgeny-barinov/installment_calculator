<?php

namespace Insly\CarCalculator;

/**
 * Interface PolicyInterface
 * @package Insly\CarCalculator
 */
interface PolicyInterface
{
    public function setTaxes(TaxInterface $basePrice, TaxInterface $commission, TaxInterface $userTax) :void;

    public function getBasePriceTax(): TaxInterface;

    public function getCommissionTax(): TaxInterface;

    public function getUserTax(): TaxInterface;

    public function getValue(): PriceInterface;

    public function getTotal(): PaymentInterface;

    public function setTotal(PaymentInterface $payment);

    public function getTime(): \DateTime;

    public function addPayment(PaymentInterface $payment);

    /**
     * @return PaymentInterface[]
     */
    public function getPayments(): array;
}
