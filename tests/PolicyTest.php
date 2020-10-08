<?php

use Insly\CarCalculator\Payment;
use Insly\CarCalculator\PaymentInterface;
use Insly\CarCalculator\Price;
use Insly\CarCalculator\Tax;
use Insly\CarCalculator\TaxInterface;
use Insly\CarCalculator\TaxPrice;
use PHPUnit\Framework\TestCase;

class Policy extends TestCase
{
    public function testPolicyInit() {
        $value = 10000;
        $dateTime = new DateTime();

        $policy = new \Insly\CarCalculator\Policy(new Price($value), $dateTime);

        $this->assertEquals($dateTime, $policy->getTime());
        $this->assertEquals(10000, $policy->getValue()->getPrice());
    }

    public function testPolicyTaxesApplied() {
        $value = 10000;
        $dateTime = new DateTime();

        $policy = new \Insly\CarCalculator\Policy(new Price($value), $dateTime);

        $policy->setTaxes(
            new Tax(11),
            new Tax(17),
            new Tax(10)
        );
        $this->assertTrue($policy->getBasePriceTax() instanceof TaxInterface);
        $this->assertTrue($policy->getCommissionTax() instanceof TaxInterface);
        $this->assertTrue($policy->getUserTax() instanceof TaxInterface);
        $this->assertEquals(11, $policy->getBasePriceTax()->getTaxValue());
        $this->assertEquals(17, $policy->getCommissionTax()->getTaxValue());
        $this->assertEquals(10, $policy->getUserTax()->getTaxValue());
    }

    public function testPolicyTotalApplied() {
        $value = 10000;
        $dateTime = new DateTime();

        $policy = new \Insly\CarCalculator\Policy(new Price($value), $dateTime);

        $policy->setTaxes(
            new Tax(11),
            new Tax(17),
            new Tax(10)
        );

        $value = $policy->getValue();
        $basePrice = new TaxPrice($value, $policy->getBasePriceTax());
        $policy->setTotal(new Payment(
            $basePrice,
            new TaxPrice($basePrice, $policy->getCommissionTax()),
            new TaxPrice($basePrice, $policy->getUserTax()),
        ));

        $this->assertTrue($policy->getTotal() instanceof PaymentInterface);
        $this->assertEquals(1100, $policy->getTotal()->getBasePrice()->getPrice());
        $this->assertEquals(187, $policy->getTotal()->getCommission()->getPrice());
        $this->assertEquals(110, $policy->getTotal()->getUserTaxPrice()->getPrice());
    }
}
