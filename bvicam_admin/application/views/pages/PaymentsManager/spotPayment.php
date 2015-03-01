<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 2/16/15
 * Time: 10:23 AM
 */
?>
<div class="col-md-12 col-sm-12" id="contentPanel" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
    <h3 class="text-theme">New Spot Payment</h3>
    <hr>
    <form class="form-horizontal" method="post">
        <div class="bg-danger">
            <?php
            if(isset($pay_error)) echo $pay_error;
            ?>
        </div>
        <div class="bg-info">
            <?php
            if(isset($info))
            {
                foreach($info as $i)
                    echo $i . "<br>";
            }
            ?>
        </div>
        <div class="form-group">
            <label class="col-sm-3" for="trans_memberId">Transaction Member ID</label>
            <div class="col-sm-6">
                <input id="trans_memberId" name="trans_memberId" type="number" class="form-control" value="<?php echo set_value('trans_memberId'); ?>">
                <div class="bg-danger"><?php echo form_error('trans_memberId'); ?></div>
            </div>
        </div>
        <?php
        if(isset($papers))
        {
        ?>
            <div class="form-group">
                <label class="col-sm-3" for="trans_amount">Amount</label>
                <div class="col-sm-6">
                    <input id="trans_amount" name="trans_amount" type="number" min="0" class="form-control" value="<?php echo set_value('trans_amount'); ?>">
                    <div class="bg-danger"><?php echo form_error('trans_amount'); ?></div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3" for="trans_isWaivedOff">WaiveOff Transaction</label>
                <div class="col-sm-6">
                    <input type="radio" name="trans_isWaivedOff" value="true"><label>YES</label>
                    <input type="radio" name="trans_isWaivedOff" checked value="false"><label>NO</label>
                    <div class="bg-danger"><?php echo form_error('trans_isWaivedOff'); ?></div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3" for="trans_discountType">Select Discount</label>
                <div class="col-sm-6">
                    <select class="form-control" id="trans_discountType" name="trans_discountType">
                        <option value>No Discount</option>
                        <?php
                        foreach($discounts as $discount)
                        {
                        ?>
                            <option value="<?php echo $discount->discount_type_id; ?>">
                                <?php echo $discount->discount_type_name; ?>
                            </option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3" for="trans_payhead">Payhead</label>
                <div class="col-sm-6">
                    <select class="form-control" id="trans_payhead" name="trans_payhead">
                        <option value>Select Payhead</option>
                        <?php
                        foreach($paymentHeads as $payHead)
                        {
                            ?>
                            <option value="<?php echo $payHead->payment_head_id; ?>"><?php echo $payHead->payment_head_name; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <div class="bg-danger"><?php echo form_error('trans_payhead'); ?></div>
                </div>
            </div>
            <div class="form-group notForWaiveOff">
                <label class="col-sm-3" for="trans_no">Transaction Number</label>
                <div class="col-sm-6">
                    <input id="trans_no" name="trans_no" type="text" class="form-control" value="<?php echo set_value('trans_no'); ?>">
                    <div class="bg-danger"><?php echo form_error('trans_no'); ?></div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3" for="trans_paperId">Select Paper</label>
                <div class="col-sm-6">
                    <table class="table">
                        <tr>
                            <th>Paper Code</th>
                            <th>Paper Title</th>
                            <th></th>
                        </tr>
                        <?php
                        foreach($papers as $paper)
                        {
                        ?>
                            <tr>
                                <td><?php echo $paper->paper_code; ?></td>
                                <td><?php echo $paper->paper_title; ?></td>
                                <td><input type="radio" name="trans_paperId" value="<?php echo $paper->paper_id; ?>"></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
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