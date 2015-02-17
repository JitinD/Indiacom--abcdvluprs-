<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 8/2/14
 * Time: 12:06 AM
 */
?>
<div class="row main">
    <div class="col-sm-2 col-md-2 main" id="sidebar">
        <div class="list-group" style="position: fixed;">
            <?php
            if(isset($links))
            {
                foreach($links as $link=>$linkName)
                {
            ?>
                    <a href="/<?php echo BASEURL . "index.php/" . $controllerName . "/" . $link; ?>" class="list-group-item"><?php echo $linkName; ?></a>
            <?php
                }
            }
            ?>
        </div>
    </div>
    <div style="position: fixed; z-index: 100; margin-top: 300px;">
        <button type="button" class="btn btn-sm" id="hideSidePanel" data-state="1">
            <span class="glyphicon glyphicon-chevron-right" id="show"></span>
            <span class="glyphicon glyphicon-chevron-left" id="hide"></span>
        </button>
    </div>
    <script>
        $(document).ready(function (){
            $('#hideSidePanel #hide').show();
            $('#hideSidePanel #show').hide();
            $('#hideSidePanel').click(function()
            {
                if($(this).attr("data-state") == 1)
                {
                    $('#sidebar').hide();
                    $("#show", this).show();
                    $("#hide", this).hide();
                    $('#contentPanel').attr("class", "col-sm-12 col-md-12");
                    $(this).attr("data-state", 0);
                }
                else
                {
                    $("#sidebar").show();
                    $("#show", this).hide();
                    $("#hide", this).show();
                    $('#contentPanel').attr("class", "col-sm-10 col-md-10");
                    $(this).attr("data-state", 1);
                }
            });
        });
    </script>