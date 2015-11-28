<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 1/26/15
 * Time: 5:16 PM
 */ ?>

<div class="col-sm-12 col-md-12" id="contentPanel">
    <h1 class="page-header"><?php if($isUnusedTransactionList) echo "Unused "; ?>Transactions</h1>
    <div class="row">
        <div id="trans-list" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="input-group">
                        <input type="text" class="searchValue form-control search" name="searchValue" maxlength="10"
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
                    <!--<th>Trans ID</th>-->
                    <th class="sort btn-link" data-sort="trans_order_id">Order Id</th>
                    <th class="sort btn-link" data-sort="trans_member_id">Trans Member ID</th>
                    <th class="sort btn-link" data-sort="trans_bank">Bank</th>
                    <th>Trans number</th>
                    <th class="sort btn-link" data-sort="trans_mode">Trans Mode</th>
                    <th class="sort btn-link" data-sort="trans_amount">Trans Amount</th>
                    <th class="sort btn-link" data-sort="trans_date">Trans Date</th>
                    <th class="sort btn-link" data-sort="trans_currency">Currency</th>
                    <th>Trans Amount(EQINR)</th>
                    <th class="sort btn-link" data-sort="trans_waivedoff">Waived Off</th>
                    <th class="sort btn-link" data-sort="trans_verified">Verification Status</th>
                    <?php
                    //if($isUnusedTransactionList)
                    {
                    ?>
                        <th class="sort btn-link" data-sort="trans_unused_amount">Unused Amount</th>
                    <?php
                    }
                    ?>
                    <th>Remarks</th>
                    <th>Op</th>
                </tr>
                </thead>
                <tbody class="list">
                <?php
                $sno = 1;
                foreach($transactions as $trans)
                {
                ?>
                    <tr>
                        <td><?php echo $sno++; ?></td>
                        <!--<td class="trans_id"><?php /*echo $trans->transaction_id; */?></td>-->
                        <td class="trans_order_id"><?php echo $trans->order_id; ?></td>
                        <td class="trans_member_id"><?php echo $trans->transaction_member_id; ?></td>
                        <td class="trans_bank"><?php echo $trans->transaction_bank; ?></td>
                        <td><?php echo $trans->transaction_number; ?></td>
                        <td class="trans_mode">
                            <?php
                            if($trans->is_waived_off == 0 && isset($transModes[$trans->transaction_mode]))
                                echo $transModes[$trans->transaction_mode]->transaction_mode_name;
                            else if($trans->is_waived_off == 0)
                            {
                                echo "Unknown transaction mode. Inform Admin.";
                            }
                            ?>
                        </td>
                        <td class="trans_amount"><?php echo $trans->transaction_amount; ?></td>
                        <td class="trans_date"><?php echo $trans->transaction_date; ?></td>
                        <td class="trans_currency"><?php echo $currencies[$trans->transaction_currency]['currency_name']; ?></td>
                        <td><?php echo $trans->transaction_EQINR; ?></td>
                        <td class="trans_waivedoff"><?php echo ($trans->is_waived_off) ? "Yes" : "No"; ?></td>
                        <td>
                            <select class="trans_verified">
                                <option value="0" <?php if($trans->is_verified == 0) echo "selected"; ?>>Not Verifed</option>
                                <option value="1" <?php if($trans->is_verified == 1) echo "selected"; ?>>Accepted</option>
                                <option value="2" <?php if($trans->is_verified == 2) echo "selected"; ?>>Rejected</option>
                            </select>
                            <div class="bg-danger"></div>
                            <div class="bg-info"></div>
                        </td>
                        <?php
                        //if($isUnusedTransactionList)
                        {
                            ?>
                            <td class="trans_unused_amount"><?php echo $trans->transaction_EQINR - $trans->amount_used; ?></td>
                        <?php
                        }
                        ?>
                        <td><?php echo $trans->transaction_remarks; ?></td>
                        <td>
                            <?php
                            if(($trans->transaction_EQINR - $trans->amount_used) > 0)
                            {
                                ?>
                                <a href="<?php echo "/".BASEURL."index.php/PaymentsManager/newPayment/".$trans->transaction_id; ?>"
                                   class="btn btn-default">Use for payment</a>
                            <?php
                            }
                            ?>
                        </td>
                    </tr>
                <?php
                }
                ?>
                </tbody>
            </table>
            <!--<a class="btn btn-success"  href="newRole"><span class="glyphicon glyphicon-plus"></span> Create new role</a>-->
        </div>
    </div>
</div>

<script>
    var options = {
        valueNames: [
            'trans_order_id',
            'trans_member_id',
            'trans_bank',
            'trans_mode',
            'trans_amount',
            'trans_date',
            'trans_currency',
            'trans_waivedoff',
            'trans_verified',
            'trans_unused_amount'
        ],
        page: 750
    };

    var transList = new List('trans-list', options);

    $(document).ready(function()
    {
        $('.trans_verified').change(function()
        {
            var ref = $(this);
            var ref_tr = $(this).parent().parent();
            var ref_td = $(this).parent();
            var transId = $(".trans_id", ref_tr).html();
            var status = $(this).val();
            $(".bg-info", ref_td).html("Updating...");
            $.ajax({
                type: "POST",
                url: "/<?php echo BASEURL; ?>index.php/TransactionManager/setTransactionVerificationStatus_AJAX",
                data: "trans_id=" + transId + "&verification_status=" +status,
                success: function(msg){
                    if(msg == "true")
                    {
                        $(".bg-info", ref_td).html("Updated");
                    }
                    else
                    {
                        $(".bg-info", ref_td).html("");
                        $(".bg-danger", ref_td).html("Could not update");
                    }
                }
            });
        })
    });
</script>