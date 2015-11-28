<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 2/4/15
 * Time: 7:30 PM
 */
?>

<table class="table-bordered table">
    <tr>
        <td rowspan="2">Category of Delegates/Authors</td>
        <td colspan="2">Early Bird on or before 31st January, 2015</td>
        <td colspan="2">After 31st January, 2015</td>
        <td colspan="2">Spot Registration (only in Cash)</td>
    </tr>
    <tr>
        <?php
        for($i=0; $i<3; $i++)
        {
        ?>
            <td>IEEE/IET/CSI/IETE/IE(I)/ISTE Members</td>
            <td>General</td>
        <?php
        }
        ?>
    </tr>
    <?php
    foreach($payableClasses as $nationality=>$payableClass)
    {
    ?>
        <tr>
            <td colspan="7" style="text-align: center;">
                <?php
                echo $nationalities[$nationality]->Nationality_type . " Authors & Delegates (in " . $currencies[$nationalities[$nationality]->Nationality_currency]['currency_name'] . ")";
                ?>
            </td>
        </tr>
    <?php
        foreach($payableClass as $regCat=>$payable)
        {
        ?>
            <tr>
                <td><?php echo $memCats[$regCat]['member_category_name']; ?></td>
                <td><?php echo $payable["Early Bird"][0]->payable_class_amount; ?>.00</td>
                <td><?php echo $payable["Early Bird"][1]->payable_class_amount; ?>.00</td>
                <td><?php echo $payable["Late Bird"][0]->payable_class_amount; ?>.00</td>
                <td><?php echo $payable["Late Bird"][1]->payable_class_amount; ?>.00</td>
                <td><?php echo $payable["Spot"][0]->payable_class_amount; ?>.00</td>
                <td><?php echo $payable["Spot"][1]->payable_class_amount; ?>.00</td>
            </tr>
        <?php
        }
    }
    ?>
</table>