<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 2/12/15
 * Time: 8:37 PM
 */
?>
<div style="padding-top: 100px;"></div>
<div>
    <form method="post" enctype="multipart/form-data">
        <table>
            <?php foreach ($tracks as $track) {
                ?>
                <tr>
                    <input type="radio" name="track" id="track" value="<?php echo $track->track_id; ?>"
                    <td><?php echo $track->track_id."."." ".$track->track_name; ?></td>
                    <br>
                </tr>
            <?php
            }
            ?>
        </table>
        <input type="submit" name="submit" value="Choose Track"/>
    </form>
</div>


