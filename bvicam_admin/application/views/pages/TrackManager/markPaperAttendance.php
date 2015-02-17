<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 2/17/15
 * Time: 11:16 PM
 */
?>
<div style="padding-top: 120px;">
    <form method="post" enctype="multipart/form-data">
        <table class="table">
            <thead>
            <tr>
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
                <tr>
                    <input type="radio" name="member_id" id="member_id" value="<?php echo $member->submission_member_id ?>">
                    <td><?php echo $member->paper_code; ?></td>
                    <td><?php echo $member->submission_member_id; ?></td>
                    <td><?php echo $member->member_name; ?></td>
                </tr>
            <?php
            }
            ?>

        </table>
        <div class="form-group">

            <button type="submit" class="btn btn-primary">Submit</button>

        </div>
    </form>
</div>