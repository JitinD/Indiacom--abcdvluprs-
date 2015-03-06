<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 3/6/15
 * Time: 8:20 PM
 */
?>

<div class="col-sm-12 col-md-12" id="contentPanel">
    <h1 class="page-header">Change Discount Type</h1>
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
        <form class="form-horizontal" method="post">
            <div class="form-group">
                <label class="col-sm-3" for="trans_memberId">Discount Type</label>
                <div class="col-sm-6">
                    <select name="discountType" class="form-control">
                        <option value="null" <?php if($discountType == null) echo "selected"; ?>>No Discount</option>
                        <?php
                        foreach($discounts as $discountId=>$discount)
                        {
                            if($discount->discount_type_payhead == $payheadId)
                            {
                            ?>
                                <option value="<?php echo $discountId; ?>" <?php if($discountType == $discountId) echo "selected"; ?>>
                                    <?php echo $discount->discount_type_name . " - " . $discount->discount_type_amount * 100 . "%"; ?>
                                </option>
                            <?php
                            }
                        }
                        ?>
                    </select>
                    <div class="bg-danger"><?php echo form_error('trans_memberId'); ?></div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-3">
                    <input type="submit" class="form-control">
                </div>
            </div>
        </form>
    </div>
</div>