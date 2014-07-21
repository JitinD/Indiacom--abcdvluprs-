<!-- Modal -->
<div class="modal" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Login</h4>
            </div>
            <div class="modal-body">
                <!--?php include(dirname(__FILE__) . "/../pages/loginPage.php"); ?-->
                <div class="row">
                    <div class="col-md-9 formDiv">
                        <form role="form" class="form-horizontal" method="post" action="../../Login?redirect=<?php echo $_SERVER['REQUEST_URI']; ?>">
                            <div class="form-group">
                                <label for="memberID" class="col-sm-4 control-label h4">Member ID</label>
                                <div class="col-sm-8">
                                    <input type="text" name="username" class="form-control input-lg" id="memberID" placeholder="Enter Member ID">
                                </div>
                                <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                                    <?php echo $usernameError; ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-4 control-label h4">Password</label>
                                <div class="col-sm-8">
                                    <input type="password" name="password" class="form-control input-lg" id="password" placeholder="Enter Password">
                                </div>
                                <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                                    <?php echo $passwordError; ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-8 col-sm-offset-4">
                                    <button name="submit" value="1" type="submit" class="btn btn-success btn-lg btn-block">Submit</button>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-8 col-sm-offset-4">
                                    <button type="button" class="btn btn-danger btn-lg btn-block">Forgot Password</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if($isFormError):?>
    <script> $('#loginModal').modal('show'); </script>
<?php endif;?>