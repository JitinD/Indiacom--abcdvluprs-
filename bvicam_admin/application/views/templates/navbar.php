<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="col-md-8 col-sm-8 col-xs-8">
            <a data-toggle="modal" data-target="#myModal">
                <img src="/<?php echo PATH ?>assets/images/bvicamlogo.png" class="btn btn-lg" style="height: 60px; ;">
            </a>
            <span class="btn">BVICAM Admin System</span>
        </div>
        <div class="nav navbar-nav navbar-right">
            <?php
            if (isset($_SESSION) && isset($_SESSION[APPID]['authenticated'])) {
                ?>
                <a href="/<?php echo BASEURL; ?>index.php/Page/login" type="submit" class="btn btn-primary navbar-btn">
                    Change Role
                </a>
                <a href="/<?php echo BASEURL; ?>index.php/Page/logout" type="submit" class="btn btn-danger navbar-btn">
                    <span class="glyphicon glyphicon-user"></span> Logout
                </a>
            <?php
            }
            ?>
        </div>
    </div>
</div>
