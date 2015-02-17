<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 1/18/15
 * Time: 6:02 PM
 */
?>

<div class="col-sm-10 col-md-10" id="contentPanel">
    <h3 class="text-theme">Payments</h3>
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
                if(empty($membersPayments))
                {
                ?>
                    <tr>
                        <td colspan="4">No members have paid yet!</td>
                    </tr>
                <?php
                }
                else
                {
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
                                        <th>Payable<br>(w/o discount and waiveoff)</th>
                                        <th>Waiveoff</th>
                                        <th>Discount</th>
                                        <th>Discount Type</th>
                                        <th>Payable<br>(with waiveoff and discount)</th>
                                        <th>Paid</th>
                                        <th>Outstanding</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach($memberPayments as $memberPayment)
                                    {
                                        ?>
                                        <tr>
                                            <td><?php echo $memberPayment->submission_paper_id; ?></td>
                                            <td><?php echo $payheadDetails[$memberPayment->payable_class_payhead_id]; ?></td>
                                            <td>Rs. <?php echo $payableAmt = $memberPayment->payable_class_amount; ?>/-</td>
                                            <td>Rs. <?php echo $waiveOffAmt = $memberPayment->waiveoff_amount; ?>/-</td>
                                            <td>Rs. <?php echo $discountAmt = floor($memberPayment->payable_class_amount * $memberPayment->discount_type_amount); ?>/-</td>
                                            <td>
                                                <?php
                                                if($memberPayment->payment_discount_type != null)
                                                    echo $discountTypes[$memberPayment->payment_discount_type]->discount_type_name;
                                                else
                                                    echo "N.A.";
                                                ?>
                                            </td>
                                            <td>Rs. <?php echo $actualPayable = $payableAmt - ($waiveOffAmt - $discountAmt); ?>/-</td>
                                            <td>
                                                <button class="btn btn-link">
                                                    Rs. <?php echo $paidAmt = $memberPayment->paid_amount; ?>/-
                                                </button>
                                            </td>
                                            <td>Rs. <?php echo $actualPayable - $paidAmt; ?>/-</td>
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
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>