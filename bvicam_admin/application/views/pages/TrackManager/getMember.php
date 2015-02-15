<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 2/12/15
 * Time: 9:05 PM
 */
?>
<div>
    <form method="post" enctype="multipart/form-data">
        <label>Member id:
            <input type="text" name="member"></label>
        <input type="submit" name="submit" value="Get Selected Values"/>
    </form>
</div>
<?php
if (isset($_POST['submit'])) {
    ?>
    <div>
        <form method="post" enctype="multipart/form-data">
            <table>

                <?php if ($papers != null) {
                    foreach ($papers as $track) {
                        ?>
                        <tr>
                            <input type="radio" name="paper" id="paper" value="<?php echo $track->paper_id; ?>"
                            <td><?php echo $track->submission_member_id." ".$track->paper_id . " " . $track->paper_title; ?></td>
                            <br>

                        </tr>
                    <?php
                    }
                }
                ?>
            </table>
            <input type="submit" name="myPaper" value="Mark Attendance"/>
        </form>
    </div>
<?php
}
?>
