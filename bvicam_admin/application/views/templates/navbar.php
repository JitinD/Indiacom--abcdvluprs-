<!--<style type="text/css">
    .navbar .nav > li > a {
        padding: 10px 0px 10px;
    }
    .navbar-default {
        background-color: #004080;
        border-color: #48a4ff;
    }
    .navbar-default .navbar-brand {
        color: #cecece;
    }
    .navbar-default .navbar-brand:hover, .navbar-default .navbar-brand:focus {
        color: #ffffff;
    }
    .navbar-default .navbar-text {
        color: #cecece;
    }
    .navbar-default .navbar-nav > li > a {
        color: #cecece;
    }
    .navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus {
        color: #ffffff;
    }
    .navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > a:hover, .navbar-default .navbar-nav > .active > a:focus {
        color: #ffffff;
        background-color: #48a4ff;
    }
    .navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus {
        color: #ffffff;
        background-color: #48a4ff;
    }
    .navbar-default .navbar-toggle {
        border-color: #48a4ff;
    }
    .navbar-default .navbar-toggle:hover, .navbar-default .navbar-toggle:focus {
        background-color: #48a4ff;
    }
    .navbar-default .navbar-toggle .icon-bar {
        background-color: #cecece;
    }
    .navbar-default .navbar-collapse,
    .navbar-default .navbar-form {
        border-color: #cecece;
    }
    .navbar-default .navbar-link {
        color: #cecece;
    }
    .navbar-default .navbar-link:hover {
        color: #ffffff;
    }

    @media (max-width: 767px) {
        .navbar-default .navbar-nav .open .dropdown-menu > li > a {
            color: #cecece;
        }
        .navbar-default .navbar-nav .open .dropdown-menu > li > a:hover, .navbar-default .navbar-nav .open .dropdown-menu > li > a:focus {
            color: #ffffff;
        }
        .navbar-default .navbar-nav .open .dropdown-menu > .active > a, .navbar-default .navbar-nav .open .dropdown-menu > .active > a:hover, .navbar-default .navbar-nav .open .dropdown-menu > .active > a:focus {
            color: #ffffff;
            background-color: #48a4ff;
        }
    }

</style>-->
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="col-md-8 col-sm-8 col-xs-8">
            <a class="navbar-brand" href="/<?php echo BASEURL; ?>index.php/Page/index">BVICAM Admin System</a>
        </div>
        <div class="nav navbar-nav navbar-right">
            <?php
            if(isset($_SESSION) && isset($_SESSION[APPID]['authenticated']))
            {
            ?>
                <a href="/<?php echo BASEURL; ?>index.php/Page/login" type="submit" class="btn btn-sm navbar-btn">
                    Change Role
                </a>
                <a href="/<?php echo BASEURL; ?>index.php/Page/logout" type="submit" class="btn btn-sm navbar-btn">
                    <span class="glyphicon glyphicon-user"></span> Logout
                </a>
            <?php
            }
            ?>
        </div>
        <!--<div class="col-md-4 col-sm-4 col-xs-4">
            <ul class="nav navbar-nav">
                <?php
/*                if(isset($_SESSION) && isset($_SESSION[APPID]['authenticated']))
                {
                */?>
                <li>
                    <a href="/<?php /*echo BASEURL; */?>index.php/Page/logout" class="btn navbar-btn btn-danger">Logout</a>
                </li>
                <?php
/*                }
                */?>
            </ul>
        </div>
        <div class="col-xs-1 col-sm-1 navbar-right nav navbar-nav">
            <ul class="nav navbar-nav">
                <a href="/<?php /*echo BASEURL; */?>index.php/Page/login" class="btn btn-primary navbar-btn">Change Role</a>
            </ul>
        </div>
        <div class="col-sm-1 col-xs-1 nav navbar-nav">
            <ul class="nav navbar-nav">
                <li>
                    <a>
                        <?php
/*                        echo $_SESSION[APPID]['dbUserName'];
                        */?>
                    </a>
                </li>
            </ul>
        </div>-->
    </div>
</div>
