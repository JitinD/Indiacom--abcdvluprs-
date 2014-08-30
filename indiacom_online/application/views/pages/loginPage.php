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
                        <form role="form" class="form-horizontal" method="post" action="/<?php echo INDIACOM; ?>d/Login?redirect=<?php echo $_SERVER['REQUEST_URI']; ?>">
                            <div class="form-group">
                                <label for="memberID" class="col-sm-4 control-label h4">Member ID</label>
                                <div class="col-sm-8">
                                    <input type="text" name="username" class="form-control" id="memberID" placeholder="Enter Member ID" autofocus>
                                </div>
                                <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                                    <?php echo $usernameError; ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-4 control-label h4">Password</label>
                                <div class="col-sm-8">
                                    <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password">
                                </div>
                                <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                                    <?php echo $passwordError; ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-8 col-sm-offset-4">
                                    <button name="submit" value="1" type="submit" class="btn btn-success btn-block">Submit</button>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-8 col-sm-offset-4">
                                    <a href="forgotPassword" class="btn btn-danger btn-block">Forgot Member Id / Password</a>

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