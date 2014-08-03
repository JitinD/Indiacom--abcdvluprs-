<div class="row contentBlock-top">
    <div class="col-lg-10 col-lg-offset-2 col-md-9 col-md-offset-3 col-sm-8 col-sm-offset-3 col-xs-12 col-xs-offset-0">
        <span class="h1 text-theme">Forgot Password</span>
        <hr>
        <div class="row body-text">
            <div class="col-md-11">
                <span class="help-block">
                    To reset your password, enter the <kbd>Member ID</kbd> you received at time of registration and your registered <kbd>Email Address</kbd>.
                </span>
                <span class="help-block">You will receive a reset link in your email. Use that password to login and immediately change your password.</span>
                <div class="contentBlock-top">
                <form class="form-horizontal" role="form" method = "post">
                    <fieldset>
                    <div class="form-group">
                        <label for="memberID" class="col-sm-2 control-label">Member ID</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name = "memberID" id="memberID" value="<?php echo set_value('memberID'); ?>" placeholder="Enter Member ID" autofocus>
                        </div>
                        <div class="col-sm-6 col-sm-offset-2 text-danger h5" id="errorText">
                            <?php echo form_error('memberID'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-6">
                            <input type="email" class="form-control" name = "email" id="email" value="<?php echo set_value('email'); ?>" placeholder="Enter your registered Email address">
                        </div>
                        <div class="col-sm-6 col-sm-offset-2 text-danger h5" id="errorText">
                            <?php echo form_error('email'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-6 col-sm-offset-2">
                        <span class="body-text text-danger">
                            <?php
                            if(isset($error))
                                echo $error;
                            ?>

                            <?php
                            if(isset($email_id))
                            {
                                ?>

                                Your registered email id is of form :

                                <?php   echo $email_id; }?>
                        </span>
                        </div>

                    </div>



                        <!--<div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                            <?php /*echo form_error('contactno'); */?>
                        </div>-->


                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-4">
                            <button type="submit" name = "Reset" value = "Reset" class="btn btn-primary btn-block">Reset Password</button>
                        </div>
                    </div>
                    </fieldset>
                </form>
                 </div>
            </div>
        </div>
    </div>
</div>