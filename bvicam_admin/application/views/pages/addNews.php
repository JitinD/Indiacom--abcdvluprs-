<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 8/10/14
 * Time: 2:09 PM
 */ ?>
<script src="/<?php echo PATH ?>assets/js/AJAX.js"></script>
<link rel="stylesheet" href="/<?php echo PATH ?>assets/css/AJAXstyle.css">

<div class="container-fluid">
<div class="row contentBlock-top">
    <div class="col-md-9 col-md-offset-2 col-sm-8 col-sm-offset-0 col-xs-12 col-xs-offset-0">
        <h1 class="text-theme">Add News</h1>
        <hr>
    </div>
</div>
<div class="row">
<div class="col-md-6 col-md-offset-2 col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
<form class="form-horizontal" enctype="multipart/form-data" method = "post">

    <div class="form-group">
        <label for="newsTitle" class="col-sm-3 control-label"><span class="glyphicon glyphicon-asterisk text-danger"></span> News Title</label>
        <div class="col-sm-9">
            <input type="text" name = "newsTitle" class="form-control" id="newsTitle" placeholder="Enter news title">
        </div>
        <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
            <?php echo form_error('newsTitle'); ?>
        </div>
    </div>

    <div class="form-group">
        <label for="description" class="col-sm-3 control-label"><span class="glyphicon glyphicon-asterisk text-danger"></span>Description URL</label>
        <div class="col-sm-9">
            <input type="file" name = "description" class="form-control" id="description" placeholder="Enter news description url">
        </div>
        <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
            <?php echo form_error('description'); ?>
        </div>
    </div>

    <div class="form-group">
        <label for="publisherID" class="col-sm-3 control-label"><span class="glyphicon glyphicon-asterisk text-danger"></span>Publisher Member ID</label>
        <div class="col-sm-9">
            <input type="text" name = "publisherID" class="form-control" id="publisherID" value="" placeholder="Enter publisher ID">
        </div>
        <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
            <?php echo form_error('publisherID'); ?>
        </div>
    </div>

    <div class="form-group">
        <label for="publishDate" class="col-sm-3 control-label"><span class="glyphicon glyphicon-asterisk text-danger"></span>Publishing Date</label>
        <div class="col-sm-9">
            <input type="date" name = "publishDate" class="form-control" id="publishDate" value="" placeholder="yyyy-mm-dd hh:mm:ss">
        </div>
        <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
            <?php echo form_error('publishDate'); ?>
        </div>
    </div>

    <div class="form-group">
        <label for="publishTime" class="col-sm-3 control-label"><span class="glyphicon glyphicon-asterisk text-danger"></span>Publishing Time</label>
        <div class="col-sm-9">
            <input type="time" name = "publishTime" class="form-control" id="publishTime" value="<?php echo "00:00:00"?>" placeholder="yyyy-mm-dd hh:mm:ss">
        </div>
        <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
            <?php echo form_error('publishTime'); ?>
        </div>
    </div>

    <div class="form-group">
        <label for="stickyDate" class="col-sm-3 control-label">News Sticky Date</label>
        <div class="col-sm-9">
            <input type="date" name = "stickyDate" class="form-control" id="stickyDate" value="<?php echo "1970-01-01"?>" placeholder="yyyy-mm-dd hh:mm:ss">
        </div>
        <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">

        </div>
    </div>

    <div class="form-group">
        <label for="stickyTime" class="col-sm-3 control-label">News Sticky Time</label>
        <div class="col-sm-9">
            <input type="time" name = "stickyTime" class="form-control" id="stickyTime" value="<?php echo "00:00:00"?>" placeholder="yyyy-mm-dd hh:mm:ss">
        </div>
        <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">

        </div>
    </div>

    <div class="form-group">
        <label for="event" class="col-sm-3 control-label"><span class="glyphicon glyphicon-asterisk text-danger"></span>Event</label>
        <div class="col-sm-9">

            <select name = "event" class="form-control" id="event" >
                <?php foreach($events as $event)
                {
                    ?>
                    <option value ="<?php echo $event->event_id?>"><?php echo $event->event_name; ?></option>
                <?php
                }
                ?>
            </select>
        </div>
        <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
            <?php echo form_error('event'); ?>
        </div>
    </div>


    <div class="form-group">
        <label for="attachment" class="col-sm-3 control-label">Attachment</label>
        <div class="col-sm-9">
            <input type="file" name = "attachment" class="form-control" id="attachment" placeholder="Choose File">
        </div>
        <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">

        </div>
    </div>


    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-6">
            <button type="submit" class="btn btn-primary">Add News</button>
            <button type="reset" class="btn btn-danger">Reset</button>
        </div>
    </div>

</form>

</div>

</div>
</div>