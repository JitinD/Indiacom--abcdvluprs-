<?php include(dirname(__FILE__) . "/../../config/links.php"); ?>
<div class="navbar navbar-default navbar-fixed-top" role="navigation" style="border-bottom: solid #c0c0c0 1px;">
    <div class="container-fluid">
        <div class="col-md-1 col-sm-1 col-xs-2">
            <button type="button" class="btn btn-default navbar-btn" id="show_myNavmenu">
                <img src="/<?php echo PATH ?>assets/images/hamburger-menu.png" style="height: 20px; ;">
            </button>

        </div>
        <div class="col-md-7 col-sm-7 col-xs-10">
            <span class="navbar-brand">BVICAM Admin System</span>
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
<nav id="myNavmenu" class="navmenu navmenu-default navmenu-fixed-left" style="display: none;" role="navigation">

    <span class="navmenu-brand" href="#"><a href="#"><?php echo $controllerName; ?></a></span>

    <ul class="nav navmenu-nav">
        <?php
        if (isset($links)) {
            foreach ($links as $link => $linkName) {
                ?>
                <li>
                    <a href="/<?php echo BASEURL . "index.php/" . $controllerName . "/" . $link; ?>"><?php echo $linkName; ?></a>
                </li>
            <?php
            }
        }
        ?>
    </ul>
    <hr>
    <ul class="nav">
        <?php
        foreach ($loadableComponents as $component) {
            ?>
            <li>
                <a href="/<?php echo BASEURL . "index.php/" . $ControllerDefaultLink[$component]; ?>">
                    <?php echo $component; ?>
                </a>
            </li>
        <?php
        }
        ?>
    </ul>
</nav>

<script>
    $(document).ready(function () {
        var speed = 100;
        $("#show_myNavmenu").click(function () {
            //$("#myNavmenu").removeClass("offcanvas");
            $("#myNavmenu").show(speed);
        });
        $("#hide_myNavmenu").click(function () {
            //$("#myNavmenu").addClass("offcanvas");
            $("#myNavmenu").hide(speed);
        });
        $("#contentPanel").click(function () {
            $("#myNavmenu").hide(speed);
        });

        $(document).keyup(function (e) {

            if (e.keyCode == 27) {
                $("#myNavmenu").hide(speed);
            }
        });
    });
</script>