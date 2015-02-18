<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 2/18/15
 * Time: 8:25 PM
 */
?>
<div style="padding-top: 120px;"></div>
<div>
    <table>
        <thead>
        <?php if ($fields == null) {
            echo "No results found";
        } else {
            foreach ($fields as $field) {

                ?>
                <th><?php echo $field; ?></th>
            <?php
            }
        }?>
        </thead>
        <?php if ($results == null) {

        } else {
            foreach ($results as $result) {
                ?>
                <td><?php echo $result; ?></td>
            <?php
            }
        }?>
    </table>
</div>