<?php
/**
 * Created by PhpStorm.
 * User: lavis_000
 * Date: 11/07/14
 * Time: 08:38
 */

function SetActiveNavItem($navItem, $page)
{
    if($page == $navItem)
        echo "active";
}
?>
<style type="text/css">
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
</style>

<div class="navbar-default navbar-fixed-top shadow-bottom" role="navigation" style="color: #ffffff">

    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" rel="home" href="#">BVICAM</a>
    </div>

    <div class="collapse navbar-collapse" id="navbar-collapse">
        <div class="col-md-8 col-sm-7">
            <ul class="nav navbar-nav">
                <li class="<?php SetActiveNavItem("Home", $page); ?>"><a href="index">Home</a></li>
                <li class="dropdown <?php SetActiveNavItem("About INDIACom", $page); ?>">
                    <a href="#" class="dropdown-toggle text-light" data-toggle="dropdown">About INDIACom<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="aboutIndiacom">About Indiacom</a></li>
                        <li class="divider"></li>
                        <li><a href="#">INDIACom History</a></li>
                        <li><a href="#">Invited Speaker</a></li>
                        <li><a href="#">Sponsors</a></li>
                        <li><a href="#">Conference Secratariate</a></li>
                        <li><a href="#">Committees</a></li>
                        <li><a href="#">Review Process, Publication and Indexing</a></li>
                    </ul>
                </li>

                <li class="dropdown <?php SetActiveNavItem("Submit Paper", $page); ?>">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Submit Paper<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Submit Paper</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Paper Submission Guidelines</a></li>

                        <li><a href="#">Paper Formatting Guidelines</a></li>
                        <li><a href="#">Payment Modes</a></li>
                    </ul>
                </li>
                <li class="<?php SetActiveNavItem("News", $page); ?>"><a href="#">News</a></li>
                <li class="dropdown <?php SetActiveNavItem("Downloads", $page); ?>">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Downloads <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Downloads</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Proceedings</a></li>
                    </ul>
                </li>
                <li class="<?php SetActiveNavItem("FAQs", $page); ?>"><a href="#">FAQs</a></li>
                <li class="<?php SetActiveNavItem("Contact Us", $page); ?>"><a href="#">Contact Us</a></li>
                <li class="<?php SetActiveNavItem("Feedback", $page); ?>"><a href="#">Feedback</a></li>
            </ul>
        </div>
        <div class="col-md-2 col-sm-3 pull-right">
            <ul class="nav navbar-nav">
                <li><button class="btn btn-default navbar-btn btn-success" data-toggle="modal" data-target="#loginModal">Login</button></li>
                <li></li>
            </ul>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Login</h4>
            </div>
            <div class="modal-body">
                <?php include(dirname(__FILE__) . "/../pages/loginPage.php"); ?>
            </div>
        </div>
    </div>
</div>

