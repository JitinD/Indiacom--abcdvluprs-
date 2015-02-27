<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="col-md-8 col-sm-8 col-xs-8">
            <button type="button" class="btn btn-default navbar-btn" data-toggle="offcanvas" data-target="#myNavmenu"
                    data-canvas="body">
                <span class="glyphicon glyphicon-chevron-left"></span>
            </button>
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
<nav id="myNavmenu" class="navmenu navmenu-inverse navmenu-fixed-left offcanvas" role="navigation">
    <ul class="nav navmenu-nav">
        <li class="active"><a href="#">Link</a></li>
        <li><a href="#">Link</a></li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
            <ul class="dropdown-menu navmenu-nav" role="menu">
                <li><a href="sidebar.php">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>
            </ul>
        </li>
    </ul>
</nav>