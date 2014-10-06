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

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h1 class="page-header">News</h1>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <form class="form-horizontal" enctype="multipart/form-data" method = "post" action="addNews">
                <div class="form-group">
                    <label for="application" class="col-sm-2 control-label">Select Application</label>
                    <div class="col-sm-6">
                        <select id="application" name="application" class="form-control" >

                            <?php foreach($allApplications as $applications)
                            {
                            ?>
                                <option value = "<?php echo $applications -> application_id ?>" <?php if(set_value('application') == $applications ->application_id) echo "selected" ; ?>><?php echo $applications -> application_name ?></option>

                            <?php

                            }
                            ?>
                            </select>

                    </div>
                </div>
                <button type="submit" class="btn btn-success"  href="addNews"<span class="glyphicon glyphicon-plus"></span> Create News</button>

            </form>


            <table class="table table-responsive table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>News Title</th>
                    <th>Operations</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Indiacom agle saal hoga</td>
                        <td>
                            <a class="btn btn-sm btn-warning"  href="#"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
                            <a class="btn btn-sm btn-danger"  href="#"><span class="glyphicon glyphicon-minus"></span> Delete</a>

                        </td>

                    </tr>
                </tbody>
            </table>

        </div>
    </div>
</div>
</div>