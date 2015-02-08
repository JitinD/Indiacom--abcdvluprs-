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
<div id="step1">
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
        } else {
            foreach ($papers as $paper) {
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
                               value="
                               <?php
                               if (isset($papersInfo[$paper->paper_id]['pending']))
                                   echo $papersInfo[$paper->paper_id]['pending'];
                               ?>"
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
                                           ?> >
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
                    <td><a href="">Check</a></td>
                    <td></td>
                </tr>
            <?php
            }
        }
        ?>

        </tbody>
    </table>
    <div id="addMoreAuthors">
    </div>
    <hr>
    <!--<div class="contentBlock-top">
        <button type="button" class="btn btn-success" id="button_addMoreAuthors">
            Pay for Another Author &nbsp;<span class="glyphicon glyphicon-plus"></span>
        </button>
    </div>-->
    <hr>
    <span class="h2 text-danger">
        Amount in the selection: <span id="totalSelectedAmount"></span>
    </span>
    </div>
<div id="step2">
    <div class="form-group">
        <label class="col-sm-3 control-label" for="paymentMode">Add Mode of Payment</label>
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
        <label class="col-sm-3" for="transno">Amount</label>
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
            <input id="transdate" name="trans_date" type="date" class="form-control">
        </div>
        <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
            <?php echo form_error('trans_date'); ?>
        </div>
    </div>
    <!--<div class="form-group col-sm-6">
        <button type="button" class="btn btn-success" id="button_addMoreModes">
            Add More Payment Details <span class="glyphicon glyphicon-plus"></span>
        </button>
    </div>-->
    <div class="form-group contentBlock-top">
        <div class="col-sm-12">
            <input type="submit" class="btn btn-block btn-success" value="Submit Details for Verification">
        </div>
    </div>
</div>
</form>
<div class="contentBlock-top">
    <button class="btn btn-primary" id="showStep1">
        Previous <span class="glyphicon glyphicon-chevron-left"></span>
    </button>
    <button class="btn btn-primary" id="showStep2">
        Next <span class="glyphicon glyphicon-chevron-right"></span>
    </button>
</div>
</div>
<script>
    $(document).ready(function () {
        $("#step1").show();
        $("#step2").hide();
        $("#showStep1").hide();

        $("#showStep1").click(function () {
            $("#step1").show(500);
            $("#step2").hide(500);
            $("#showStep1").hide();
            $("#showStep2").show();
        });

        $("#showStep2").click(function () {
            $("#step2").show(500);
            $("#step1").hide(500);
            $("#showStep1").show();
            $("#showStep2").hide();
        });

        $("#addAuthor").click(function () {

        });
        $("#button_addMoreAuthors").click(function () {
            var html1 =
                "<hr>" +
                    "<span class=\"h3 text-primary\">" +
                    "Outstanding Amount for Member ID XY : xyz" +
                    "</span>";

            var html2 =
                "<div class=\"contentBlock-top\">" +
                    "<table class=\"table table-responsive table-striped table-hover\">" +
                    "<thead>" +
                    "<tr>" +
                    "<th>Paper ID</th>" +
                    "<th>Paper Title</th>" +
                    "<th>Pending Amount</th>" +
                    "<th>Type</th>" +
                    "<th></th>" +
                    "</tr>" +
                    "</thead>" +
                    "<tbody>" +
                    "<tr>" +
                    "<td></td>" +
                    "<td></td>" +
                    "<td></td>" +
                    "<td>" +
                    "<div class=\"btn-group\">" +
                    "<label class=\"btn btn-info\">" +
                    "<input type=\"checkbox\" autocomplete=\"off\"> Basic Registration" +
                    "</label>" +
                    "</div>" +
                    "</td>" +
                    "</tr>" +
                    "</tbody>" +
                    "</table>" +
                    "</div>";
            var html = html1 + html2;

            $("#addMoreAuthors").append(html);
        });

        /*        $("#button_addMoreModes").click(function(){
         var html1=
         "<hr>"+
         "<span class=\"h3\">"+
         "Add Details for Another Payment"+
         "</span>";

         var html2=
         "<div class=\"form-group contentBlock-top\">"+
         "<label class=\"col-sm-3\" for=\"paymentMode\">Add Mode of Payment</label>"+
         "<div class=\"col-sm-6\">"+
         "<select id=\"paymentMode\" class=\"form-control\">"+
         "<option>Cheque</option>"+
         "<option>Demand Draft</option>"+
         "</select>"+
         "</div>"+
         "</div>"+
         "<div class=\"form-group\">"+
         "<label class=\"col-sm-3\" for=\"transno\">Amount</label>"+
         "<div class=\"col-sm-6\">"+
         "<input id=\"transno\" type=\"text\" class=\"form-control\" required>"+
         "</div>"+
         "</div>"+
         "<div class=\"form-group\">"+
         "<label class=\"col-sm-3\" for=\"transno\">Bank Name (N/A for Cash)</label>"+
         "<div class=\"col-sm-6\">"+
         "<input id=\"transno\" type=\"text\" class=\"form-control\">"+
         "</div>"+
         "</div>"+
         "<div class=\"form-group\">"+
         "<label class=\"col-sm-3\" for=\"transno\">Cheque No / DD No / Wired Trans ID</label>"+
         "<div class=\"col-sm-6\">"+
         "<input id=\"transno\" type=\"text\" class=\"form-control\">"+
         "</div>"+
         "</div>"+
         "<div class=\"form-group\">"+
         "<label class=\"col-sm-3\" for=\"transdate\">Cheque Date / DD Date / Wired Trans Date</label>"+
         "<div class=\"col-sm-6\">"+
         "<input id=\"transdate\" type=\"date\" class=\"form-control\">"+
         "</div>"+
         "</div>";

         var html = html1+html2;

         $("#addMoreModes").append(html);
         });*/

        $(".radio").click(function () {
            var val = $(this).siblings().first().val()
            var ref = $(this).parent().parent().parent();
            $("td:nth-child(3)", ref).html(val);
            $("td:nth-child(7) input", ref).val(val);
            $("td:nth-child(7) input", ref).attr("max", val);
            $("td:nth-child(7) input", ref).attr("disabled", false);
            calculateTotalSelectedAmount();
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
            calculateTotalSelectedAmount()
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