<?php

namespace Insly\CarCalculator;

/**
 * Class Payment
 * @package Insly\CarCalculator
 */
class Payment implements PaymentInterface
{
    private PriceInterface $basePrice;

    private PriceInterface $commission;

    private PriceInterface $userTaxPrice;

    private PriceInterface $total;

    public function __construct(
        PriceInterface $basePrice,
        PriceInterface $commission,
        PriceInterface $userTaxPrice
    ) {
        $this->basePrice = $basePrice;
        $this->commission = $commission;
        $this->userTaxPrice = $userTaxPrice;
        $this->setTotal();
    }

    public function getBasePrice(): PriceInterface {
        return $this->basePrice;
    }

    public function getCommission(): PriceInterface {
        return $this->commission;
    }

    public function getUserTaxPrice(): PriceInterface {
        return $this->userTaxPrice;
    }

    public function getTotal(): PriceInterface {
        return $this->total;
    }

    private function setTotal(): void {
        $this->total = new Price(
            $this->basePrice->getPrice() + $this->userTaxPrice->getPrice() + $this->commission->getPrice()
        );
    }
}
