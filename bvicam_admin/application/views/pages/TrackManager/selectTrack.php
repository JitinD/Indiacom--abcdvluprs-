<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 2/12/15
 * Time: 8:37 PM
 */
?>
<div>
    <table>
        <?php foreach($tracks as $track)
        {
        ?>
            <tr>
               <input type="radio" name="track" value="<?php $track->track_id;?>" <td><?php echo $track->track_name; ?></td>
                <br>
            </tr>
        <?php
        }
        ?>
    </table>
    <a href="http://localhost/Indiacom2015/bvicam_admin/TrackManager/trackAttendance">Next</a>


</div>