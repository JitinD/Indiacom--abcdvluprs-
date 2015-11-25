<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 1/25/15
 * Time: 1:38 PM
 */
?>
<div class="col-md-12 col-sm-12" id="contentPanel" xmlns="http://www.w3.org/1999/html">
    <h1 class="page-header">Create New Payment</h1>

    <?php
    if (isset($pay_error)) {
        ?>
        <div class="alert alert-danger text-center">
            <?php echo $pay_error; ?>
        </div>
    <?php
    }
    if (!empty($transDetails) && $transDetails->transaction_EQINR - $transUsedAmount <= 0) {
        ?>
        <div class="alert alert-danger text-center">
            <?php echo "This transaction cannot be used for payments since it has been already fully used."; ?>
        </div>
    <?php
    }
    if (isset($message)) {
    ?>
        <div class="alert alert-success text-center">
    <?php
            foreach ($message as $msg) {
                echo "<div>$msg</div>";
            }
    ?>
        </div>
    <?php
    }
    ?>
    <form class="form-horizontal" method="post">
        <div class="row">
            <?php
            if (!empty($transDetails)) {
            ?>
                <div class="col-md-6 col-sm-6">
                    <table class="table table-responsive table-striped table-condensed">
                        <tr>
                            <td>Transaction ID</td>
                            <td>
                                <?php echo $transDetails->transaction_id; ?>
                            </td>
                        </tr>
                        <?php
                        if($transDetails->is_waived_off == 0)
                        {
                        ?>
                            <tr>
                                <td>Transaction Member</td>
                                <td>
                                    <?php echo $transDetails->transaction_member_id; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Transaction Bank
                                </td>
                                <td> <?php echo $transDetails->transaction_bank; ?></td>
                            </tr>
                            <tr>
                                <td>
                                    Transaction Number
                                </td>
                                <td><?php echo $transDetails->transaction_number; ?></td>
                            </tr>
                            <tr>
                                <td>
                                    Transaction Mode
                                </td>
                                <td>
                                    <?php
                                    if ($transDetails->is_waived_off == 0 && $transModeDetails != null)
                                        echo $transModeDetails->transaction_mode_name;
                                    else if($transDetails->is_waived_off == 0)
                                        echo "Unknown transaction mode. Contact Admin.";
                                    ?>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                        <tr>
                            <td>
                                Transaction Amount
                            </td>
                            <td>
                                <?php echo $transDetails->transaction_amount; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Transaction Currency

                            </td>
                            <td>
                                <?php echo $currencyName; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Transaction Amount(EQINR)
                            </td>
                            <td> <?php echo $transDetails->transaction_EQINR; ?></td>
                        </tr>
                        <tr>
                            <td>
                                Transaction Unused Amount
                            </td>
                            <td><?php echo $transDetails->transaction_EQINR - $transUsedAmount; ?></td>
                        </tr>
                        <tr>
                            <td>
                                Transaction Date
                            </td>
                            <td> <?php echo $transDetails->transaction_date; ?></td>
                        </tr>
                        <tr>
                            <td>
                                Is Waived Off
                            </td>
                            <td>
                                <?php
                                echo ($transDetails->is_waived_off == 1) ? "Yes" : "No";
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Transaction Remarks
                            </td>
                            <td><?php echo $transDetails->transaction_remarks; ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <a class="btn btn-block btn-default"
                                   href="<?php echo "/" . BASEURL . "index.php/TransactionManager/loadUnusedTransactions"; ?>">Change
                                    Transaction
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
            <?php
            } else {
                ?>
                <div class="col-md-12 col-sm-12">
                    <span>Invalid Transaction ID</span>
                    <div>
                        You can
                        <a href="<?php echo "/" . BASEURL . "TransactionManager/loadUnusedTransactions"; ?>">Change Transaction</a>
                        or
                        <a href="<?php echo "/" . BASEURL . "TransactionManager/newTransaction"; ?>">Create New Transaction</a>
                    </div>
                </div>
            <?php
            }
            ?>
            <div class="col-md-6 col-sm-6">
                <?php
                if (!isset($paymentMemberId) && !empty($transDetails) && $transDetails->transaction_EQINR - $transUsedAmount > 0) {
                ?>
                    <div class="form-group">
                        <label class="col-sm-3" for="memberId">Member ID</label>
                        <div class="col-sm-6">
                            <input id="memberId" name="payment_memberId" type="text" class="form-control">
                        </div>
                    </div>
                <?php
                }
                else if (!empty($transDetails) && isset($memberDetails) && $memberDetails != null)
                {
                ?>
                    <table class="table table-responsive table-striped table-condensed">
                        <tr>
                            <td>Member ID</td>
                            <td>
                                <?php
                                echo $memberDetails['member_id'];
                                ?>
                                <input type="hidden" value="<?php echo $memberDetails['member_id']; ?>"
                                       name="paymentForMemberId">
                                <input type="hidden" value="<?php echo $memberDetails['member_id']; ?>" name="payment_memberId">
                            </td>
                        </tr>
                        <tr>
                            <td>Member Name</td>
                            <td class="text-capitalize">
                                <?php
                                echo $memberDetails['member_name'];
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Registration Category</td>
                            <td>
                                <?php
                                foreach ($registrationCategories as $category) {
                                    if ($category['member_category_id'] == $registrationCat->member_category_id) {
                                        echo $category['member_category_name'];
                                    }
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Professional Body Member</td>
                            <td>
                                <?php
                                if ($isProfBodyMember)
                                    echo "Yes";
                                else
                                    echo "No";
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <a class="btn btn-block btn-default"
                                   href="<?php echo "/" . BASEURL . "index.php/PaymentsManager/newPayment/" . $transDetails->transaction_id; ?>">Change
                                    Member
                                </a>
                            </td>
                        </tr>
                    </table>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="row col-md-12">
            <?php
            if (!empty($transDetails) && isset($memberDetails) && $memberDetails != null) {
                ?>
                <hr>
                <?php
                $validDiscounts = array();
                foreach($discounts as $discount)
                {
                    if(is_array($discount))
                    {
                        foreach($discount as $paperId => $paperDiscount)
                        {
                            $validDiscounts['paperSpecific'][$paperDiscount->discount_type_payhead][$paperId][] = $paperDiscount;
                        }
                    }
                    else
                    {
                        $validDiscounts['global'][$discount->discount_type_payhead][] = $discount;
                    }
                }
                ?>
                <table class="table table-responsive table-striped table-condensed">
                    <thead>
                    <tr>
                        <th>Paper Code</th>
                        <th>Paper Title</th>
                        <th>Payable</th>
                        <th>Waive Off</th>
                        <th>Paid</th>
                        <th>Pending</th>
                        <th>Pay Amount</th>
                        <th>Select Payable</th>
                        <th>Remarks</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (empty($papers)) {
                        ?>
                        <tr>
                            <td colspan="6">
                                No Accepted Papers!
                            </td>
                        </tr>
                    <?php
                    } else {
                        foreach ($papers as $paper) {
                            ?>
                            <tr>
                                <td class="paper_code">
                                    <?php echo $paper->paper_code; ?>
                                    <input type="hidden" name="submissionIds[]"
                                           value="<?php echo $paper->submission_id; ?>">
                                </td>
                                <td class="paper_title"><?php echo $paper->paper_title; ?></td>
                                <?php
                                $payheads = $papersInfo[$paper->paper_id]['payhead'];
                                $payableClasses = $papersInfo[$paper->paper_id]['payableClass'];
                                foreach($payheads as $index=>$payhead)
                                {
                                    if($payhead->payment_head_name == "BR" || $payhead->payment_head_name == "EP")
                                    {
                                        if(isset($papersInfo[$paper->paper_id]['paid']))
                                        {
                                            $payable = $papersInfo[$paper->paper_id]['payable'][$index];
                                            $payheadId = $payhead->payment_head_id;
                                            $payableClass = $papersInfo[$paper->paper_id]['payableClass'][$index];
                                            $waiveOffAmount = $papersInfo[$paper->paper_id]['waiveOff'][$index];
                                            $paidAmount = $papersInfo[$paper->paper_id]['paid'][$index];
                                            $pendingAmount = $papersInfo[$paper->paper_id]['pending'][$index];
                                        }
                                    }
                                }
                                ?>
                                <td class="payable"
                                    data-mid="<?php echo $memberDetails['member_id']; ?>"
                                    data-pid="<?php echo $paper->paper_id; ?>"
                                    data-payheadId="<?php
                                    if(isset($papersInfo[$paper->paper_id]['paid']))
                                        echo $payheadId;
                                    ?>"><?php
                                    if(isset($papersInfo[$paper->paper_id]['paid']))
                                        echo $payable;
                                ?></td>
                                <td class="waive_off">
                                    <span>
                                        <?php
                                        if(isset($papersInfo[$paper->paper_id]['paid']))
                                            echo $waiveOffAmount;
                                        else
                                            echo 0;
                                        ?>
                                    </span>
                                </td>
                                <td class="paid">
                                    <span>
                                        <?php
                                        if (isset($papersInfo[$paper->paper_id]['paid']))
                                            echo $paidAmount;
                                        else
                                            echo 0;
                                        ?>
                                    </span>
                                </td>
                                <td class="pending">
                                    <span><?php
                                        if(isset($papersInfo[$paper->paper_id]['paid']))
                                            echo $pendingAmount;
                                    ?></span>
                                </td>
                                <td class="pay_amount">
                                    <input type="number"
                                           max="<?php if (isset($papersInfo[$paper->paper_id]['paid'])) echo $pendingAmount; else echo 90000; ?>"
                                           min="0"
                                           name="<?php echo $paper->submission_id; ?>_payAmount"
                                        <?php
                                        if (!isset($papersInfo[$paper->paper_id]['paid']) &&
                                            !isset($papersInfo[$paper->paper_id]['payable'])
                                        )
                                            echo "disabled";
                                        else if (isset($papersInfo[$paper->paper_id]['paid']) &&
                                                 $pendingAmount <= 0
                                        )
                                            echo "disabled";
                                        ?>
                                           class="payAmounts">
                                </td>
                                <td class="payhead_discount">
                                    <?php
                                    if(isset($papersInfo[$paper->paper_id]['payable']))
                                        $payableAmount = $papersInfo[$paper->paper_id]['payable'];
                                    $payHeads = $papersInfo[$paper->paper_id]['payhead'];
                                    $payableClasses = $papersInfo[$paper->paper_id]['payableClass'];
                                    foreach($payHeads as $index=>$paymentHead)
                                    {
                                        if($paymentHead->payment_head_name == "OLPC")
                                            continue;
                                        /*if(
                                            (
                                                isset($validDiscounts['paperSpecific'][$paymentHead->payment_head_id][$paper->paper_id])
                                                || isset($validDiscounts['global'][$paymentHead->payment_head_id])
                                                || isset($papersInfo[$paper->paper_id]['discountType'])
                                            ) &&
                                            (
                                                !isset($papersInfo[$paper->paper_id]['paid'])
                                                || isset($papersInfo[$paper->paper_id]['discountType'])
                                            )

                                        )*/
                                        //with discount payables
                                        {
                                            $discountArray = array();
                                            if(isset($papersInfo[$paper->paper_id]['discountType']))
                                                $discountArray[] = $papersInfo[$paper->paper_id]['discountType'];
                                            else
                                            {
                                                if(isset($validDiscounts['global'][$paymentHead->payment_head_id]))
                                                {
                                                    $discountArray[] = $validDiscounts['global'][$paymentHead->payment_head_id];
                                                }
                                                if(isset($validDiscounts['paperSpecific'][$paymentHead->payment_head_id][$paper->paper_id]))
                                                {
                                                    $discountArray[] = $validDiscounts['paperSpecific'][$paymentHead->payment_head_id][$paper->paper_id];
                                                }
                                            }
                                            foreach($discountArray as $discounts_)
                                            {
                                                foreach($discounts_ as $discount)
                                                {
                                                    if(isset($papersInfo[$paper->paper_id]['paid']))
                                                    {
                                                        $payableAmount = $payable;
                                                        $pendingAmount = $pendingAmount;
                                                    }
                                                    else
                                                    {
                                                        $payableAmount = $payableClasses[$index]->payable_class_amount - ($discount->discount_type_amount * $payableClasses[$index]->payable_class_amount);
                                                        $pendingAmount = $payableClasses[$index]->payable_class_amount - ($discount->discount_type_amount * $payableClasses[$index]->payable_class_amount);
                                                    }
                                                ?>
                                                    <input type="radio" class="radio"
                                                           name="<?php echo $paper->submission_id; ?>_payheadAndDiscount"
                                                           value="<?php echo $paymentHead->payment_head_name."_".$discount->discount_type_id; ?>"
                                                           data-payable="<?php echo $payableAmount; ?>"
                                                           data-pending="<?php echo $pendingAmount; ?>"
                                                           data-payheadId="<?php echo $payableClasses[$index]->payable_class_payhead_id; ?>"
                                                        <?php
                                                        if (isset($papersInfo[$paper->paper_id]['paid']) && $pendingAmount <= 0)
                                                            echo "disabled";
                                                        if(isset($papersInfo[$paper->paper_id]['paid']))
                                                            echo " checked";
                                                        ?>>
                                                    <?php echo "{$paymentHead->payment_head_name} with {$discount->discount_type_name} discount"; ?>
                                                <?php
                                                }
                                            }
                                        }
                                        //without discount payables
                                        {
                                        ?>
                                            <input type="radio" class="radio"
                                                   name="<?php echo $paper->submission_id; ?>_payheadAndDiscount"
                                                   value="<?php echo $paymentHead->payment_head_name ?>"
                                                   data-payable="<?php
                                                        if(isset($papersInfo[$paper->paper_id]['paid']))
                                                            echo $payable;
                                                        else
                                                            echo $payableClasses[$index]->payable_class_amount;
                                                    ?>"
                                                   data-pending="<?php
                                                        if(isset($papersInfo[$paper->paper_id]['paid']))
                                                            echo $pendingAmount;
                                                        else
                                                            echo $payableClasses[$index]->payable_class_amount;
                                                   ?>"
                                                   data-payheadId="<?php echo $payableClasses[$index]->payable_class_payhead_id; ?>"
                                                <?php
                                                if (isset($papersInfo[$paper->paper_id]['paid']) && $pendingAmount <= 0)
                                                    echo "disabled";
                                                if(isset($papersInfo[$paper->paper_id]['paid']))
                                                    echo " checked";
                                                ?>>
                                            <?php echo $paymentHead->payment_head_name; ?>
                                        <?php
                                        }
                                    }
                                    ?>
                                </td>
                                <td>

                                </td>
                                <td>
                                    <?php
                                    if(isset($papersInfo[$paper->paper_id]['paid']))
                                    {
                                    ?>
                                        <a class="btn btn-default" href="/<?php echo BASEURL."PaymentsManager/paymentBreakup/{$paper->submission_id}/{$payheadId}"; ?>" target="new">Payment Breakup/Transfer</a>
                                        <a class="btn btn-default" href="/<?php echo BASEURL."PaymentsManager/changePayableClass/{$paper->submission_id}/{$payableClass->payable_class_id}"; ?>" target="new">Change Payable Class</a>
                                        <a class="btn btn-default" href="/<?php echo BASEURL."PaymentsManager/changeDiscountType/{$paper->submission_id}/{$payableClass->payable_class_id}"; ?>" target="new">Change Discount Type</a>
                                    <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php

                            ?>
                        <?php
                        }
                    }
                    ?>
                    </tbody>
                </table>
                <h4>Misc. Payments</h4>
                <table>

                </table>
            <?php
            } else if (empty($transDetails)) {
                ?>
                No transaction selected
            <?php
            }
            ?>
            <div class="form-group contentBlock-top">
                <div class="col-sm-12">
                    <input type="submit" class="btn btn-block btn-default">
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function () {
        $(".radio").click(function () {
            var payable = $(this).attr("data-payable");
            var pending = $(this).attr("data-pending");
            var payheadId = $(this).attr("data-payheadId");
            $(".payable", $(this).parent().parent()).html(payable);
            $(".payable", $(this).parent().parent()).attr("data-payheadId", payheadId);
            $(".pending", $(this).parent().parent()).html(pending);
            $(".pay_amount input", $(this).parent().parent()).attr("disabled", false);
            $(".pay_amount input", $(this).parent().parent()).attr("max", pending);
            $(".pay_amount input", $(this).parent().parent()).val(pending);
        });
    });
</script>
