<?php

namespace Insly\CarCalculator;


class Policy implements PolicyInterface
{
    private TaxInterface $basePriceTax;

    private TaxInterface $commissionTax;

    private TaxInterface $userTax;

    private PriceInterface $value;

    private \DateTime $time;

    private PaymentInterface $total;

    /**
     * @var PaymentInterface[]
     */
    private array $payments = [];

    public function __construct(PriceInterface $value, \DateTime $time) {
        $this->value = $value;
        $this->time = $time;
    }

    public function getValue() :PriceInterface {
        return $this->value;
    }

    public function getBasePriceTax() :TaxInterface {
        return $this->basePriceTax;
    }

    public function getCommissionTax() :TaxInterface {
        return $this->commissionTax;
    }

    public function getUserTax() :TaxInterface {
        return $this->userTax;
    }

    public function getTotal() :PaymentInterface {
        return $this->total;
    }

    public function setTotal(PaymentInterface $payment) {
        $this->total = $payment;
    }

    public function getTime(): \DateTime {
        return $this->time;
    }

    public function setTaxes(TaxInterface $basePriceTax, TaxInterface $commission, TaxInterface $userTax) :void {
        $this->basePriceTax = $basePriceTax;
        $this->commissionTax = $commission;
        $this->userTax = $userTax;
    }

    /**
     * @return PaymentInterface[]
     */
    public function getPayments(): array {
        return $this->payments;
    }

    public function addPayment(PaymentInterface $payment): void {
        $this->payments[] = $payment;
    }
}
