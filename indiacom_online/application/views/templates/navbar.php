<?php
/**
 * Created by PhpStorm.
 * User: lavis_000
 * Date: 11/07/14
 * Time: 08:38
 */

function SetActiveNavItem($navItem, $page)
{
    if ($page == $navItem)
        echo "active";
}

?>
<div class="navbar-inverse visible-xs navbar-fixed-top" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/<?php echo BASEURL; ?>index">
            &nbsp;<span class="glyphicon glyphicon-home"></span>&nbsp;</a>
    </div>
    <div class="collapse navbar-collapse" id="navbar-collapse">
        <div class="col-md-10 col-sm-10">
            <ul class="nav navbar-nav">
                <li class="dropdown <?php SetActiveNavItem("About INDIACom", $navbarItem); ?>">
                    <a href="#" class="dropdown-toggle text-light" data-toggle="dropdown">About INDIACom<span
                            class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="/<?php echo BASEURL; ?>aboutIndiacom">INDIACom History</a></li>
                        <li><a href="/<?php echo BASEURL; ?>invitedSpeakers">Invited Speakers</a></li>
                        <li><a href="/<?php echo BASEURL; ?>sponsors">Sponsors</a></li>
                        <li><a href="/<?php echo BASEURL; ?>committees">Committees</a></li>
                        <li><a href="/<?php echo BASEURL; ?>reviewProcess">Review Process, Publication and Indexing</a>
                        </li>
                    </ul>
                </li>

                <li class="dropdown <?php SetActiveNavItem("Submit Paper", $navbarItem); ?>">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Submit Paper<span
                            class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <?php
                        if (isset($_SESSION) && isset($_SESSION[APPID]['member_id'])) {
                            ?>
                            <li><a href="/<?php echo BASEURL; ?>Dashboard/submitPaper">Submit Paper</a></li>
                            <li class="divider"></li>
                        <?php
                        }
                        ?>
                        <li><a href="/<?php echo BASEURL; ?>proceduralGuidelines">Paper Submission Guidelines</a></li>
                        <li><a href="#">Paper Formatting Guidelines</a></li>
                        <li><a href="/<?php echo BASEURL; ?>paymentModes">Payment Modes</a></li>
                    </ul>
                </li>
                <!--                <li class="-->
                <?php //SetActiveNavItem("News", $navbarItem); ?><!--"><a href="news">News</a></li>-->
                <li class="dropdown <?php SetActiveNavItem("Downloads", $navbarItem); ?>">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Downloads <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="/<?php echo BASEURL; ?>downloads">Downloads</a></li>
                        <li class="divider"></li>
                        <li><a href="/<?php echo BASEURL; ?>proceedings">Proceedings</a></li>
                    </ul>
                </li>
                <!--                <li class="-->
                <?php //SetActiveNavItem("FAQs", $navbarItem); ?><!--"><a href="#">FAQs</a></li>-->
                <li class="<?php SetActiveNavItem("Contact Us", $navbarItem); ?>"><a
                        href="/<?php echo BASEURL; ?>contactus">Contact Us</a></li>
                <!--                <li class="-->
                <?php //SetActiveNavItem("Feedback", $navbarItem); ?><!--"><a href="#">Feedback</a></li>-->
                <?php
                if (isset($_SESSION) && isset($_SESSION[APPID]['member_id'])) {
                    ?>
                    <li class="<?php SetActiveNavItem("Dashboard", $navbarItem); ?>"><a
                            href="/<?php echo BASEURL; ?>Dashboard/home">Dashboard</a></li>
                <?php
                }
                if (isset($_SESSION) && !isset($_SESSION[APPID]['member_id'])) {
                    ?>
                    <li><a href="/<?php echo BASEURL; ?>Registration/signup">Register</a></li>
                    <li>
                        <button class="btn navbar-btn btn-success" data-toggle="modal" data-target="#loginModal">Login
                        </button>
                    </li>
                <?php
                } else if (isset($_SESSION) && isset($_SESSION[APPID]['member_name'])) {
                    ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span
                                class="glyphicon glyphicon-user"></span> <?php echo $_SESSION[APPID]['member_name'] ?>
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="/<?php echo BASEURL; ?>Dashboard/editProfile">Edit Profile</a></li>
                            <li class="divider"></li>
                            <li><a href="/<?php echo BASEURL; ?>d/Login/logout" class="bg-danger">Logout</a></li>
                        </ul>
                    </li>
                <?php
                }
                ?>
                <!--<li>
                    <a>
                    <?php
                /*                    echo $_SESSION[APPID]['dbUserName'];
                                    */ ?>
                        </a>
                </li>-->
            </ul>
        </div>
    </div>
</div>
<div class="navbar-inverse hidden-xs" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/<?php echo BASEURL; ?>index">
            &nbsp;<span class="glyphicon glyphicon-home"></span>&nbsp;</a>
    </div>
    <div class="collapse navbar-collapse" id="navbar-collapse">
        <div class="col-md-11 col-sm-11">
            <ul class="nav navbar-nav">
                <li class="dropdown <?php SetActiveNavItem("About INDIACom", $navbarItem); ?>">
                    <a href="#" class="dropdown-toggle text-light" data-toggle="dropdown">About INDIACom<span
                            class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="/<?php echo BASEURL; ?>aboutIndiacom">INDIACom History</a></li>
                        <li><a href="/<?php echo BASEURL; ?>invitedSpeakers">Invited Speakers</a></li>
                        <li><a href="/<?php echo BASEURL; ?>sponsors">Sponsors</a></li>
                        <li><a href="/<?php echo BASEURL; ?>committees">Committees</a></li>
                        <li><a href="/<?php echo BASEURL; ?>reviewProcess">Review Process, Publication and Indexing</a>
                        </li>
                    </ul>
                </li>

                <li class="dropdown <?php SetActiveNavItem("Submit Paper", $navbarItem); ?>">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Submit Paper<span
                            class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <?php
                        if (isset($_SESSION) && isset($_SESSION[APPID]['member_id'])) {
                            ?>
                            <li><a href="/<?php echo BASEURL; ?>Dashboard/submitPaper">Submit Paper</a></li>
                            <li class="divider"></li>
                        <?php
                        }
                        ?>
                        <li><a href="/<?php echo BASEURL; ?>proceduralGuidelines">Paper Submission Guidelines</a></li>
                        <li><a href="/<?php echo BASEURL; ?>formattingGuidelines">Paper Formatting Guidelines</a></li>
                        <li><a href="/<?php echo BASEURL; ?>paymentModes">Payment Modes</a></li>
                    </ul>
                </li>
                <li class="dropdown <?php SetActiveNavItem("Downloads", $navbarItem); ?>">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Downloads <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="/<?php echo BASEURL; ?>downloads">Downloads</a></li>
                        <li class="divider"></li>
                        <li><a href="/<?php echo BASEURL; ?>proceedings">Proceedings</a></li>
                    </ul>
                </li>
                <!--                <li class="-->
                <?php //SetActiveNavItem("FAQs", $navbarItem); ?><!--"><a href="#">FAQs</a></li>-->
                <li class="<?php SetActiveNavItem("Contact Us", $navbarItem); ?>"><a
                        href="/<?php echo BASEURL; ?>contactus">Contact Us</a></li>
                <?php
                if (isset($_SESSION) && isset($_SESSION[APPID]['member_id'])) {
                    ?>
                    <li class="<?php SetActiveNavItem("Dashboard", $navbarItem); ?>"><a
                            href="/<?php echo BASEURL; ?>Dashboard/home">Dashboard</a></li>
                <?php
                }
                if (isset($_SESSION) && !isset($_SESSION[APPID]['member_id'])) {
                    ?>
                    <li><a href="/<?php echo BASEURL; ?>Registration/signup">Register</a></li>
                    <li>
                        <button class="btn navbar-btn btn-success" data-toggle="modal" data-target="#loginModal">Login
                        </button>
                    </li>
                <?php
                } else if (isset($_SESSION) && isset($_SESSION[APPID]['member_name'])) {
                    ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span
                                class="glyphicon glyphicon-user"></span> <?php echo $_SESSION[APPID]['member_name'] ?>
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="/<?php echo BASEURL; ?>Dashboard/editProfile">Edit Profile</a></li>
                            <li class="divider"></li>
                            <li><a href="/<?php echo BASEURL; ?>d/Login/logout" class="bg-danger">Logout</a></li>
                        </ul>
                    </li>
                <?php
                }
                ?>
                <!--<li>
                    <a>
                    <?php
                /*                    echo $_SESSION[APPID]['dbUserName'];
                                    */ ?>
                        </a>
                </li>-->
            </ul>
        </div>
    </div>
</div>