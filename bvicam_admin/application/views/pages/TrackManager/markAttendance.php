<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 2/14/15
 * Time: 10:18 PM
 */
?>
<div style="padding-top: 120px;">
    <form method="post" enctype="multipart/form-data">
        <table class="table">
            <thead>
            <tr>
                <th>Paper Code</th>
                <th>Paper Title</th>
                <th>Attendance on Desk</th>
                <th>Attendance on Track</th>
                <th>Certificate Outward Number</th>
            </tr>
            </thead>
            <?php
            foreach ($papers as $paper) {
                ?>
                <tr>
                    <td><?php echo $paper->paper_code; ?></td>
                    <td><?php echo $paper->paper_title; ?></td>
                    <?php if (isset($attendance[$paper->paper_id]->is_present_on_desk) && $attendance[$paper->paper_id]->is_present_on_desk == 1) {
                        ?>
                        <td><?php echo "Present" ?></td>
                        <td><input type="submit" name="submit" value="Mark Attendance"/></td>
                    <?php
                    } else {
                        ?>
                        <td><?php echo "Absent On desk" ?></td>
                        <td><?php echo "Not marked" ?></td>
                    <?php
                    }
                    ?>
                    <td><input type="text" value="<?php if(isset($certificate[$paper->paper_id]->certificate_outward_number))
                        {
                            echo $certificate[$paper->paper_id]->certificate_outward_number;
                        }?>"> </td>
                    <td></td>
                </tr>

            <?php
            }
            ?>

        </table>
    </form>
</div>
<script>

</script>