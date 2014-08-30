<div class="container-fluid contentBlock-top">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <hr>
                <h2>
                    Welcome, <span class="abcdvluprs"><?php echo $_SESSION['user_name']; ?></span>
                </h2>
            <hr>
            <div class="row">
                <?php
                if(in_array("Role Manager", $loadableComponents))
                {
                ?>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 text-center">
                    <a href="/<?php echo BASEURL; ?>index.php/RoleManager/load" class="thumbnail">
                        <div class="panel text-muted">
                            <h3>
                                Role Manager
                            </h3>
                        </div>
                    </a>
                </div>
                <?php
                }
                ?>
                <?php
                if(in_array("User Manager", $loadableComponents))
                {
                ?>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 text-center">
                    <a href="/<?php echo BASEURL; ?>index.php/UserManager/load" class="thumbnail">
                        <div class="panel text-muted">
                            <h3>
                                User Manager
                            </h3>
                        </div>
                    </a>
                </div>
                <?php
                }
                ?>
                <?php
                if(in_array("Initial Paper Reviewer", $loadableComponents))
                {
                    ?>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 text-center">
                        <a href="/<?php echo BASEURL; ?>index.php/InitialPaperReviewer" class="thumbnail">
                            <div class="panel text-muted">
                                <h3>
                                    Intitial Paper Reviewer
                                </h3>
                            </div>
                        </a>
                    </div>
                <?php
                }
                ?>
                <?php
                if(in_array("Final Paper Reviewer", $loadableComponents))
                {
                    ?>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 text-center">
                        <a href="/<?php echo BASEURL; ?>index.php/FinalPaperReviewer" class="thumbnail">
                            <div class="panel text-muted">
                                <h3>
                                    Final Paper Reviewer
                                </h3>
                            </div>
                        </a>
                    </div>
                <?php
                }
                ?>
                <?php
                if(in_array("News Maker", $loadableComponents))
                {
                    ?>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 text-center">
                        <a href="/<?php echo BASEURL; ?>index.php/" class="thumbnail">
                            <div class="panel text-muted">
                                <h3>
                                    News Manager
                                </h3>
                            </div>
                        </a>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>