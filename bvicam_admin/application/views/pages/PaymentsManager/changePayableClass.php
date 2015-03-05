<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 3/5/15
 * Time: 3:23 PM
 */
?>

<div class="col-sm-12 col-md-12" id="contentPanel">
    <h1 class="page-header">Change Payable Class</h1>
    <?php
    if (isset($message)) {
    ?>
        <div class="alert alert-success text-center">
            <?php
            foreach ($message as $msg) {
                echo "<div>$msg</div>";
            }
            ?>
        </div>
    <?php
    }
    ?>
    <div class="row">
        <table class="table table-bordered table-responsive">
            <?php
            foreach($payableClasses as $payheadId => $payheadPayableClasses)
            {
            ?>
                <tr>
                    <td>
                        <?php echo $paymentHeads[$payheadId]->payment_head_name; ?>
                    </td>
                    <td>
                        <table class="table-bordered table">
                            <tr>
                                <td rowspan="2">Category of Delegates/Authors</td>
                                <?php
                                $noofDateGroups = 0;
                                $tableDateGroups = array();
                                foreach($dateGroups[$payheadId] as $dateGroup)
                                {
                                    $tableDateGroups[$noofDateGroups++] = $dateGroup->dates;
                                    ?>
                                    <td colspan="2"><?php echo $dateGroup->dates; ?></td>
                                <?php
                                }
                                ?>
                            </tr>
                            <tr>
                                <?php
                                for($i=0; $i<$noofDateGroups; $i++)
                                {
                                    ?>
                                    <td>IEEE/IET/CSI/IETE/IE(I)/ISTE Members</td>
                                    <td>General</td>
                                <?php
                                }
                                ?>
                            </tr>
                            <?php
                            foreach($payheadPayableClasses as $nationality => $nationalityPayableClass)
                            {
                                if($nationality != null)
                                {
                                    ?>
                                    <tr>
                                        <td colspan="20" style="text-align: center;"><?php echo $nationalities[$nationality]->Nationality_type; ?></td>
                                    </tr>
                                <?php
                                }
                                foreach($nationalityPayableClass as $regCat => $regCatPayableClass)
                                {
                                    ?>
                                    <tr>
                                        <td>
                                            <?php
                                            if($regCat == null)
                                                echo "All Categories";
                                            else
                                                echo $memCats[$regCat]['member_category_name'];
                                            ?>
                                        </td>
                                        <?php
                                        foreach($tableDateGroups as $date)
                                        {
                                            $amount = array();
                                            for($i=0; $i<2; $i++)
                                            {
                                                if(isset($regCatPayableClass[$date][$i]))
                                                {
                                                    $amount[$i] = $regCatPayableClass[$date][$i]["amount"];
                                                    $id[$i] = $regCatPayableClass[$date][$i]["id"];
                                                }
                                                else
                                                {
                                                    $amount[$i] = $regCatPayableClass[$date][null]["amount"];
                                                    $id[$i] = $regCatPayableClass[$date][null]["id"];

                                                }
                                            }
                                            ?>
                                            <td data-payableClassId="<?php echo $id[0]; ?>" class="payableClass <?php if($id[0] == $payableClassId) echo "bg-info"; ?>">
                                                <?php echo $amount[0]; ?>
                                            </td>
                                            <td data-payableClassId="<?php echo $id[1]; ?>" class="payableClass <?php if($id[1] == $payableClassId) echo "bg-info"; ?>">
                                                <?php echo $amount[1]; ?>
                                            </td>
                                            <?php
                                        }
                                        ?>
                                    </tr>
                                <?php
                                }
                            }
                            ?>
                        </table>
                    </td>
                </tr>
            <?php
            }
            ?>
        </table>
        <form method="post">
            <input type="hidden" name="payableClass" id="payableClass">
            <input type="submit">
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(".payableClass").click(function() {
            $(".payableClass").removeClass("bg-info");
            $(this).addClass("bg-info");
            $("#payableClass").val($(this).attr("data-payableClassId"));
        });
    });
</script>