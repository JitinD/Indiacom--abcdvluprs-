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
        Text Size &raquo;
        <div class="btn-group" role="group" aria-label="...">

            <button id="font_inc" class="btn btn-sm btn-default"><span
                    class="glyphicon glyphicon-plus"></span></button>
            <button id="font_dec" class="btn btn-sm btn-default"><span
                    class="glyphicon glyphicon-minus"></span></button>
        </div>
        <?php
        if(file_exists(SERVER_ROOT.BASEURL.'reports/report.csv'))
        {
            ?>
            <div class="col-sm-4">
                <a title="Click to download" class="btn btn-primary btn-block" href="<?php echo base_url() ?>ReportManager/downloadReport" target="_blank" >Download <span class="glyphicon glyphicon-cloud-download"></span> </a>
            </div>
        <?php
        }
        ?>
        <hr>
        <table id="report_table" class="table table-responsive table-hover table-condensed">
            <thead>
            <?php if ($fields == null) {
                echo "No results found";
            }
            else if($fields==1)
            {
                echo "Invalid query";
            }
            else{
                foreach ($fields as $field) {
                    ?>
                    <th class="sort btn-link text-uppercase"
                        data-sort="<?php echo $field; ?>"><?php echo $field; ?></th>
                <?php
                }
            }
            ?>
            </thead>
            <tbody class="list">
            <?php
            if ($results == null) {
                echo "No results found";
            }
            else if($results==1)
            {
                echo " ";
            }
            else
             {
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
    var transList = new List('trans-list', options);
    $(document).ready(function () {
        var size_str = $("#report_table").css("font-size");
        var size_int = parseInt(size_str.substr(0,2));
        $("#font_inc").click(function () {
            size_int+=2;
            $("#report_table").css("font-size", size_int+"px");
        });
        $("#font_dec").click(function () {
            size_int-=1;
            $("#report_table").css("font-size", size_int+"px");
        });
    });
</script>