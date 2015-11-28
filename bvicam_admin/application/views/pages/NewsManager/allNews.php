<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 8/10/14
 * Time: 2:09 PM
 */ ?>
<script src="/<?php echo PATH ?>assets/js/AJAX.js" xmlns="http://www.w3.org/1999/html"
        xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html"></script>
<link rel="stylesheet" href="/<?php echo PATH ?>assets/css/AJAXstyle.css">

<div class="col-sm-12 col-md-12" id="contentPanel">
    <h1 class="page-header">News</h1>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <form class="form-horizontal"
                  id="form_application"
                  enctype="multipart/form-data"
                  method="post"
                  action="/<?php echo BASEURL; ?>index.php/NewsManager/changeApplication">
                <div class="form-group">
                    <label for="application" class="col-sm-2 control-label">Select Application</label>
                    <div class="col-sm-6">
                        <select id="select_application" name="application" class="form-control" >
                            <option value="-1">Select Application</option>
                            <?php
                            foreach($allApplications as $application)
                            {
                            ?>
                                <option value="<?php echo $application -> application_id; ?>"
                                        <?php
                                        if(set_value('application') == $application->application_id || $currentAppId == $application->application_id)
                                            echo "selected";
                                        ?>>
                                    <?php echo $application->application_name; ?>
                                </option>
                            <?php
                            }
                            ?>
                            </select>
                    </div>
                </div>
            </form>

            <table class="table table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>News Title</th>
                    <th>Operations</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($allNews as $key=>$news)
                    {
                    ?>
                        <tr class="<?php if($news->news_dirty == 1) echo "danger"; ?>">
                            <td><?php echo $key+1; ?></td>
                            <td><?php echo $news->news_title; ?></td>
                            <td>
                                <div class="btn-group">
                                <?php
                                if($currentAppId != -1)
                                {
                                ?>
                                    <a class="btn btn-sm btn-default"  href="#"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
                                    <?php
                                    if($news->news_dirty == 0)
                                    {
                                    ?>
                                        <a class="btn btn-sm btn-default"  href="/<?php echo BASEURL; ?><?php echo $addNewsController; ?>/disableNews/<?php echo $news->news_id; ?>">
                                            <span class="glyphicon glyphicon-ban-circle"></span> Disable
                                        </a>
                                    <?php
                                    }
                                    else
                                    {
                                    ?>
                                        <a class="btn btn-sm btn-default"  href="/<?php echo BASEURL; ?><?php echo $addNewsController; ?>/enableNews/<?php echo $news->news_id; ?>">
                                            <span class="glyphicon glyphicon-ok-circle"></span> Enable
                                        </a>
                                    <?php
                                    }
                                    ?>
                                    <a class="btn btn-sm btn-default"  href="/<?php echo BASEURL; ?><?php echo $addNewsController; ?>/deleteNews/<?php echo $news->news_id; ?>">
                                        <span class="glyphicon glyphicon-remove"></span> Delete
                                    </a>
                                <?php
                                }
                                ?>
                                </div>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <a href="/<?php echo BASEURL; ?><?php echo $addNewsController; ?>/addNews" class="btn btn-success <?php
                if($currentAppId == -1)
                    echo "disabled";
                ?>">
                <span class="glyphicon glyphicon-plus"></span> Create News
            </a>
        </div>
    </div>
</div>
</div>

<script>
    $(document).ready(function()
    {
        $('#select_application').change(function()
        {
            $('#form_application').submit();
        });
    });
</script>