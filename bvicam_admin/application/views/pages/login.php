<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-md-offset-3">
            <form class="form-signin" role="form" action="#" method="post">
                <h2 class="form-signin-heading">Please sign in</h2>
                <input type="email" name="emailId" class="form-control" placeholder="Email address" required autofocus>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
                <div>
                    <?php if(isset($loginError)) echo $loginError; ?>
                </div>
                <div class="row contentBlock-top">
                    <div class="col-md-6">
                        <button class="btn btn-success btn-block" type="submit">Sign in</button>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-danger btn-block" type="submit">Forgot Password</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>