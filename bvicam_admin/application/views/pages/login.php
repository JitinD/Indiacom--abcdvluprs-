<div class="container-fluid">
    <div class="row" style="padding-top:50px;">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <center class="center-block">
                <img class="img-responsive" src="/<?php echo PATH ?>assets/images/bvicamlogo.png">
            </center>
            <p class="text-center h1">
                BVICAM Admin
            </p>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
                <div class="well text-center">
                    <form class="form-signin" role="form" action="#" method="post">
                        <h2 class="form-signin-heading">Please sign in</h2>
                        <input type="email" name="emailId" class="form-control input-lg" placeholder="Email address" required
                               autofocus>
                        <input type="password" name="password" class="form-control input-lg" placeholder="Password" required>

                        <div>
                            <?php if (isset($loginError)) echo $loginError; ?>
                        </div>
                        <div class="row contentBlock-top">
                            <div class="col-md-12">
                                <button class="btn btn-success btn-block" type="submit">Sign in</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-md-offset-3">

        </div>
    </div>
</div>