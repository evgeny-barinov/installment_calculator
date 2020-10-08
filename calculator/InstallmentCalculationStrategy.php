<?php

namespace Insly\CarCalculator;


interface InstallmentCalculationStrategy
{
    public function makePayments(float $price): array;

    public function getCount(): int;
}