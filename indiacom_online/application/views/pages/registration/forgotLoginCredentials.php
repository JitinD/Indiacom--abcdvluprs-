<?php
/**
 * Created by PhpStorm.
 * User: saura_000
 * Date: 10/15/15
 * Time: 1:07 PM
 */
?>

<div class="container-fluid">
    <div class="row contentBlock-top">
        <div class="col-lg-10 col-lg-offset-2 col-md-9 col-md-offset-3 col-sm-8 col-sm-offset-3 col-xs-12 col-xs-offset-0">
            <?php
            if(!isset($usedForgotPassword))
            {
            ?>
                <span class="h1 text-theme">Forgot Member Id ?</span>
                <hr>
                <div class="row body-text">
                    <div class="col-md-11">
                        <span class="help-block">
                            Enter the <kbd>Email Address</kbd> with which you registered on the site.
                        </span>
                        <span class="help-block">
                            Your <kbd>Member Id</kbd> will be shown if the provided Email Address is found in our database.
                        </span>
                        <div class="contentBlock-top">
                            <form class="form-horizontal" role="form" method="post">
                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Email</label>
                                        <div class="col-sm-6">
                                            <input type="email" name="email" class="form-control" placeholder="Enter your registered Email Address">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-6 col-sm-offset-2">
                                            <?php
                                            if(isset($forgottenMemberId))
                                            {
                                            ?>
                                                <span class="body-text text-info">
                                                    Your member id is <?php echo $forgottenMemberId; ?>
                                                </span>
                                            <?php
                                            }
                                            if(isset($forgotMemberId_errorMessage))
                                            {
                                            ?>
                                                <span class="body-text text-danger">
                                                    <?php echo $forgotMemberId_errorMessage; ?>
                                                </span>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-4">
                                            <button type="submit" name="form_getMemberId" class="btn btn-primary btn-block">Get Member Id</button>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>

            <?php
            if(!isset($usedForgotMemberId))
            {
            ?>
                <span class="h1 text-theme">Forgot Password ?</span>
                <hr>
                <div class="row body-text">
                    <div class="col-md-11">
                        <span class="help-block">
                            Enter the <kbd>Email Address</kbd> with which you registered on the site to reset your password.
                        </span>
                        <span class="help-block">
                            You will receive a <kbd>Reset Link</kbd> on the Email Address you provided.
                        </span>
                        <div class="contentBlock-top">
                            <form class="form-horizontal" role="form" method="post">
                                <fieldset>
                                    <div class="form-group" id="emailAddress">
                                        <label class="col-sm-2 control-label">Email</label>
                                        <div class="col-sm-6">
                                            <input type="email" name="email" class="form-control" placeholder="Enter your registered Email Address">
                                            <?php
                                            if(!isset($memberEmail))
                                            {
                                            ?>
                                                <span class="help-block">
                                                    <button type="button" class="btn btn-link btn-md" id="btn_showEmail">Don't remember your registered Email Address? </button>
                                                </span>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group" id="emailHint" style="display: none;">
                                        <label class="col-sm-2 control-label">Member Id</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="memberId" class="form-control" placeholder="Enter your Member Id">
                                            <span class="help-block">
                                                Enter your Member Id here. We will show you a part of the Email Address associated with the provided Member Id. We hope that will help you recall your registered Email Address.
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-6 col-sm-offset-2">
                                            <?php
                                            if(isset($forgotPwd_errorMessage))
                                            {
                                            ?>
                                                <span class="body-text text-danger">
                                                    <?php echo $forgotPwd_errorMessage; ?>
                                                </span>
                                            <?php
                                            }
                                            if(isset($forgotPwd_message))
                                            {
                                            ?>
                                                <span class="body-text text-info">
                                                    <?php echo $forgotPwd_message; ?>
                                                </span>
                                            <?php
                                            }
                                            if(isset($memberEmail))
                                            {
                                            ?>
                                                <span class="body-text text-info">
                                                    Email Hint: <?php echo $memberEmail; ?>
                                                </span>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-4">
                                            <button type="submit" name="form_forgotPassword" id="btn_forgotPassword" class="btn btn-primary btn-block">Get Password Reset Link</button>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function()
    {
        $("#btn_showEmail").click(function()
        {
            $("#emailHint").show();
            $(this).hide();
            $("#emailAddress").hide();
            $("#btn_forgotPassword").text("Get Email Hint");
        })
    })
</script>