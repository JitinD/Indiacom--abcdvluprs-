<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 2/12/15
 * Time: 8:37 PM
 */
?>

<div class="col-sm-10 col-md-10">
    <h1 class="page-header">Track Manager</h1>

    <div class="row">
        <form method="post" class="form-horizontal" enctype="multipart/form-data">
            <?php foreach ($tracks as $track) {
                ?>
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <label>
                            <input type="radio" name="track" id="track" value="<?php echo $track->track_id; ?>">
                            <span class="h4"><?php echo $track->track_id . "." . " " . $track->track_name; ?></span>
                        </label>
                    </div>

                </div>
            <?php
            }
            ?>
            <div class="row">
                <div class="col-md-offset-3 col-md-3">
                    <input class="btn btn-primary btn-block" type="submit" name="submit" value="Choose Track"/>
                </div>
            </div>

        </form>
    </div>

</div>


