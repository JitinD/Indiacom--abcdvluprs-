<div class="row contentBlock-top">
    <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
        <?php include(__DIR__ . "/../importantdatesPanel.php");?>
    </div>
    <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12">
        <span class="h1 text-theme">News</span>
        <hr>
        <div class="row text-center">
            <div class="col-md-1 col-sm-1 col-xs-1">
                <h4><span class="glyphicon glyphicon-chevron-left"></span></h4>
            </div>
            <div class="col-md-10 col-sm-10 col-xs-10">
                <span class="h2"><?php echo $basicDetails->news_title; ?></span>
            </div>
            <div class="col-md-1 col-sm-1 col-xs-1">
                <h4><span class="glyphicon glyphicon-chevron-right"></span></h4>
            </div>
        </div>
        <div class="h4">
            <span class="glyphicon glyphicon-calendar"></span>
            <?php
            $date = new DateTime($basicDetails->news_publish_date);
            echo $date->format('d-m-Y');
            ?>
        </div>
        <hr>
        <div class="row body-text">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <?php echo $basicDetails->news_content; ?>
            </div>
        </div>
        <div class="row col-md-3">
            <?php if(!empty($attachments)) echo "Attachments"; ?>
            <ul class="list-group">
                <?php
                foreach($attachments as $attachment)
                {
                    ?>
                    <li class="list-group-item">
                        <a href="/<?php echo $attachment->attachment_url; ?>"><?php echo $attachment->attachment_name; ?></a>
                    </li>
                <?php
                }
                ?>
            </ul>
        </div>
    </div>
</div>