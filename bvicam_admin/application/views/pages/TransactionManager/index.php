<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 1/26/15
 * Time: 5:16 PM
 */ ?>

<div class="col-sm-12 col-md-12 ">
    <h1 class="page-header"><?php if($isUnusedTransactionList) echo "Unused "; ?>Transactions</h1>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <table class="table table-responsive table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Trans ID</th>
                    <th>Trans Member ID</th>
                    <th>Bank</th>
                    <th>Trans number</th>
                    <th>Trans Mode</th>
                    <th>Trans Amount</th>
                    <th>Trans Date</th>
                    <th>Currency</th>
                    <th>Trans Amount(EQINR)</th>
                    <th>Waived Off</th>
                    <th>Verified</th>
                    <?php
                    if($isUnusedTransactionList)
                    {
                    ?>
                        <th>Unused Amount</th>
                    <?php
                    }
                    ?>
                    <th>Remarks</th>
                    <th>Op</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $sno = 1;
                foreach($transactions as $trans)
                {
                ?>
                    <tr>
                        <td><?php echo $sno++; ?></td>
                        <td><?php echo $trans->transaction_id; ?></td>
                        <td><?php echo $trans->transaction_member_id; ?></td>
                        <td><?php echo $trans->transaction_bank; ?></td>
                        <td><?php echo $trans->transaction_number; ?></td>
                        <td>
                            <?php
                            if($trans->is_waived_off == 0)
                                echo $transModes[$trans->transaction_mode]['transaction_mode_name'];
                            ?>
                        </td>
                        <td><?php echo $trans->transaction_amount; ?></td>
                        <td><?php echo $trans->transaction_date; ?></td>
                        <td><?php echo $currencies[$trans->transaction_currency]['currency_name']; ?></td>
                        <td><?php echo $trans->transaction_EQINR; ?></td>
                        <td><?php echo ($trans->is_waived_off) ? "Yes" : "No"; ?></td>
                        <td><?php echo ($trans->is_verified) ? "Yes" : "No"; ?></td>
                        <?php
                        if($isUnusedTransactionList)
                        {
                            ?>
                            <td><?php echo $trans->transaction_EQINR - $trans->amount_used; ?></td>
                        <?php
                        }
                        ?>
                        <td><?php echo $trans->transaction_remarks; ?></td>
                        <td>
                            <?php
                            if($isUnusedTransactionList)
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