<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 2/14/15
 * Time: 10:18 PM
 */
?>
<div>
    <table>
        <thead>
        <tr>
            <th>Attendance on Desk</th>
            <th>Attendance on Track</th>
        </tr>
        </thead>
        <?php foreach ($attendance as $track) {
            ?>
            <tr>
            <?php if ($track->is_present_on_desk == 1) {
                ?>
                <td>
                    <?php echo "Present"; ?></td>
                <td><input type="submit" name="trackAttendance" value="Mark Attendance"/></td>
                <td><input type="text" name="certificate"></td>
                <td><input type="submit" name="trackCertificate" value="Mark Certificate"/></td>
                </tr>
            <?php
            } else {
                ?>
                <?php echo "Attendence on desk not marked";
            }
        }
        ?>

    </table>
</div>
