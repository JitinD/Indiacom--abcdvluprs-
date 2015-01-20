<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 1/19/15
 * Time: 10:22 AM
 */
?>

<div class="col-sm-12 col-md-12 main">
    <h1 class="page-header">Payment Breakup</h1>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <table class="table table-responsive table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Mid</th>
                    <th>Member Name</th>
                    <th>Payment Breakup</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $sno = 0;
                foreach($membersPayments as $memberId=>$memberPayments)
                {
                    ?>
                    <tr>
                        <td><?php echo ++$sno; ?></td>
                        <td><?php echo $memberId; ?></td>
                        <td><?php echo $memberDetails[$memberId]['member_name']; ?></td>
                        <td>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>PaperId</th>
                                    <th>Payhead</th>
                                    <th>Paid</th>
                                    <th>Payable<br>(w/o discount and waiveoff)</th>
                                    <th>Waiveoff</th>
                                    <th>Payable<br>(with waiveoff)</th>
                                    <th>Discount</th>
                                    <th>Payable<br>(with waiveoff and discount)</th>
                                    <th>Outstanding</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach($memberPayments as $memberPayment)
                                {
                                    ?>
                                    <tr>
                                        <td><?php echo $memberPayment->payment_paper_id; ?></td>
                                        <td><?php echo $payheadDetails[$memberPayment->payment_head]; ?></td>
                                        <td>
                                            <button class="btn btn-link">
                                                Rs. <?php echo $memberPayment->paid_amount; ?>/-
                                            </button>
                                        </td>
                                        <td>Rs. <?php echo $payableAmounts[$memberPayment->payment_payable_class]; ?>/-</td>
                                        <td>Rs. <?php echo $memberPayment->waiveoff_amount; ?>/-</td>
                                        <td>Rs. <?php echo $payableAmounts[$memberPayment->payment_payable_class]-$memberPayment->waiveoff_amount; ?>/-</td>
                                        <td>Rs. /-</td>
                                        <td>Rs. /-</td>
                                        <td>Rs. /-</td>
                                    </tr>
                                    <tr style="display: none;">
                                        <td colspan="10">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th>Payment Details</th>
                                                </tr>
                                                </thead>
                                            </table>
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
                ?>
                </tbody>
            </table>
            <a class="btn btn-success"  href="newRole"><span class="glyphicon glyphicon-plus"></span> Create new role</a>
        </div>
    </div>
</div>