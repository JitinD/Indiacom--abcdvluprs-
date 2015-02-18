<?php
/**
 * Created by PhpStorm.
 * User: lavis_000
 * Date: 07/07/14
 * Time: 11:34
 */
?>
<style type="text/css">
    .footer {
        font-size: 14px;
        padding-top: 10px;
        padding-bottom: 10px;
    }

    .abcdvluprs {
        font-family: Consolas
    }

</style>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div>
            <div class="modal-body">
                <?php
                for ($i = 0; $i < 10; $i++) {
                    ?>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 text-center">
                        <a href="#" class="thumbnail">
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

            </div>
        </div>
    </div>
</div>
</div>
<div class="container-fluid">
    <div class=" text-center text-muted footer row">
        <div class="col-md-12">
            <hr>
            | Developed By <a href="#">Software Consultancy and Development Cell</a>
            &copy <?php date_default_timezone_set('Asia/Kolkata');
            echo date('Y') ?> BVICAM | <a href="developers">Developers</a> |
        </div>
    </div>
</div>
</div>
</body>
</html>