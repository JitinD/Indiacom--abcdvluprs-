<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 2/17/15
 * Time: 11:16 PM
 */
?>
<div class="col-md-12 col-sm-12">
    <h1 class="page-header">Track Manager &raquo;<span class="h3">Select Member</span></h1>

    <div class="row">
        <div class="col-md-12 col-sm-12">
            <form method="post" enctype="multipart/form-data">
                <table class="table table-responsive table-striped">
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
                    <?php foreach ($members as $member) {
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
                    ?>

                </table>
                <div class="form-group">

                    <button type="submit" class="btn btn-primary">Submit</button>

                </div>
            </form>
        </div>
    </div>

</div>