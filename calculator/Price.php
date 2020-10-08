<?php

namespace Insly\CarCalculator;


class Price implements PriceInterface
{
    protected float $price;

    protected int $priceInt;

    public function __construct(float $price) {
        $this->price = $price;
        $this->priceInt = (int) round($price * 100);
    }

    public function getPrice(): float {
        return $this->price;
    }

    public function getPriceInt(): int {
        return $this->priceInt;
    }

    public function __toString(): string {
        return number_format($this->getPriceInt() / 100, 2, '.', '');
    }
}
