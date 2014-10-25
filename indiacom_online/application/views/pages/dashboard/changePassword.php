<div class="container-fluid">
    <div class="row body-text">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h3>Change Password</h3>
            <form class="form-horizontal" role="form" method="post">
                <?php
                    if(!$toResetPassword)
                    {

                 ?>

                <div class="form-group">
                    <label for="currentPassword" class="col-sm-4 control-label">Current Password</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" name="currentPassword" id="inputPassword3" placeholder="Enter Current Password" autofocus>
                        <?php echo form_error('currentPassword'); ?>
                    </div>
                </div>

                <?php
                    }
                ?>

                <div class="form-group">
                    <label for="newPassword" class="col-sm-4 control-label">New Password</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" name="newPassword" id="newPassword" placeholder="Enter New Password">
                        <?php echo form_error('newPassword'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="newPassword2" class="col-sm-4 control-label">Confirm New Password</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" name="confirmPassword" id="newPassword2" placeholder="Re-enter New Password">
                        <?php echo form_error('confirmPassword'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-3 col-sm-offset-3">
                        <button type="submit" class="btn btn-block btn-success">Change Password</button>
                    </div>
                    <div class="col-sm-3">
                        <button type="reset" class="btn btn-block btn-danger">Reset</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>