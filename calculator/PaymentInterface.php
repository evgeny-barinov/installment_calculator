<?php

namespace Insly\CarCalculator;


interface PaymentInterface
{
    public function getBasePrice() :PriceInterface;

    public function getCommission() :PriceInterface;

    public function getUserTaxPrice() :PriceInterface;

    public function getTotal() :PriceInterface;
}