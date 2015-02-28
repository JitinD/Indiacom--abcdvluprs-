<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 2/28/15
 * Time: 8:48 PM
 */
?>
<div class="col-sm-12 col-md-12 main">
    <h1 class="page-header">Track Manager </h1>

    <form id="searchByForm" class="form-horizontal" enctype="multipart/form-data" method="post">

        <div class="form-group">
            <label for="searchBy" class="col-sm-3 control-label"> Search by </label>

            <div class="col-sm-5">
                <?php
                $search_parameters = array("MemberID", "PaperID", "MemberName");
                ?>
                <div class="btn-group" data-toggle="buttons">
                    <?php
                    foreach ($search_parameters as $parameter) {
                        ?>
                        <label class="btn btn-primary
                        <?php
                        if (isset($parameter) && $parameter == "MemberID")
                            echo "active";
                        ?>"
                            >
                            <input type="radio" class="searchBy" name="searchBy" value="<?php echo $parameter; ?>"
                                <?php
                                if (isset($parameter) && $parameter == "MemberID")
                                    echo "checked";
                                ?>
                                >
                            <?php echo $parameter; ?>
                        </label>
                    <?php
                    }
                    ?>
                </div>

            </div>
        </div>

        <div class="form-group">
            <label for="searchValue" class="col-sm-3 control-label"><span class="glyphicon "></span> Search
                Value</label>

            <div class="col-sm-5">
                <input type="text" class="searchValue form-control" name="searchValue" maxlength="50"
                       value="<?php echo set_value('searchValue'); ?>" id="searchValue" placeholder="Enter value">
            </div>
            <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                <?php echo form_error('searchValue'); ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
                <button type="button" id="submitButton" class="btn btn-primary">Submit</button>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12 col-sm-12">
                <form method="post" enctype="multipart/form-data">
                    <table class="table table-responsive table-striped">
                        <?php if (isset($members)) {
                            ?>
                            <thead>
                            <tr>
                                <th>Select Member</th>
                                <th>Paper ID</th>
                                <th>Member ID</th>
                                <th>Member Name</th>
                                <th>Attendance on Track</th>
                                <th>Certificate Outward Number</th>
                                <th>Certificate Given</th>
                            </tr>
                            </thead>
                            <?php
                            if (empty($members)) {
                                ?>
                                <tr>
                                    <td colspan="8">No Accepted Papers!</td>
                                </tr>
                            <?php
                            } else {
                                foreach ($members as $member) {
                                    ?>
                                    <div class="radio">
                                        <label>
                                            <tr>
                                                <td><input type="radio" name="member_id" id="member_id"
                                                           value="<?php echo $member->submission_member_id ?>"></td>
                                                <td><?php echo $member->paper_code; ?></td>
                                                <td><?php echo $member->submission_member_id; ?></td>
                                                <td><?php echo $member->member_name; ?></td>
                                            </tr>

                                        </label>

                                    </div>
                                <?php
                                }
                            }?>
                            <div class="form-group">

                                <button type="submit" class="btn btn-primary">Submit</button>

                            </div>
                        <?php
                        }
                        else
                        {
                        ?>
                        <div class="Info">
                            <?php
                            if (!isset($paperId)) {
                                echo "<h1>Sorry no such paper Id in our database</h1>";
                            }
                            }
                            ?>

                    </table>

                </form>
            </div>
        </div>
    </form>
</div>
