<?php

namespace Insly\CarCalculator;


/**
 * Facade Policy builder
 * Class PolicyBuilder
 * @package Insly\CarCalculator
 */
class PolicyBuilder
{
    public const COMMISSION = 17; // %
    public const NORMAL_BASE_PRICE = 11; // %
    public const SPECIAL_BASE_PRICE = 13; // %

    private Policy $policy;

    public function __construct(PriceInterface $value, \DateTime $time) {
        $this->policy = new Policy($value, $time);
    }

    public function setTax(TaxInterface $userTax): void {
        $this->policy->setTaxes(
            new Tax($this->getBasePriceTaxValue()),
            new Tax(static::COMMISSION),
            $userTax
        );

        $value = $this->policy->getValue();
        $basePrice = new TaxPrice($value, $this->policy->getBasePriceTax());
        $this->policy->setTotal(new Payment(
            $basePrice,
            new TaxPrice($basePrice, $this->policy->getCommissionTax()),
            new TaxPrice($basePrice, $this->policy->getUserTax()),
        ));
    }

    private function getBasePriceTaxValue(): int {
        list($hour, $day) = explode(',', $this->policy->getTime()->format('G,l'));
        return $day == 'Friday' && $hour >= 15 && $hour <= 20 ? static::SPECIAL_BASE_PRICE : static::NORMAL_BASE_PRICE;
    }

    public function makeInstalment(InstallmentCalculationStrategy $strategy) {
        $policyTotal = $this->policy->getTotal();
        $baseValues = $strategy->makePayments($policyTotal->getBasePrice()->getPriceInt());
        $commission = $strategy->makePayments($policyTotal->getCommission()->getPriceInt());
        $tax = $strategy->makePayments($policyTotal->getUserTaxPrice()->getPriceInt());

        for ($i = 0; $i < $strategy->getCount(); $i++) {
            $this->policy->addPayment(
                new Payment(
                    new Price($baseValues[$i]/100),
                    new Price($commission[$i]/100),
                    new Price($tax[$i]/100)
                )
            );
        }
    }

    public function getPolicy(): PolicyInterface {
        return $this->policy;
    }

}
