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
    <div id="trans-list" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <table class="table table-responsive table-hover">
            <thead>
            <?php if ($fields == null) {
                echo "No results found";
            } else {
                foreach ($fields as $field) {

                    ?>
                    <th class="sort btn-link" data-sort="<?php echo $field; ?>"><?php echo $field; ?></th>
                <?php
                }
            }?>
            </thead>

            <?php
            if ($results == null) {
                echo "No results found";
            } else {
                foreach ($results as $index => $record_array) {
                    ?>
                    <tr>
                    <?php
                    foreach ($fields as $index => $field) {
                        ?>
                        <td><?php echo $record_array[$field]; ?></td>
                    <?php
                    }
                }
                ?>
                </tr>
            <?php
            }
            ?>
        </table>

    </div>
</div>
<script>
    var options = {
        values: [
            <?php
            foreach ($fields as $field) {
                 echo $field;
                }
            ?>
        ]
    };
    var transList = new List('trans-list',options);
</script>