<?php

namespace Insly\CarCalculator;


class TaxPrice extends Price
{
    public function __construct(PriceInterface $price, TaxInterface $tax) {
        $value = ($tax->getTaxValue() / 100) * $price->getPrice();
        parent::__construct(round($value, 2));
    }
}
