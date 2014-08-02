<?php
/**
 * Created by PhpStorm.
 * User: Jitin
 * Date: 2/8/14
 * Time: 11:52 AM
 */
?>

<script src="/<?php echo PATH ?>assets/js/AJAX.js"></script>
<link rel="stylesheet" href="/<?php echo PATH ?>assets/css/AJAXstyle.css">

<div class="container-fluid">

    <div class="row">
        <div class="col-md-6 col-md-offset-2 col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
            <form class="form-horizontal" method = "post" action="#">
                <div class="form-group">
                    <label for="password" class="col-sm-3 control-label"><span class="glyphicon glyphicon-asterisk text-danger"></span> Password</label>
                    <div class="col-sm-9">
                        <input type="password" name = "password" class="form-control" id="password" placeholder="Enter strong password">
                    </div>
                    <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                        <?php echo form_error('password'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password2" class="col-sm-3 control-label"><span class="glyphicon glyphicon-asterisk text-danger"></span> Confirm Password</label>
                    <div class="col-sm-9">
                        <input type="password" name = "password2" class="form-control" id="password2" placeholder="Re-enter password">
                    </div>
                    <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                        <?php echo form_error('password2'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-6">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

</div>