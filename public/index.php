<?php

require '../vendor/autoload.php';

use \Insly\CarCalculator as Calc;


/**
 * since data validation is not related to this task and business logic
 * I don't implement it
 */

if (!empty($_POST)) {
    $carPrice = (float) $_POST['price'];
    $tax = $_POST['tax'];
    $paymentsCount = $_POST['instalments'];
    $timeZoneOffset = $_POST['timezone'] * -1;

    $timezone = timezone_name_from_abbr("UTC", $timeZoneOffset, 0);
    $dateTime = new \DateTime('now', new \DateTimeZone($timezone));

    $car = new Calc\Price($carPrice);
    $policyBuilder = new Calc\PolicyBuilder($car, $dateTime);
    $policyBuilder->setTax(new Calc\Tax($tax));

    if ($paymentsCount > 1) {
        $policyBuilder->makeInstalment(new Calc\CalculationStrategy($paymentsCount));
    }

    $policy = $policyBuilder->getPolicy();
}


require '../calculator/view.php';