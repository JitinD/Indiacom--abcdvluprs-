<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 8/2/14
 * Time: 12:06 AM
 */
?>
<div class="row main">
    <div class="col-sm-2 col-md-2 main" id="sidebar" style="">
        <div class="list-group well" style="position: fixed;height: 100%;">
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
    <div style="position: fixed;  z-index: 100; margin: auto 0px;">
        <button type="button" class="btn btn-sm" style="margin-left: -12px; padding-right: 2px;" id="hideSidePanel" data-state="1">
            <span class="glyphicon glyphicon-chevron-right" id="show"></span>
            <span class="glyphicon glyphicon-chevron-left" id="hide"></span>
        </button>
    </div>
    <script>
        $(document).ready(function (){
            var speed=300;
            var speedfast=0;
            $('#hideSidePanel #hide').show();
            $('#hideSidePanel #show').hide();
            $('#hideSidePanel').click(function()
            {
                if($(this).attr("data-state") == 1)
                {
                    $('#sidebar').hide(speedfast,"linear");
                    $("#show", this).show(speedfast,"linear");
                    $("#hide", this).hide(speedfast,"linear");
                    $('#contentPanel').attr("class", "col-sm-12 col-md-12");
                    $(this).attr("data-state", 0);
                }
                else
                {
                    $("#sidebar").show(speed);
                    $("#show", this).hide(speed);
                    $("#hide", this).show(speed);
                    $('#contentPanel').attr("class", "col-sm-10 col-md-10");
                    $(this).attr("data-state", 1);
                }
            });
        });
    </script>