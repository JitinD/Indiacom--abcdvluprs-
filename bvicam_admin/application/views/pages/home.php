<?php include(dirname(__FILE__) . "/../../config/links.php"); ?>
<div class="container-fluid contentBlock-top">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h1 class="page-header">
                Welcome, <span class="text-capitalize"><?php echo $_SESSION[APPID]['user_name']; ?></span>!
            </h1>
            <div class="row">
                <?php
                foreach ($loadableComponents as $component) {
                    ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 text-center">
                        <a href="/<?php echo (isset($ControllerDefaultLink[$component])) ? BASEURL . "index.php/" . $ControllerDefaultLink[$component] : ""; ?>" class="thumbnail">
                            <h5>
                                <?php echo $component; ?>
                            </h5>
                        </a>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>