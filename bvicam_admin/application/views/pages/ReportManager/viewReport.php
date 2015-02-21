<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 2/18/15
 * Time: 8:25 PM
 */
?>
<div class="row">
    <div id="trans-list" class="col-md-12">
        <h1 class="page-header">Report Generator</h1>
        <table class="table table-responsive table-hover table-condensed">
            <thead>
            <?php if ($fields == null) {
                echo "No results found";
            } else {
                foreach ($fields as $field) {
            ?>
                    <th class="sort btn-link" data-sort="<?php echo $field; ?>"><?php echo $field; ?></th>
            <?php
                }
            }
            ?>
            </thead>
            <tbody class="list">
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
                            <td class="<?php echo $field; ?>"><?php echo $record_array[$field]; ?></td>
                        <?php
                        }
                    }
                    ?>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>

    </div>
</div>
<script>
    var options = {
        valueNames: [
            <?php
            foreach ($fields as $field) {
                 echo "'$field',";
                }
            ?>
            ''
        ]
    };
    var transList = new List('trans-list',options);
</script>