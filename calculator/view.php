<?php
/**
 * @var \Insly\CarCalculator\PolicyInterface $policy;
 * @var \Insly\CarCalculator\PaymentInterface[] $payments
 */
?>
<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-6">
            <form action="" method="POST" id="form">
                <div class="form-group">
                    <label for="carValue">Estimated Car Value (EUR)</label>
                    <input type="number" step="0.1" name="price" min="100" max="100000" value="<?= $_POST['price'] ?? '10000'?>" class="form-control" id="carValue" placeholder="1000">
                </div>
                <div class="form-group">
                    <label for="taxPercentage">Tax percentage</label>
                    <input type="number" step="0.1" name="tax" min="0" max="100" value="<?= $_POST['tax'] ?? 10?>" class="form-control" id="taxPercentage" placeholder="10">
                </div>
                <div class="form-group">
                    <label for="taxPercentage">Number of instalments</label>
                    <select class="form-control" name="instalments" id="instalments">
                        <?php for ($i=1;$i<=12;$i++) { ?>
                            <option value="<?= $i?>" <?= !empty($_POST['instalments']) && $_POST['instalments'] == $i ? 'selected': ''?>><?= $i?></option>
                        <?php } ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Calculate</button>
            </form>
        </div>
    </div>
    <br>
    <?php
    if (!empty($policy)):
        $basePriceHtml = $commissionsHtml = $taxHtml = $totalHtml = '';
        $payments = $policy->getPayments();
        if (count($payments) > 1) {
            $paymentsCount = count($payments);
            foreach ($payments as $payment) {
                $basePriceHtml .= '<td>' . $payment->getBasePrice() . '</td>';
                $commissionsHtml .= '<td>' . $payment->getCommission() . '</td>';
                $taxHtml .= '<td>' . $payment->getUserTaxPrice() . '</td>';
                $totalHtml .= '<td>' . $payment->getTotal() . '</td>';
            }
        }
    ?>
    <div class="row">
        <div class="col-12">

            <table class="table">
                <thead class="thead-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Policy</th>
                    <?php if (isset($payments)): ?>
                        <?php foreach ($payments as $i => $payment): ?>
                            <th>Instalment <?= $i + 1 ?></th>
                        <?php endforeach; ?>
                    <?php endif;?>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">Value</th>
                    <td colspan="2"><?= $policy->getValue() ?></td>
                </tr>
                <tr>
                    <th scope="row">Base Premium (<?= $policy->getBasePriceTax() ?>)</th>
                    <td><?= $policy->getTotal()->getBasePrice() ?></td>
                    <?= $basePriceHtml ?>
                </tr>
                <tr>
                    <th scope="row">Commission (<?= $policy->getCommissionTax() ?>)</th>
                    <td><?= $policy->getTotal()->getCommission() ?></td>
                    <?= $commissionsHtml ?>
                </tr>
                <tr>
                    <th scope="row">Tax (<?= $policy->getUserTax() ?>)</th>
                    <td><?= $policy->getTotal()->getUserTaxPrice() ?></td>
                    <?= $taxHtml ?>
                </tr>
                <tr class="table-active">
                    <th scope="row" >Total Cost</th>
                    <td><?= $policy->getTotal()->getTotal() ?></td>
                    <?= $totalHtml ?>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>
</div>
<script>
    var form = document.getElementById('form');
    form.addEventListener('submit', function(e) {
      e.preventDefault();
      var elTimezone = document.createElement("input");
      elTimezone.type ='hidden';
      elTimezone.name ='timezone';
      elTimezone.value = (new Date()).getTimezoneOffset() * 60;
      form.appendChild(elTimezone);
      form.submit();
    });
</script>
</body>
</html>