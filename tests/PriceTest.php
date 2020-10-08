<?php
use PHPUnit\Framework\TestCase;

class PriceTest extends TestCase
{

    public function testGetIntValue() {
        $value = 100.11;

        $price = new \Insly\CarCalculator\Price($value);

        $this->assertEquals(10011, $price->getPriceInt());
    }

    public function testGetRawValue() {
        $value = 100.11;

        $price = new \Insly\CarCalculator\Price($value);

        $this->assertEquals(100.11, $price->getPrice());
    }
}
