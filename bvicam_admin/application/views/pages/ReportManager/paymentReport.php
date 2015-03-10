<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 3/9/15
 * Time: 9:09 PM
 */
?>

<div class="col-md-12 col-sm-12" id="contentPanel" xmlns="http://www.w3.org/1999/html">
    <h1 class="page-header">Payment Report</h1>
    <table class="table table-condensed table-bordered" style="font-size: .7em;">
        <thead>
        <tr>
            <th>Mid</th>
            <th>Pid</th>
            <th>Member Name</th>
            <th>Track ID</th>
            <th>Session ID</th>
            <th>Reg Cat</th>
            <th>Prof Body Member</th>
            <th>Pay Date</th>
            <th>Pay Mode</th>
            <th>Trans No</th>
            <th>Bank</th>
            <th>BR_Payable</th>
            <th>EP_Payable</th>
            <th>OLPC_Payable</th>
            <th>PR_Payable</th>
            <th>WaiveOff</th>
            <th>Paid Amount</th>
            <th>Discount Type</th>
            <th>Discount Amt</th>
            <th>Pending</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($submissions as $submission)
        {
        ?>
            <tr>
                <td class="submission_member_id">
                    <?php echo $submission->member_id; ?>
                </td>
                <td class="submission_paper_code">
                    <?php echo $submission->paper_code; ?>
                </td>
                <td class="member_name">
                    <?php echo $membersInfo[$submission->member_id]['memberBasicInfo']['member_name']; ?>
                </td>
                <td class="track_id">
                    <?php echo $submission->track_id; ?>
                </td>
                <td class="session_id">
                    <?php echo $submission->session_id; ?>
                </td>
                <td class="reg_category">
                    <?php
                    if(isset($payables[$submission->member_id][$submission->paper_id]['paid']))
                    {
						$payheads = $payables[$submission->member_id][$submission->paper_id]['payhead'];
						foreach($payheads as $index=>$payhead)
						{
							if(isset($payables[$submission->member_id][$submission->paper_id]['payableClass'][$index]->payable_class_registration_category))
							{
								echo $memCategories[$payables[$submission->member_id][$submission->paper_id]['payableClass'][$index]->payable_class_registration_category]['member_category_name'];
								break;
							}
						}
                    }
                    else
                    {
                        echo $memCategories[$membersInfo[$submission->member_id]['memberBasicInfo']['member_category_id']]['member_category_name'];
                    }
                    ?>
                </td>
                <td class="prof_body_member">
                    <?php
                    if(isset($payables[$submission->member_id][$submission->paper_id]['paid']))
                        echo ($payables[$submission->member_id][$submission->paper_id]['payableClass'][0]->is_general == 0) ? "Yes" : "No";
                    else
                        echo ($membersInfo[$submission->member_id]['isProfBodyMember']) ? "Yes" : "No";
                    ?>
                </td>
                <td class="pay_date">
                    <?php
                    if(isset($payables[$submission->member_id][$submission->paper_id]['paid']))
                        echo $membersInfo[$submission->member_id]['transactions'][0]->transaction_date;
                    ?>
                </td>
                <td class="pay_mode">
                    <?php
                    if(isset($payables[$submission->member_id][$submission->paper_id]['paid']))
                        echo $transModes[$membersInfo[$submission->member_id]['transactions'][0]->transaction_mode]->transaction_mode_name;
                    ?>
                </td>
                <td class="trans_no">
                    <?php
                    if(isset($payables[$submission->member_id][$submission->paper_id]['paid']))
                        echo $membersInfo[$submission->member_id]['transactions'][0]->transaction_number;
                    ?>
                </td>
                <td class="Bank">
                    <?php
                    if(isset($payables[$submission->member_id][$submission->paper_id]['paid']))
                        echo $membersInfo[$submission->member_id]['transactions'][0]->transaction_bank;
                    ?>
                </td>
                <td class="br_payable">
                    <?php
                    $payheads = $payables[$submission->member_id][$submission->paper_id]['payhead'];
                    $payableClasses = $payables[$submission->member_id][$submission->paper_id]['payableClass'];
                    $brpayable = 0;
                    foreach($payheads as $index=>$payhead)
                    {
                        if($payhead->payment_head_name == "BR")
                        {
                            if(isset($payables[$submission->member_id][$submission->paper_id]['paid']))
                            {
                                echo $brpayable = $payables[$submission->member_id][$submission->paper_id]['payable'][$index];
                            }
                            else
                            {
                                echo "<u>" . $brpayable = $payableClasses[$index]->payable_class_amount . "</u>";
                            }
                            $brpayableActual = $payableClasses[$index]->payable_class_amount;
                        }
                    }
                    ?>
                </td>
                <td class="ep_payable">
                    <?php
                    $payheads = $payables[$submission->member_id][$submission->paper_id]['payhead'];
                    $payableClasses = $payables[$submission->member_id][$submission->paper_id]['payableClass'];
                    $eppayable = 0;
                    foreach($payheads as $index=>$payhead)
                    {
                        if($payhead->payment_head_name == "EP")
                        {
                            if(isset($payables[$submission->member_id][$submission->paper_id]['paid']))
                            {
                                echo $eppayable = $payables[$submission->member_id][$submission->paper_id]['payable'][$index];
                            }
                            else
                            {
                                echo "<u>" . $eppayable = $payableClasses[$index]->payable_class_amount . "</u>";
                            }
                        }
                    }
                    ?>
                </td>
                <td class="olpc_payable">
                    <?php
                    $payheads = $payables[$submission->member_id][$submission->paper_id]['payhead'];
                    $payableClasses = $payables[$submission->member_id][$submission->paper_id]['payableClass'];
                    $olpcpayable = 0;
                    foreach($payheads as $index=>$payhead)
                    {
                        if($payhead->payment_head_name == "OLPC")
                        {
                            if(isset($payables[$submission->member_id][$submission->paper_id]['paid']))
                            {
                                echo $olpcpayable = $payables[$submission->member_id][$submission->paper_id]['payable'][$index];
                            }
                            else
                            {
                                echo "<u>" . $olpcpayable = $payableClasses[$index]->payable_class_amount . "</u>";
                            }
                        }
                    }
                    ?>
                </td>
                <td class="pr_payable">
                    <?php
                    $prpayable = 0;
                    ?>
                </td>
                <td class="waiveoff">
                    <?php
                    if(isset($payables[$submission->member_id][$submission->paper_id]['paid']))
                    {
                        $waiveOffs = $payables[$submission->member_id][$submission->paper_id]['waiveOff'];
                        $waiveOffAmt = 0;
                        foreach($waiveOffs as $waiveOff)
                        {
                            $waiveOffAmt += $waiveOff;
                        }
                        echo $waiveOffAmt;
                    }
                    ?>
                </td>
                <td class="paid_amount">
                    <?php
                    if(isset($payables[$submission->member_id][$submission->paper_id]['paid']))
                    {
                        $paids = $payables[$submission->member_id][$submission->paper_id]['paid'];
                        $paidAmt = 0;
                        foreach($paids as $paid)
                        {
                            $paidAmt += $paid;
                        }
                        echo $paidAmt;
                    }
                    ?>
                </td>
                <?php
                $discountAmt = 0;
                if(isset($payables[$submission->member_id][$submission->paper_id]['paid']) && isset($payables[$submission->member_id][$submission->paper_id]['discountType']))
                {
                    $discounts = $payables[$submission->member_id][$submission->paper_id]['discountType'];
                    foreach($discounts as $discount)
                    {
                    ?>
                        <td class="discount_type">
                            <?php echo $discount->discount_type_name; ?>
                        </td>
                        <td class="discount_amount">
                            <?php echo $discountAmt = $discount->discount_type_amount * $brpayableActual; ?>
                        </td>
                    <?php
                    }
                }
                else if(isset($payables[$submission->member_id][$submission->paper_id]['paid']))
                {
                    ?>
                    <td class="discount_type">
                        0
                    </td>
                    <td class="discount_amount">
                        0
                    </td>
                    <?php
                }
                else
                {
                ?>
                    <td class="discount_type"></td>
                    <td class="discount_amount"></td>
                <?php
                }
                ?>
                <td class="pending">
                    <?php
                    if(isset($payables[$submission->member_id][$submission->paper_id]['paid']))
                    {
                        echo ($brpayable + $eppayable + $olpcpayable + $prpayable) - ($paidAmt);
                    }
                    ?>
                </td>
            </tr>
        <?php
        }
        ?>
        </tbody>
    </table>
</div>