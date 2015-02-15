<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 2/14/15
 * Time: 10:18 PM
 */
?>
<div>
    <form method="post" enctype="multipart/form-data">
        <table>
            <thead>
            <tr>
                <th>Attendance on Desk</th>
                <th>Attendance on Track</th>
            </tr>
            </thead>
            <?php foreach ($attendance as $track) {
                ?>

                <?php if ($track->is_present_on_desk == 1) {
                    ?>
                    <tr>
                        <td>
                            <?php echo "Present"; ?></td>
                        <td><input type="submit" name="trackAttendance" value="Mark Attendance"/></td>
                        <td><input type="text" name="certificate"></td>
                        <td><input type="submit" name="trackCertificate" value="Mark Certificate"/></td>
                    </tr>
                <?php
                }

            }?>

        </table>
    </form>
</div>
