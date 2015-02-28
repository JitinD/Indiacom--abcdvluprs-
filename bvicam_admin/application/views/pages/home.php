<div class="container-fluid contentBlock-top">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h2>
                Welcome, <span class="abcdvluprs"><?php echo $_SESSION[APPID]['user_name']; ?></span>
            </h2>
            <hr>
            <div class="row">
                <?php
                if (in_array("RoleManager", $loadableComponents)) {
                    ?>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 text-center">
                        <a href="/<?php echo BASEURL; ?>index.php/RoleManager/load" class="thumbnail">
                            <h3>
                                Role Manager
                            </h3>
                        </a>
                    </div>
                <?php
                }
                ?>
                <?php
                if (in_array("UserManager", $loadableComponents)) {
                    ?>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 text-center">
                        <a href="/<?php echo BASEURL; ?>index.php/UserManager/load" class="thumbnail">
                                <h3>
                                    User Manager
                                </h3>
                        </a>
                    </div>
                <?php
                }
                ?>
                <?php
                if (in_array("InitialPaperReviewer", $loadableComponents)) {
                    ?>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 text-center">
                        <a href="/<?php echo BASEURL; ?>index.php/InitialPaperReviewer" class="thumbnail">
                                <h3>
                                    Intitial Paper Reviewer
                                </h3>

                        </a>
                    </div>
                <?php
                }
                ?>
                <?php
                if (in_array("FinalPaperReviewer", $loadableComponents)) {
                    ?>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 text-center">
                        <a href="/<?php echo BASEURL; ?>index.php/FinalPaperReviewer" class="thumbnail">

                                <h3>
                                    Final Paper Reviewer
                                </h3>

                        </a>
                    </div>
                <?php
                }
                ?>
                <?php
                if (in_array("NewsManager", $loadableComponents) && in_array("NewsManager_IndiacomOnlineSystem", $loadableComponents)) {
                    ?>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 text-center">
                        <a href="/<?php echo BASEURL; ?>index.php/NewsManager/load" class="thumbnail">

                                <h3>
                                    News Manager
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