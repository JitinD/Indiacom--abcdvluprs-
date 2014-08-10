<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 8/10/14
 * Time: 5:43 PM
 */
?>

<form role="form" class="form-horizontal" method="post" action="">
    <div class="form-group">
        <label for="emailId" class="col-sm-4 control-label h4">Email ID</label>
        <div class="col-sm-8">
            <input type="text" name="emailId" class="form-control" id="emailId" placeholder="Enter Email ID" autofocus>
        </div>
        <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">

        </div>
    </div>
    <div class="form-group">
        <label for="password" class="col-sm-4 control-label h4">Password</label>
        <div class="col-sm-8">
            <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password">
        </div>
        <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">

        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-8 col-sm-offset-4">
            <button name="submit" value="1" type="submit" class="btn btn-success btn-block">Submit</button>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-8 col-sm-offset-4">
            <a href="forgotPassword" class="btn btn-danger btn-block">Forgot Password</a>

        </div>
    </div>
</form>