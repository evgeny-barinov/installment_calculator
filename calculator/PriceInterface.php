<?php

namespace Insly\CarCalculator;

interface PriceInterface
{
    public function getPriceInt(): int;

    public function getPrice(): float;
}