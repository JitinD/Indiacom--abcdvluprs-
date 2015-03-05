<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 3/5/15
 * Time: 6:55 PM
 */
?>

<div class="col-sm-12 col-md-12" id="contentPanel">
    <h1 class="page-header">Payment Breakup/Transfer</h1>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <table class="table table-hover table-condensed">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Transaction Id</th>
                    <th>Transaction EQINR</th>
                    <th>Transaction Date</th>
                    <th>Verification Status</th>
                    <th>Waived Off</th>
                    <th>Amount used in payment</th>
                    <th>Payment Remark</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach($paymentBreakups as $breakup)
                {
                ?>
                    <tr>
                        <td></td>
                        <td><?php echo $breakup->payment_trans_id; ?></td>
                        <td><?php echo $breakup->transaction_EQINR; ?></td>
                        <td><?php echo $breakup->transaction_date; ?></td>
                        <td><?php echo $breakup->is_verified; ?></td>
                        <td><?php echo $breakup->is_waived_off; ?></td>
                        <td><?php echo $breakup->payment_amount_paid; ?></td>
                        <td><?php echo $breakup->payment_remarks; ?></td>
                        <td>
                            <form method="post">
                                <input type="number" name="transfer_amount" class="form-control" placeholder="Transfer Amount">
                                <span><?php echo form_error('transfer_amount'); ?></span>
                                <input type="hidden" name="transaction_id" value="<?php echo $breakup->payment_trans_id; ?>">
                                <input type="hidden" name="payment_id" value="<?php echo $breakup->payment_id; ?>">
                                <input type="submit" class="form-control" value="Transfer">
                            </form>
                        </td>
                    </tr>
                <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>