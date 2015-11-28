<div class="col-md-12 col-sm-12 col-xs-12" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
    <h3 class="text-theme">Payments</h3>
    <hr>
    <div class="bg-danger h4">
        <?php
        if (isset($pay_error))
            echo $pay_error;
        ?>
    </div>
    <div class="bg-info h4">
        <?php
        if (isset($message)) {
            foreach ($message as $msg) {
                echo "<div>$msg</div>";
            }
        }
        ?>
    </div>
    <span class="h5 center-block text-success">
        Registration Category
        <span class="bg-primary">
            <?php
            foreach ($registrationCategories as $category) {
                if ($category['member_category_id'] == $registrationCat->member_category_id) {
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
            if ($isProfBodyMember)
                echo "Yes";
            else
                echo "No";
            ?>
        </span>
    </span>
    <form id="subForm" method="get">
        <span class="h5 center-block text-success">
            Transaction Currency
            <?php
            foreach ($currencies as $currency) {
                if ($currency->currency_id == $selectedCurrency) {
                    ?>
                    <span class="bg-primary">
                        <?php echo $currency->currency_name; ?>
                    </span>
                <?php
                } else {
                    ?>
                    <span class="btn-link currency" value="<?php echo $currency->currency_id; ?>">
                        <?php echo $currency->currency_name; ?>
                    </span>
                <?php
                }
            }
            ?>
            <input id="trans_currency" type="hidden" name="trans_currency">
        </span>
        <span class="h5 center-block text-success">
            Transaction Date
                <input type="date" class="form-control" style="width: 180px; display: inline;"
                       value="<?php echo $transDate; ?>" id="transDate" name="trans_date">
        </span>
    </form>
    <?php
    if(empty($papersInfo))
    {
        echo "Payments have not started yet. You cannot make any payments now.";
    }
    else
    {
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
        <form class="for m-horizontal" method="post">
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
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Paper Code</th>
                    <th>Paper Title</th>
                    <th>Payable</th>
                    <th>Waive Off</th>
                    <th>Paid</th>
                    <th>Pending</th>
                    <th>Pay Amount</th>
                    <th>Select payable</th>
                    <th>Transaction(s) Verified</th>
                    <th>Remarks</th>
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
                }
                else {
                    foreach ($papers as $paper) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $paper->paper_code; ?>
                                <input type="hidden" name="submissionIds[]" value="<?php echo $paper->submission_id; ?>">
                            </td>
                            <td><?php echo $paper->paper_title; ?></td>
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
                            <td class="payable">
                                <?php
                                if(isset($papersInfo[$paper->paper_id]['paid']))
                                    echo $payable;
                                ?>
                            </td>
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
                                <span>
                                    <?php
                                    if(isset($papersInfo[$paper->paper_id]['paid']))
                                        echo $pendingAmount;
                                    ?>
                                </span>
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
                                    if(
                                        (
                                            isset($validDiscounts['paperSpecific'][$paymentHead->payment_head_id][$paper->paper_id])
                                            || isset($validDiscounts['global'][$paymentHead->payment_head_id])
                                            || isset($papersInfo[$paper->paper_id]['discountType'])
                                        ) &&
                                        (
                                            !isset($papersInfo[$paper->paper_id]['paid'])
                                            || isset($papersInfo[$paper->paper_id]['discountType'])
                                        )

                                    )
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
                                                <?php echo $paymentHead->payment_head_name." with ".$discount->discount_type_name; ?>
                                            <?php
                                            }
                                        }
                                    }
                                    else
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
                            <!--td><a href="">Check</a></td-->
                            <td></td>
                            <td></td>
                        </tr>
                    <?php
                    }
                }
                ?>

                </tbody>
            </table>
            <hr>
            <span class="h2 text-danger">
                Amount in the selection: <span id="totalSelectedAmount"></span>
            </span>
            <?php
            if(!empty($mappedTransactions))
            {
            ?>
                <div class="form-group control-label">
                    <label class="col-sm-3" for="paymentMode">You have one or more transactions assigned to you by some other author(s)</label>
                    <div class="col-sm-9">
                        Select the transaction from the list
                        <select name="mapped_transaction_id" id="mappedTransaction">
                            <option value="-1">Use my own transaction</option>
                            <?php
                            foreach($mappedTransactions as $transaction)
                            {
                            ?>
                                <option value="<?php echo $transaction->transaction_id; ?>"
                                        data-amount="<?php echo $transaction->transaction_EQINR; ?>"
                                        data-mode="<?php echo $transaction->transaction_mode; ?>"
                                        data-bank="<?php echo $transaction->transaction_bank; ?>"
                                        data-date="<?php echo $transaction->transaction_date; ?>">
                                    Unused Amount: <?php echo $transaction->transaction_EQINR - $transactionUsedAmount[$transaction->transaction_id]; ?>
                                </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                        <?php echo form_error('trans_mode'); ?>
                    </div>
                </div>
            <?php
            }
            ?>
            <div class="form-group control-label">
                <label class="col-sm-3" for="paymentMode">Add Mode of Payment</label>
                <div class="col-sm-9">
                    <select id="paymentMode" name="trans_mode" class="form-control" required>
                        <?php
                        foreach($transaction_modes as $trans_mode)
                        {
                            if($trans_mode->transaction_mode_name == "CASH")
                                continue;
                            ?>
                            <option value="<?php echo $trans_mode->transaction_mode_id;  ?>">
                                <?php echo $trans_mode->transaction_mode_name;  ?>
                            </option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                    <?php echo form_error('trans_mode'); ?>
                </div>
            </div>
            <div class="form-group control-label">
                <label class="col-sm-3" for="transno">Transaction Amount</label>
                <div class="col-sm-9">
                    <input id="transamt" name="trans_amount" type="text" class="form-control" required>
                </div>
                <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                    <?php echo form_error('trans_amount'); ?>
                </div>
            </div>
            <div class="form-group control-label">
                <label class="col-sm-3" for="transno">Bank</label>
                <div class="col-sm-9">
                    <input id="transbank" name="trans_bank" type="text" class="form-control">
                </div>
                <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                    <?php echo form_error('trans_bank'); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3" for="transno">Cheque No / DD No / Wired Trans ID</label>
                <div class="col-sm-9">
                    <input id="transno" name="trans_no" type="text" class="form-control">
                </div>
                <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                    <?php echo form_error('trans_no'); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3" for="transdate">Cheque Date / DD Date / Wired Trans Date</label>
                <div class="col-sm-9">
                    <input id="transdate" name="trans_date" type="date" class="form-control" value="<?php echo $transDate; ?>">
                </div>
                <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                    <?php echo form_error('trans_date'); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3">Use transaction for other authors also</label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-1">
                            <input type="checkbox" id="multiAuthorTrans" name="multi_author_trans" class="form-control" value="false">
                        </div>
                        <div class="col-sm-2">
                            <input type="number" id="authorId" class="form-control" style="display: none;">
                            <span id="transAuthorIdsList"></span>
                        </div>
                        <div class="col-sm-9">
                            <button type="button" id="addAuthors" class="btn btn-primary" style="display: none;">
                                <span class="glyphicon-plus">Add Author</span>
                            </button>
                        </div>
                    </div>
                    <div class="row" id="authorList">
                        <ul class="list">
                            <li>
                                <span class="authorId"></span>
                                <span class="btn-link removeAuthor">Remove</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="form-group contentBlock-top">
                <div class="col-sm-12">
                    <input type="submit" class="btn btn-block btn-success" value="Submit Details for Verification">
                </div>
            </div>
        </form>
    <?php
    }
    ?>
</div>
</div>
<script>
    $(document).ready(function () {
        var listOptions = {
            valueNames: ['authorId']
        };

        var authorList = new List('authorList', listOptions);
        authorList.clear();
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

        $('#multiAuthorTrans').change(function() {
            if($(this).is(":checked"))
            {
                $(this).val(true);
                $("#addAuthors").attr("style","display:block;");
                $("#authorId").attr("style","display:block;");
            }
            else
            {
                $(this).val(false);
                $("#addAuthors").attr("style","display:none;");
                $("#authorId").attr("style","display:none;");
            }
        });

        $('#addAuthors').click(function() {
            var authorId = $("#authorId").val();
            if(authorId != 0)
            {
                authorList.add({authorId: authorId});
                $('#transAuthorIdsList').append("<input type=\"hidden\" name=\"trans_authorIds[]\" value=\"" + authorId + "\">");
                $(".removeAuthor").unbind("click");
                $('.removeAuthor').click(function() {
                    var authorId = $(".authorId", $(this).parent()).html();
                    authorList.remove("authorId", authorId);
                });
            }
        });

        $('#transDate').change(function () {
            $('#subForm').submit();
        });

        $('.currency').click(function() {
            var value = $(this).attr("value");
            $("input", $(this).parent()).val(value);
            $('#subForm').submit();
        })

        $('.payAmounts').change(function () {
            calculateTotalSelectedAmount();
        });

        $('.radio').click(function() {
            calculateTotalSelectedAmount();
        });

        $("#mappedTransaction").change(function () {
            var selectedOp = $("#mappedTransaction :selected");
            if($(selectedOp).val() != -1)
            {
                $("#transamt").val($(selectedOp).attr("data-amount"));
                $("#transamt").attr("disabled", "disabled");
                $("#paymentMode").val($(selectedOp).attr("data-mode"));
                $("#paymentMode").attr("disabled", "disabled");
                $("#transbank").val($(selectedOp).attr("data-bank"));
                $("#transbank").attr("disabled", "disabled");
                $("#transdate").val($(selectedOp).attr("data-date"));
                $("#transdate").attr("disabled", "disabled");
                var node = $("#transno").parent().parent();
                $("#errorText", node).text("Enter the transaction number of this transaction. (This is required for verification purpose)");
            }
            else
            {
                $("#transamt").val(calculateTotalSelectedAmount());
                $("#transamt").removeAttr("disabled");
                $("#transbank").val("");
                $("#transbank").removeAttr("disabled");
                $("#transdate").removeAttr("disabled");
                $("#paymentMode").removeAttr("disabled");
                var node = $("#transno").parent().parent();
                $("#errorText", node).text("");
            }
        });

        calculateTotalSelectedAmount();

        function calculateTotalSelectedAmount() {
            var totalAmt = 0;
            $('.payAmounts').each(function (i, obj) {
                if ($(obj).val() != "")
                    totalAmt += parseInt($(obj).val());
            });
            $('#totalSelectedAmount').html(totalAmt);
            $('#transamt').val(totalAmt);
        }
    });
</script>