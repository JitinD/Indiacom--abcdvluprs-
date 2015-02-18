<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 2/12/15
 * Time: 9:05 PM
 */
?>
<!--<div style="padding-top: 100px;"></div>-->
<!--<div>-->
<!--    <form method="post" enctype="multipart/form-data">-->
<!--        <label>Member id:-->
<!--            <input type="text" name="member"></label>-->
<!--        <input type="submit" name="submit" value="Mark Attendance"/>-->
<!--    </form>-->
<!--</div>-->
<div class="col-sm-12 col-md-12 ">
    <h1 class="page-header">Track Manager</h1>

    <div class="row">
        <form class="form-horizontal" enctype="multipart/form-data" method="post">
            <div class="form-group">
                <label for="searchby" class="col-sm-3 control-label"><span class="glyphicon "></span> Search by</label>

                <div class="col-sm-6">
                    <?php
                    $search_parameters = array("MemberID", "PaperID");
                    ?>
                    <div class="btn-group" data-toggle="buttons">
                        <?php
                        foreach ($search_parameters as $parameter) {
                            ?>
                            <label class="btn btn-primary">
                                <input type="radio" name="searchby" value="<?php echo $parameter; ?>">
                                <?php echo $parameter ?>
                            </label>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="searchvalue" class="col-sm-3 control-label"><span class="glyphicon "></span> Search
                    Value</label>

                <div class="col-sm-4">
                    <input type="text" name="searchvalue" maxlength="50" class="form-control"
                           value="<?php echo set_value('searchvalue'); ?>" id="searchvalue"
                           placeholder="Enter value">
                </div>
                <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                    <?php echo form_error('searchvalue'); ?>
                </div>
            </div>

            <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                <?php echo form_error('searchby'); ?>
            </div>
    </div>
    <div class="row">
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-4">
                <button type="submit" class="btn btn-block btn-primary">Submit</button>
            </div>
        </div>
    </div>


    </form>
</div>

</div>
