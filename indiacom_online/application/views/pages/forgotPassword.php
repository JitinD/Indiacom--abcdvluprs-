<div class="row contentBlock-top">
    <div class="col-lg-9 col-lg-offset-2 col-md-8 col-md-offset-3 col-sm-8 col-sm-offset-3 col-xs-12 col-xs-offset-0">
        <span class="h1 text-theme">Forgot Password</span>
        <hr>
        <div class="row body-text">
            <div class="col-md-8">
                <span class="help-block">
                    To reset your password, enter the <kbd>Member ID</kbd> you received at time of registration and your registered <kbd>Email Address</kbd>.
                </span>
                <br>
                <form class="form-horizontal" role="form" method = "post">

                    <div class="form-group">
                        <label for="memberID" class="col-sm-4 control-label">Member ID</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name = "memberID" id="memberID" value="<?php echo set_value('memberID'); ?>" placeholder="Enter Member ID" autofocus>
                        </div>
                        <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                            <?php echo form_error('memberID'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="col-sm-4 control-label">Email</label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" name = "email" id="email" value="<?php echo set_value('email'); ?>" placeholder="Enter your registered Email address">
                        </div>
                        <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                            <?php echo form_error('email'); ?>
                        </div>
                    </div>

                        <?php
                            if(isset($error))
                                echo $error;
                        ?>

                        <?php
                            if(isset($email_id))
                            {
                         ?>

                            <br/>Your registered email id is of form :

                        <?php   echo $email_id; }?>


                        <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                            <?php echo form_error('contactno'); ?>
                        </div>
                    </div>

                    <span class="help-block">You will receive a One-Time password in your email. Use that password to login and immediately change your password.</span>

                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-3">
                            <button type="submit" name = "Reset" value = "Reset" class="btn btn-primary btn-block">Reset Password</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>