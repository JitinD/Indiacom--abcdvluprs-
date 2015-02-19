<?php
/**
 * Created by PhpStorm.
 * User: lavishlibra0810
 * Date: 19-02-2015
 * Time: 12:40 PM
 */
?>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div>
            <div class="modal-body">
                <?php
                foreach($loadableComponents as $component)
                {
                ?>
                    <div class="col-lg-4 col-md-3 col-sm-4 col-xs-12 text-center">
                        <a href="/<?php echo BASEURL; ?>index.php/RoleManager/load" class="thumbnail">
                            <div class="panel text-muted">
                                <h3>
                                    <?php echo $component; ?>
                                </h3>
                            </div>
                        </a>
                    </div>
                <?php
                }
                ?>
                <?php
/*                if (in_array("RoleManager", $loadableComponents)) {
                    */?><!--
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 text-center">
                        <a href="/<?php /*echo BASEURL; */?>index.php/RoleManager/load" class="thumbnail">
                            <div class="panel text-muted">
                                <h3>
                                    Role Manager
                                </h3>
                            </div>
                        </a>
                    </div>
                <?php
/*                }
                */?>
                <?php
/*                if (in_array("UserManager", $loadableComponents)) {
                    */?>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 text-center">
                        <a href="/<?php /*echo BASEURL; */?>index.php/UserManager/load" class="thumbnail">
                            <div class="panel text-muted">
                                <h3>
                                    User Manager
                                </h3>
                            </div>
                        </a>
                    </div>
                <?php
/*                }
                */?>
                <?php
/*                if (in_array("InitialPaperReviewer", $loadableComponents)) {
                    */?>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 text-center">
                        <a href="/<?php /*echo BASEURL; */?>index.php/InitialPaperReviewer" class="thumbnail">
                            <div class="panel text-muted">
                                <h3>
                                    Intitial Paper Reviewer
                                </h3>
                            </div>
                        </a>
                    </div>
                <?php
/*                }
                */?>
                <?php
/*                if (in_array("FinalPaperReviewer", $loadableComponents)) {
                    */?>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 text-center">
                        <a href="/<?php /*echo BASEURL; */?>index.php/FinalPaperReviewer" class="thumbnail">
                            <div class="panel text-muted">
                                <h3>
                                    Final Paper Reviewer
                                </h3>
                            </div>
                        </a>
                    </div>
                <?php
/*                }
                */?>
                <?php
/*                if (in_array("NewsManager", $loadableComponents) && in_array("NewsManager_IndiacomOnlineSystem", $loadableComponents)) {
                    */?>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 text-center">
                        <a href="/<?php /*echo BASEURL; */?>index.php/NewsManager/load" class="thumbnail">
                            <div class="panel text-muted">
                                <h3>
                                    News Manager
                                </h3>
                            </div>
                        </a>
                    </div>
                --><?php
/*                }
                */?>
            </div>
        </div>
    </div>
</div>