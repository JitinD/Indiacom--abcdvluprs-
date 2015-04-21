<div class="row contentBlock-top">
    <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
        <?php include(__DIR__ . "/../static/importantdatesPanel.php");?>
    </div>
    <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12">
        <span class="h1 text-theme">News</span>
        <hr>
        <div class="row body-text">
            <div class="col-md-12">
                <table class="table table-hover table-striped table-condensed">
                    <thead>
                    <tr>
                        <th>News</th>
                        <th>Content</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($results as $data) { ?>
                        <tr style="cursor: pointer;" href="viewNews/<?php echo $data->news_id; ?>">
                            <td>
                                <?php echo $data->news_title ?>
                            </td>
                            <td>
                                <?php echo $data->news_content; ?>
                            </td>
                            <td>
                                <?php
                                $date = new DateTime($data->news_publish_date);
                                echo $date->format('d-m-Y');
                                ?>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<script>
    $(document).ready(function()
    {
        $('tr').on("click", function() {
            if($(this).attr('href') !== undefined){
                document.location = $(this).attr('href');
            }
        });
    });
</script>