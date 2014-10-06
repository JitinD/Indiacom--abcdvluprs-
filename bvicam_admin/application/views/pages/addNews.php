<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 8/10/14
 * Time: 2:09 PM
 */ ?>
<script src="/<?php echo PATH ?>assets/js/AJAX.js"></script>
<link rel="stylesheet" href="/<?php echo PATH ?>assets/css/AJAXstyle.css">

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h1 class="page-header">Add News</h1>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <form class="form-horizontal" enctype="multipart/form-data" method = "post">
                <div class="form-group">
                    <label for="title" class="col-sm-3 control-label"><span class="glyphicon glyphicon-asterisk text-danger"></span> Title</label>
                    <div class="col-sm-6">
                        <input type="text" name = "title" id="title" class="form-control" value="" placeholder="Enter Title">
                    </div>
                </div>
                <div class="form-group">
                    <label for="content" class="col-sm-3 control-label"><span class="glyphicon glyphicon-asterisk text-danger"></span> Content</label>
                    <div class="col-sm-6">
                        <textarea name = "content" class="form-control" id="content" rows="5" placeholder="Enter Content"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="publishDate" class="col-sm-3 control-label"><span class="glyphicon glyphicon-asterisk text-danger"></span> Publish Date</label>
                    <div class="col-sm-6">
                        <input type="date" name = "content" class="form-control" id="publishDate">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-6 col-sm-offset-3">
                        <button type="submit" class="btn btn-success">Submit</button>
                        <button type="reset" class="btn btn-danger">Clear</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
