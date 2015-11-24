<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 11/24/15
 * Time: 4:11 PM
 */

$payClass;
$dateTypes;
$dateTypeDates;
foreach($payableClasses as $payableClass)
{
    $date = "";
    if($payableClass->start_date != null && $payableClass->end_date != null)
        $date = "{$payableClass->start_date}_{$payableClass->end_date}";
    else if($payableClass->start_date == null && $payableClass->end_date != null)
        $date = "_{$payableClass->end_date}";
    else if($payableClass->start_date != null && $payableClass->end_date == null)
        $date = "{$payableClass->start_date}_";
    else if($payableClass->start_date == null && $payableClass->end_date == null)
        $date = "";
    $dateTypes[$payableClass->payable_class_payhead_id][$date] = $date;
    $payClass
        [$payableClass->payable_class_payhead_id]
        [$payableClass->payable_class_nationality]
        [$payableClass->payable_class_registration_category]
        [$date]
        [$payableClass->is_general] = array("amount" => $payableClass->payable_class_amount, "payable_class_id" => $payableClass->payable_class_id);
}
?>
<div class="col-sm-12 col-md-12" id="contentPanel">
    <h1 class="page-header"><?php echo $payheadDetails->payment_head_name; ?> Payable Classes for <?php echo $eventDetails->event_name; ?></h1>
    <div class="row">
        <form method="post">
            <input type="hidden" name="useless" value="useless">
            <table class="table table-bordered table-responsive">
                <tbody>
                <tr>
                    <td rowspan="2"><strong>Category of Delegates/Authors</strong></td>
                    <?php
                    foreach($dateTypes[$payheadDetails->payment_head_id] as $date)
                    {
                        $dates = explode("_", $date);
                    ?>
                        <td colspan="2">
                            <input type="date" class="form-control" name="date<?php echo "[{$dates[0]}_{$dates[1]}]"; ?>[start_date]" value="<?php echo $dates[0]; ?>"> to
                            <input type="date" class="form-control" name="date<?php echo "[{$dates[0]}_{$dates[1]}]"; ?>[end_date]" value="<?php echo $dates[1]; ?>">
                        </td>
                    <?php
                    }
                    ?>
                </tr>
                <tr>
                    <td class="text-primary"><strong>IEEE/IET/CSI/<br>IETE/IE(I)/ISTE Members</strong></td>
                    <td class="text-primary"><strong>General</strong></td>
                    <td class="text-primary"><strong>IEEE/IET/CSI/<br>IETE/IE(I)/ISTE Members</strong></td>
                    <td class="text-primary"><strong>General</strong></td>
                    <td class="text-primary"><strong>IEEE/IET/CSI/<br>IETE/IE(I)/ISTE Members</strong></td>
                    <td class="text-primary"><strong>General</strong></td>
                </tr>
                <?php
                foreach($nationalities as $nationality)
                {
                ?>
                    <tr>
                        <td colspan="7" align="center" class="text-danger"><strong><?php if($nationality->Nationality_type == "Indian") echo "Indian Authors & Delegates (in INR)"; else echo "Foreign Authors & Delegates (in USD $)"; ?></strong></td>
                    </tr>
                    <?php
                    foreach($memberCategories as $memberCategory)
                    {
                    ?>
                        <tr>
                            <td><strong><?php echo $memberCategory['member_category_name']; ?></strong></td>
                            <?php
                            foreach($dateTypes[$payheadDetails->payment_head_id] as $date)
                            {
                            ?>
                                <td>
                                    <?php
                                    $value = $payClass[$payheadDetails->payment_head_id][$nationality->Nationality_id][$memberCategory['member_category_id']][$date][0];
                                    ?>
                                    <input type="text" class="form-control" value="<?php echo $value["amount"]; ?>" name="amount[<?php echo $value['payable_class_id']; ?>]">
                                </td>
                                <td>
                                    <?php
                                    $value = $payClass[$payheadDetails->payment_head_id][$nationality->Nationality_id][$memberCategory['member_category_id']][$date][1];
                                    ?>
                                    <input type="text" class="form-control" value="<?php echo $value["amount"]; ?>" name="amount[<?php echo $value['payable_class_id']; ?>]">
                                </td>
                            <?php
                            }
                            ?>
                        </tr>
                    <?php
                    }
                }
                ?>
                <tr>
                    <td colspan="40"><button type="submit" class="form-control btn-success">Submit</button></td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>
</div>