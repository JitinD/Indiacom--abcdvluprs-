<div class="container-fluid contentBlock-top">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <hr>
                <h2>
                    Welcome, <span class="abcdvluprs"><?php echo $_SESSION['user_name']; ?></span>
                </h2>
            <hr>
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 text-center">
                    <a href="/<?php echo BASEURL; ?>index.php/RoleManager/load" class="thumbnail">
                        <div class="panel text-muted">
                            <h3>
                                Role Manager
                            </h3>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 text-center">
                    <a href="/<?php echo BASEURL; ?>index.php/UserManager/load" class="thumbnail">
                        <div class="panel text-muted">
                            <h3>
                                User Manager
                            </h3>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>