<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 1/25/15
 * Time: 1:04 PM
 */
?>
<div class="col-md-12 col-sm-12">
    <h1 class="page-header">Create New Transaction</h1>

    <form class="form-horizontal" method="post">
        <div class="bg-danger">
            <?php
            if (isset($trans_error)) echo $trans_error;
            ?>
        </div>
        <div class="col-md-6">
            <div class="form-group notForWaiveOff">
                <label class="col-sm-3" for="paymentMode">Mode of Payment</label>
                    <div class="col-sm-6">
                        <select id="paymentMode" name="trans_mode" class="form-control">
                            <?php
                            foreach($transaction_modes as $trans_mode)
                            {
                            ?>
                                <option value="<?php echo $trans_mode->transaction_mode_id; ?>" <?php if(set_value('trans_mode')==$trans_mode->transaction_mode_id) echo "selected"; ?>>
                                    <?php echo $trans_mode->transaction_mode_name; ?>
                                </option>
                            <?php
                            }
                            ?>
                        </select>
                    <div class="bg-danger"><?php echo form_error('trans_mode'); ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-sm-3" for="transno">Amount</label>

                <div class="col-sm-6">
                    <input id="amount" name="trans_amount" type="text" class="form-control"
                           value="<?php echo set_value('trans_amount'); ?>">

                    <div class="bg-danger"><?php echo form_error('trans_amount'); ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-sm-3" for="transno">Currency</label>

                <div class="col-sm-6">
                    <select id="currency" name="trans_currency" class="form-control" required>
                        <?php
                        foreach ($currencies as $currency) {
                            ?>
                            <option value="<?php echo $currency->currency_id; ?>">
                                <?php echo $currency->currency_name; ?>
                            </option>
                        <?php
                        }
                        ?>
                    </select>

                    <div class="bg-danger"><?php echo form_error('trans_currency'); ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group notForWaiveOff">
                <label class="col-sm-3" for="transno">Bank</label>

                <div class="col-sm-6">
                    <input id="bank" name="trans_bank" type="text" class="form-control"
                           value="<?php echo set_value('trans_bank'); ?>">

                    <div class="bg-danger"><?php echo form_error('trans_bank'); ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group notForWaiveOff">
                <label class="col-sm-3" for="transno">Cheque No / DD No / Wired Trans ID</label>

                <div class="col-sm-6">
                    <input id="transno" name="trans_no" type="text" class="form-control"
                           value="<?php echo set_value('trans_no'); ?>">

                    <div class="bg-danger"><?php echo form_error('trans_no'); ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-sm-3" for="transdate">Date</label>

                <div class="col-sm-6">
                    <input id="date" name="trans_date" type="date" class="form-control"
                           value="<?php echo set_value('trans_date'); ?>">

                    <div class="bg-danger"><?php echo form_error('trans_date'); ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-sm-3" for="transdate">Transaction Member ID</label>

                <div class="col-sm-6">
                    <input id="memberid" name="trans_memberId" type="text" class="form-control"
                           value="<?php echo set_value('trans_memberId'); ?>">

                    <div class="bg-danger"><?php echo form_error('trans_memberId'); ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-sm-3" for="transdate">Remarks</label>

                <div class="col-sm-6">
                    <input id="remarks" name="trans_remarks" type="text" class="form-control"
                           value="<?php echo set_value('trans_remarks'); ?>">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group contentBlock-top">
                <div class="col-sm-1">
                    <input id="waiveOff" name="trans_isWaivedOff" type="checkbox" class="form-control">
                </div>
                <label class="col-sm-2" for="">WaiveOff Transaction</label>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group contentBlock-top">
                <input type="submit" class="btn btn-block btn-lg btn-default">
            </div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function () {
        checkWaiveOffStatus();
        $("#waiveOff").click(function () {
            checkWaiveOffStatus();
        });

        function checkWaiveOffStatus() {
            if ($("#waiveOff").is(":checked")) {
                $(".notForWaiveOff").attr("style", "display:none;");
                $("#waiveOff").val(true);
            }
            else {
                $(".notForWaiveOff").attr("style", "display:block;");
                $("#waiveOff").val(false);
            }
        }
    });
</script>