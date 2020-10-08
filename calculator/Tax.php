<?php

namespace Insly\CarCalculator;

class Tax implements TaxInterface
{
    protected int $tax;

    public function __construct(int $tax = 10) {
        $this->tax = $tax;
    }

    public function getTaxValue(): int {
        return $this->tax;
    }

    public function  __toString(): string {
        return $this->tax . '%';
    }
}
