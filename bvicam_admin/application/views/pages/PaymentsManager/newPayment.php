<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 1/25/15
 * Time: 1:38 PM
 */
?>
<div class="col-md-12 col-sm-12 col-xs-12" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
    <h3 class="text-theme">Create New Payment</h3>
    <hr>
    <div class="bg-danger h4">
        <?php
        if(isset($pay_error))
            echo $pay_error;
        ?>
    </div>
    <div class="bg-info h4">
        <?php
        if(isset($message))
        {
            foreach($message as $msg)
            {
                echo "<div>$msg</div>";
            }
        }
        ?>
    </div>
    <?php
    if(!empty($transDetails))
    {
    ?>
        <span class="h5 center-block text-success">
            Transaction Id
            <span class="bg-primary">
                <?php echo $transDetails->transaction_id; ?>
            </span>
            <a href="<?php echo "/".BASEURL."index.php/TransactionManager/loadUnusedTransactions"; ?>">Change Transaction</a>
        </span>
        <span class="h5 center-block text-success">
            Transaction Member
            <span class="bg-primary">
                <?php echo $transDetails->transaction_member_id; ?>
            </span>
        </span>
        <span class="h5 center-block text-success">
            Transaction Bank
            <span class="bg-primary">
                <?php echo $transDetails->transaction_bank; ?>
            </span>
        </span>
        <span class="h5 center-block text-success">
            Transaction Number
            <span class="bg-primary">
                <?php echo $transDetails->transaction_number; ?>
            </span>
        </span>
        <span class="h5 center-block text-success">
            Transaction Mode
            <span class="bg-primary">
                <?php
                if($transDetails->is_waived_off == 0)
                    echo $transModeDetails->transaction_mode_name;
                ?>
            </span>
        </span>
        <span class="h5 center-block text-success">
            Transaction Amount
            <span class="bg-primary">
                <?php echo $transDetails->transaction_amount; ?>
            </span>
        </span>
        <span class="h5 center-block text-success">
            Transaction Currency
            <span class="bg-primary">
                <?php echo $currencyName; ?>
            </span>
        </span>
        <span class="h5 center-block text-success">
            Transaction Amount(EQINR)
            <span class="bg-primary">
                <?php echo $transDetails->transaction_EQINR; ?>
            </span>
        </span>
        <span class="h5 center-block text-success">
            Transaction Unused Amount
            <span class="bg-primary">
                <?php echo $transDetails->transaction_EQINR - $transUsedAmount; ?>
            </span>
        </span>
        <span class="h5 center-block text-success">
            Transaction Date
            <span class="bg-primary">
                <?php echo $transDetails->transaction_date; ?>
            </span>
        </span>
        <span class="h5 center-block text-success">
            Is Waived Off
            <span class="bg-primary">
                <?php
                echo ($transDetails->is_waived_off == 1) ? "Yes" : "No";
                ?>
            </span>
        </span>
        <span class="h5 center-block text-success">
            Transaction Remarks
            <span class="bg-primary">
                <?php echo $transDetails->transaction_remarks; ?>
            </span>
        </span>
    <?php
    }
    else
    {
        echo "Invalid Transaction ID";
    ?>
        <a href="<?php echo "/".BASEURL."TransactionManager/loadUnusedTransactions"; ?>">Change Transaction</a>
    <?php
    }
    ?>
    <form class="form-horizontal" method="post">
        <?php
        if(!isset($paymentMemberId) && !empty($transDetails))
        {
            if($transDetails->transaction_EQINR - $transUsedAmount > 0)
            {
        ?>
                <div class="form-group">
                    <label class="col-sm-3" for="memberId">Member ID</label>
                    <div class="col-sm-6">
                        <input id="memberId" name="payment_memberId" type="text" class="form-control">
                    </div>
                </div>
        <?php
            }
            else
            {
        ?>
                <div class="bg-danger h4">
                    This transaction cannot be used for payments since it has been already fully used.
                </div>
        <?php
            }
        }
        else if(!empty($transDetails) && $memberDetails != null)
        {
        ?>
            <span class="h5 center-block text-success">
                Member ID
                <span class="bg-primary">
                    <?php
                    echo $memberDetails['member_id'];
                    ?>
                    <input type="hidden" value="<?php echo $memberDetails['member_id']; ?>" name="paymentForMemberId">
                    <input type="hidden" value="<?php echo $memberDetails['member_id']; ?>" name="payment_memberId">
                </span>
            </span>
            <span class="h5 center-block text-success">
                Member Name
                <span class="bg-primary">
                    <?php
                    echo $memberDetails['member_name'];
                    ?>
                </span>
            </span>
            <span class="h5 center-block text-success">
                Registration Category
                <span class="bg-primary">
                    <?php
                    foreach($registrationCategories as $category)
                    {
                        if($category['member_category_id'] == $registrationCat->member_category_id)
                        {
                            echo $category['member_category_name'];
                        }
                    }
                    ?>
                </span>
            </span>
            <span class="h5 center-block text-success">
                Professional Body Member
                <span class="bg-primary">
                    <?php
                    if($isProfBodyMember)
                        echo "Yes";
                    else
                        echo "No";
                    ?>
                </span>
            </span>
            <?php
            $paperWiseDiscount = array();
            $globalDiscount = array();
            foreach ($discounts as $discount) {
                if (is_array($discount)) {
                    foreach ($discount as $paperId => $paperDiscount) {
                        $paperWiseDiscount[$paperId][$paperDiscount->discount_type_id] = $paperDiscount;
                    }
                } else {
                    $globalDiscount[$discount->discount_type_id] = $discount;
                }
            }
            ?>
            <table class="table table-responsive table-striped table-hover">
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
                    <th>Payment Verified</th>
                    <th>Remarks</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(empty($papers))
                {
                    ?>
                    <tr>
                        <td colspan="6">
                            No Accepted Papers!
                        </td>
                    </tr>
                <?php
                }
                else
                {
                    foreach($papers as $paper)
                    {
                        ?>
                        <tr>
                            <td>
                                <?php echo $paper->paper_code; ?>
                                <input type="hidden" name="submissionIds[]" value="<?php echo $paper->submission_id; ?>">
                            </td>
                            <td><?php echo $paper->paper_title; ?></td>
                            <td>
                                <?php
                                if (isset($papersInfo[$paper->paper_id]['br']) && !isset($papersInfo[$paper->paper_id]['ep']))
                                    echo $papersInfo[$paper->paper_id]['br'];
                                else if (!isset($papersInfo[$paper->paper_id]['br']) && isset($papersInfo[$paper->paper_id]['ep']))
                                    echo $papersInfo[$paper->paper_id]['ep'];
                                ?>
                            </td>
                            <td>
                                <span>
                                    <?php
                                    if (isset($papersInfo[$paper->paper_id]['waiveOff']))
                                        echo $papersInfo[$paper->paper_id]['waiveOff'];
                                    else
                                        echo 0;
                                    ?>
                                </span>
                                <!--<span class="BR"
                                    <?php
/*                                    if(!isset($papersInfo[$paper->paper_id]['paid']) && isset($papersInfo[$paper->paper_id]['ep']))
                                    {
                                    */?>
                                        style="display: none;"
                                    <?php
/*                                    }
                                    */?>>
                                    <?php
/*                                    if(isset($papersInfo[$paper->paper_id]['br']) && isset($papersInfo[$paper->paper_id]['br']))
                                        echo $papersInfo[$paper->paper_id]['br'];
                                    */?>
                                </span>
                                <span class="EP"
                                    <?php
/*                                    if(!isset($papersInfo[$paper->paper_id]['paid']))
                                    {
                                    */?>
                                        style="display: none;"
                                    <?php
/*                                    }
                                    */?>>
                                    <?php
/*                                    if(isset($papersInfo[$paper->paper_id]['ep']))
                                        echo $papersInfo[$paper->paper_id]['ep'];
                                    */?>
                                </span>-->
                            </td>
                            <td>
                                <span>
                                    <?php
                                    if (isset($papersInfo[$paper->paper_id]['paid']))
                                        echo $papersInfo[$paper->paper_id]['paid'];
                                    else
                                        echo 0;
                                    ?>
                                </span>
                            </td>
                            <td>
                                <span>
                                    <?php
                                    if (isset($papersInfo[$paper->paper_id]['pending']))
                                        echo $papersInfo[$paper->paper_id]['pending'];
                                    ?>
                                </span>
                            </td>
                            <td>
                                <input type="number"
                                       value="<?php if (isset($papersInfo[$paper->paper_id]['pending'])) echo $papersInfo[$paper->paper_id]['pending']; ?>"
                                       max="<?php if (isset($papersInfo[$paper->paper_id]['pending'])) echo $papersInfo[$paper->paper_id]['pending']; ?>"
                                       min="0"
                                       name="<?php echo $paper->submission_id; ?>_payAmount"
                                    <?php
                                    if(!isset($papersInfo[$paper->paper_id]['paid']) &&
                                        isset($papersInfo[$paper->paper_id]['br']) &&
                                        isset($papersInfo[$paper->paper_id]['ep'])) echo "disabled";
                                    else if(isset($papersInfo[$paper->paper_id]['pending']) && $papersInfo[$paper->paper_id]['pending'] == 0) echo "disabled";
                                    ?>
                                       class="payAmounts">
                            </td>
                            <td>
                                <?php
                                if (isset($papersInfo[$paper->paper_id]['br'])) {
                                    $payableTypes = array();
                                    if(isset($papersInfo[$paper->paper_id]['paid']))
                                    {
                                        if(isset($papersInfo[$paper->paper_id]['discountType']))
                                        {
                                            $discountDetails = $papersInfo[$paper->paper_id]['discountType'];
                                            $typeName = "Basic Registration with {$discountDetails->discount_type_name} Discount";
                                            $payableTypes[$typeName] = array();
                                        }
                                        else
                                        {
                                            $typeName = "Basic Registration";
                                            $payable = $papersInfo[$paper->paper_id]['br'];
                                            $payableTypes[$typeName] = array("payableAmount"=>$payable);
                                        }
                                    }
                                    else
                                    {
                                        if (!empty($globalDiscount)) {
                                            foreach ($globalDiscount as $discount) {
                                                $typeName = "Basic Registration with {$discount->discount_type_name} Discount";
                                                $discountAmount = $discount->discount_type_amount * $papersInfo[$paper->paper_id]['br'];
                                                $payable = $papersInfo[$paper->paper_id]['br'] - $discountAmount;
                                                $discountTypeId = "_{$discount->discount_type_id}";
                                                $payableTypes[$typeName] = array("payableAmount"=>$payable, "discountTypeId"=>$discountTypeId, "isGlobal"=>true);
                                            }
                                        }
                                        if (!empty($paperWiseDiscount[$paper->paper_id])) {
                                            foreach ($paperWiseDiscount[$paper->paper_id] as $paperDiscount) {
                                                $typeName = "Basic Registration with {$paperDiscount->discount_type_name} Discount";
                                                $discountAmount = $paperDiscount->discount_type_amount * $papersInfo[$paper->paper_id]['br'];
                                                $payable = $papersInfo[$paper->paper_id]['br'] - $discountAmount;
                                                $discountTypeId = "_{$paperDiscount->discount_type_id}";
                                                $payableTypes[$typeName] = array("payableAmount"=>$payable, "discountTypeId"=>$discountTypeId);
                                            }
                                        }
                                        if(empty($globalDiscount) && empty($paperWiseDiscount[$paper->paper_id]))
                                        {
                                            $typeName = "Basic Registration";
                                            $payable = $papersInfo[$paper->paper_id]['br'];
                                            $payableTypes[$typeName] = array("payableAmount"=>$payable);
                                        }
                                    }
                                    foreach($payableTypes as $type=>$details)
                                    {
                                        ?>
                                        <span>
                                            <input type="radio" class="radio"
                                                   name="<?php echo $paper->submission_id; ?>_payheadAndDiscount" <?php if (!isset($papersInfo[$paper->paper_id]['ep'])) echo "checked"; ?>
                                                   value="BR<?php if(isset($details['discountTypeId'])) echo $details['discountTypeId']; ?>"
                                                   isGlobal="<?php echo (isset($details['isGlobal'])) ? "true" : "false"; ?>"
                                                   class="radio"
                                                   <?php
                                                   if (isset($papersInfo[$paper->paper_id]['pending']) && $papersInfo[$paper->paper_id]['pending'] == 0)
                                                       echo "disabled";
                                                   ?>>
                                                    <?php echo $type; ?>
                                                    <input type="hidden" value="<?php if(isset($details['payableAmount'])) echo $details["payableAmount"]; ?>">
                                        </span>
                                    <?php
                                    }
                                }
                                ?>
                                <?php
                                if (isset($papersInfo[$paper->paper_id]['ep'])) {
                                    ?>
                                    <span>
                                        <input type="radio"
                                               name="<?php echo $paper->submission_id; ?>_payheadAndDiscount"
                                            <?php if (!isset($papersInfo[$paper->paper_id]['br'])) echo "checked"; ?>
                                               value="EP"
                                               class="radio"
                                               <?php
                                               if (isset($papersInfo[$paper->paper_id]['pending']) && $papersInfo[$paper->paper_id]['pending'] == 0)
                                                   echo "disabled";
                                               ?> >
                                        Extra Paper
                                        <input type="hidden" value="<?php echo $papersInfo[$paper->paper_id]['ep']; ?>">
                                    </span>
                                <?php
                                }
                                ?>
                            </td>
                            <td>
                                <?php
/*                                if(isset($papersInfo[$paper->paper_id]['br']))
                                {
                                    */?><!--
                                    <input type="radio"
                                           name="<?php /*echo $paper->submission_id; */?>_payhead"
                                        <?php /*if(!isset($papersInfo[$paper->paper_id]['ep'])) echo "checked"; */?>
                                           value="BR" class="radio"> Basic Registration

                                <?php
/*                                }
                                if(isset($papersInfo[$paper->paper_id]['ep']))
                                {
                                    */?>
                                    <input type="radio"
                                           name="<?php /*echo $paper->submission_id; */?>_payhead"
                                        <?php /*if(!isset($papersInfo[$paper->paper_id]['br'])) echo "checked"; */?>
                                           value="EP" class="radio"> Extra Paper

                                --><?php
/*                                }
                                */?>
                            </td>
                            <td></td>
                        </tr>
                    <?php
                    }
                }
                ?>
                </tbody>
            </table>
            <div class="form-group contentBlock-top">
                <div class="col-sm-1">
                    <input id="morePayments" name="morePayments" type="checkbox" class="form-control">
                </div>
                <label class="col-sm-2" for="">Add payment for more authors with this transaction</label>
            </div>
        <?php
        }
        else if(empty($transDetails))
        {
        ?>
            No transaction selected
        <?php
        }
        ?>
        <div class="form-group contentBlock-top">
            <div class="col-sm-9">
                <input type="submit" class="btn btn-block btn-success">
            </div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function () {
        $(".radio").click(function()
        {
            var val = $(this).siblings().first().val()
            var ref = $(this).parent().parent().parent();
            $("td:nth-child(3)", ref).html(val);
            $("td:nth-child(7) input", ref).val(val);
            $("td:nth-child(7) input", ref).attr("max", val);
            $("td:nth-child(7) input", ref).attr("disabled", false);
        });
    });
</script>