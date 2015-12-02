<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 1/18/15
 * Time: 6:02 PM
 */
?>

<div class="col-sm-12 col-md-12" id="contentPanel">
<?php
if($viewBy == "members")
{
    ?>
    <h1 class="page-header">Member Payments</h1>
    <div class="row">
        <div id="payment-list" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="input-group">
                        <input type="text" class="searchValue form-control search" name="searchValue" maxlength="30"
                               value="" id="searchValue"
                               placeholder="Search">
                    <span class="input-group-btn">
                        <button type="button" id="submitButton" class="btn btn-default"><span
                                class="glyphicon glyphicon-search"></span></button>
                    </span>
                    </div>
                </div>
            </div>
            <hr/>
            <table class="table table-hover table-condensed">
                <thead>
                <tr>
                    <th>#</th>
                    <th class="sort btn-link" data-sort="field1">Mid</th>
                    <th class="sort btn-link" data-sort="field2">Member Name</th>
                    <th>Payment Breakup</th>
                </tr>
                </thead>
                <tbody class="list">
                <?php
                $sno = 0;
                if(empty($membersPayments))
                {
                    ?>
                    <tr>
                        <td colspan="4">No members have paid yet!</td>
                    </tr>
                <?php
                }
                else
                {
                    foreach($membersPayments as $memberId=>$memberPayments)
                    {
                        ?>
                        <tr>
                            <td><?php echo ++$sno; ?></td>
                            <td class="field1"><?php echo $memberId; ?></td>
                            <td class="text-capitalize field2"><?php echo $memberDetails[$memberId]['member_name']; ?></td>
                            <td>
                                <table class="table table-condensed">
                                    <thead>
                                    <tr>
                                        <th>PaperId</th>
                                        <th>Payhead</th>
                                        <th>Payable<br>(w/o discount and waiveoff)</th>
                                        <th>Waiveoff</th>
                                        <th>Discount</th>
                                        <th>Discount Type</th>
                                        <th>Payable<br>(with waiveoff and discount)</th>
                                        <th>Tax Rate Applied</th>
                                        <th>Payable After Tax</th>
                                        <th>Paid</th>
                                        <th>Outstanding</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach($memberPayments as $memberPayment)
                                    {
                                        ?>
                                        <tr>
                                            <?php $currency = $currencyDetails[$nationalities[$memberPayment->payable_class_nationality]->Nationality_currency]->currency_name; ?>
                                            <?php
                                            $payableAmt = $memberPayment->payable_class_amount;
                                            $waiveOffAmt = $memberPayment->waiveoff_amount;
                                            $discountAmt = floor($memberPayment->payable_class_amount * $memberPayment->discount_type_amount);
                                            $discountedPayable = $payableAmt - $discountAmt;
                                            $tax = $payment_model->getTax($memberPayment->transaction_date);
                                            $taxedPayableAmount = $discountedPayable * $tax;
                                            $actualPayable = $taxedPayableAmount - $waiveOffAmt;
                                            $paidAmt = $memberPayment->paid_amount / $exchangeRate[$nationalities[$memberPayment->payable_class_nationality]->Nationality_currency];
                                            $outstanding = $actualPayable - $paidAmt;
                                            if($outstanding < 1 && $outstanding > 0)
                                                $outstanding = 0;
                                            ?>
                                            <td><?php echo $memberPayment->submission_paper_id; ?></td>
                                            <td><?php echo $payheadDetails[$memberPayment->payable_class_payhead_id]; ?></td>
                                            <td>
                                                <?php echo $currency; ?>
                                                <?php echo $payableAmt; ?>/-
                                            </td>
                                            <td class="<?php if($waiveOffAmt > 0) echo "bg-info"; ?>">
                                                <?php echo $currency; ?> <?php echo $waiveOffAmt; ?>/-
                                            </td>
                                            <td class="<?php
                                            if($discountAmt > 0)
                                                echo "bg-silver";
                                            ?>">
                                                <?php echo $currency; ?> <?php echo $discountAmt; ?>/-
                                            </td>
                                            <td>
                                                <?php
                                                if($memberPayment->payment_discount_type != null)
                                                    echo $discountTypes[$memberPayment->payment_discount_type]->discount_type_name;
                                                else
                                                    echo "N.A.";
                                                ?>
                                            </td>
                                            <td><?php echo $currency; ?> <?php echo $actualPayable; ?>/-</td>
                                            <td><?php echo ($tax - 1) * 100 . "%"; ?></td>
                                            <td><?php echo $taxedPayableAmount; ?></td>
                                            <td>
                                                <button class="btn btn-link">
                                                    <?php echo $currency; ?> <?php echo $paidAmt; ?>/-
                                                </button>
                                            </td>
                                            <td class="<?php
                                            if($outstanding > 0)
                                                echo "bg-primary";
                                            else if($outstanding < 0)
                                                echo "bg-danger";
                                            ?>">
                                                <?php echo $currency; ?> <?php echo $outstanding; ?>/-
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-default" disabled>Transfer</button>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    <?php
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
<?php
}
else if($viewBy == "papers")
{
    ?>
    <h1 class="page-header">Paper Payments</h1>
    <div class="row">
        <div id="payment-list" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="input-group">
                        <input type="text" class="searchValue form-control search" name="searchValue" maxlength="30"
                               value="" id="searchValue"
                               placeholder="Search">
                    <span class="input-group-btn">
                        <button type="button" id="submitButton" class="btn btn-default"><span
                                class="glyphicon glyphicon-search"></span></button>
                    </span>
                    </div>
                </div>
            </div>
            <hr/>
            <table class="table table-responsive table-hover table-condensed">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Paper Code</th>
                    <th>Paper Title</th>
                    <th>Payment Breakup</th>
                </tr>
                </thead>
                <tbody class="list">
                <?php
                $sno = 0;
                if(empty($papersPayments))
                {
                    ?>
                    <tr>
                        <td colspan="4">No members have paid yet!</td>
                    </tr>
                <?php
                }
                else
                {
                    foreach($papersPayments as $paperId=>$paperPayments)
                    {
                        ?>
                        <tr>
                            <td><?php echo ++$sno; ?></td>
                            <td class="field1"><?php echo $paperDetails[$paperId]->paper_code; ?></td>
                            <td class="field2"><?php echo $paperDetails[$paperId]->paper_title; ?></td>
                            <td>
                                <table class="table table-condensed table-responsive">
                                    <thead>
                                    <tr>
                                        <th>MemberId</th>
                                        <th>Payhead</th>
                                        <th>Payable<br>(w/o discount and waiveoff)</th>
                                        <th>Waiveoff</th>
                                        <th>Discount</th>
                                        <th>Discount Type</th>
                                        <th>Payable<br>(with waiveoff and discount)</th>
                                        <th>Paid</th>
                                        <th>Outstanding</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach($paperPayments as $paperPayment)
                                    {
                                        ?>
                                        <tr>
                                            <?php $currency = $currencyDetails[$nationalities[$paperPayment->payable_class_nationality]->Nationality_currency]->currency_name; ?>
                                            <?php
                                            $payableAmt = $paperPayment->payable_class_amount;
                                            $waiveOffAmt = $paperPayment->waiveoff_amount;
                                            $discountAmt = floor($paperPayment->payable_class_amount * $paperPayment->discount_type_amount);
                                            $discountedPayable = $payableAmt - $discountAmt;
                                            $tax = $payment_model->getTax($paperPayment->transaction_date);
                                            $taxedPayableAmount = $discountedPayable * $tax;
                                            $actualPayable = $taxedPayableAmount - $waiveOffAmt;
                                            $paidAmt = $paperPayment->paid_amount / $exchangeRate[$nationalities[$paperPayment->payable_class_nationality]->Nationality_currency];
                                            $outstanding = $actualPayable - $paidAmt;
                                            if($outstanding < 1 && $outstanding > 0)
                                                $outstanding = 0;
                                            ?>
                                            <td><?php echo $paperPayment->submission_member_id; ?></td>
                                            <td><?php echo $payheadDetails[$paperPayment->payable_class_payhead_id]; ?></td>
                                            <td><?php echo $currency; ?> <?php echo $payableAmt; ?>/-</td>
                                            <td class="<?php if($waiveOffAmt > 0) echo "bg-info"; ?>">
                                                <?php echo $currency; ?> <?php echo $waiveOffAmt; ?>/-
                                            </td>
                                            <td class="<?php
                                            if($discountAmt > 0)
                                                echo "bg-silver";
                                            ?>">
                                                <?php echo $currency; ?> <?php echo $discountAmt; ?>/-
                                            </td>
                                            <td>
                                                <?php
                                                if($paperPayment->payment_discount_type != null)
                                                    echo $discountTypes[$paperPayment->payment_discount_type]->discount_type_name;
                                                else
                                                    echo "N.A.";
                                                ?>
                                            </td>
                                            <td><?php echo $currency; ?> <?php echo $actualPayable; ?>/-</td>
                                            <td>
                                                <button class="btn btn-link">
                                                    <?php echo $currency; ?> <?php echo $paidAmt; ?>/-
                                                </button>
                                            </td>
                                            <td class="<?php
                                            if($outstanding > 0)
                                                echo "bg-primary";
                                            else if($outstanding < 0)
                                                echo "bg-danger";
                                            ?>">
                                                <?php echo $currency; ?> <?php echo $outstanding; ?>/-
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-default" disabled>Transfer</button>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    <?php
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
<?php
}
?>
</div>
</div>

<script>
    var options = {
        valueNames: [
            'field1',
            'field2'
        ],
        page: 750
    };

    var paymentList = new List('payment-list', options);
</script>