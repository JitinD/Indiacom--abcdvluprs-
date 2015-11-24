<div class="row contentBlock-top">
    <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
        <?php include(__DIR__ . "/../static/importantdatesPanel.php"); ?>
    </div>
    <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12">
        <span class="h1 text-theme">News</span>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <?php foreach ($results as $data) { ?>
                    <a href="viewNews/<?php echo $data->news_id; ?>">
                        <span class="h3">
                            <?php echo $data->news_title ?>
                        </span>

                        <p class="text-justify">
                            <?php echo $data->news_content; ?>
                        </p>

                        <p>
                            <?php
                            $date = new DateTime($data->news_publish_date);
                            echo $date->format('d-m-Y');
                            ?>
                        </p>
                    </a>
                    <hr>
                <?php
                }
                ?>

            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('tr').on("click", function () {
            if ($(this).attr('href') !== undefined) {
                document.location = $(this).attr('href');
            }
        });
    });
</script>