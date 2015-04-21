<?php
/**
 * Created by PhpStorm.
 * User: Jitin
 * Date: 29/7/14
 * Time: 10:37 AM
 */
?>

<div class="container-fluid contentBlock-top">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <span class="h1 text-theme">Member Registration</span>
            <hr>
            <span class="alert alert-success">
            <?php
            if (isset($is_verified) && $is_verified)
                echo "Your Member Id is $member_id <br/>";
            echo $message;
            ?>
            </span>

        </div>
    </div>
</div>