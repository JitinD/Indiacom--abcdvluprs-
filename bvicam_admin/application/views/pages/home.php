<?php include(dirname(__FILE__) . "/../../config/links.php"); ?>
<div class="container-fluid contentBlock-top">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h2>
                Welcome, <span class="abcdvluprs"><?php echo $_SESSION[APPID]['user_name']; ?></span>
            </h2>
            <hr>
            <div class="row">
                <?php
                foreach ($loadableComponents as $component) {
                    ?>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 text-center">
                        <a href="/<?php echo BASEURL . "index.php/" . $ControllerDefaultLink[$component]; ?>" class="thumbnail">
                            <h3>
                                <?php echo $component; ?>
                            </h3>
                        </a>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>