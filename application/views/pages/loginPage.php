<div class="row">
    <div class="col-md-9 formDiv">
        <form role="form" class="form-horizontal" method="post" action="/<?php echo INDIACOM ?>index.php/Login/authenticate">
            <div class="form-group">
                <label for="memberID" class="col-sm-4 control-label h4">Member ID</label>
                <div class="col-sm-8">
                    <input type="text" name="username" class="form-control input-lg" id="memberID" placeholder="Enter Member ID">
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="col-sm-4 control-label h4">Password</label>
                <div class="col-sm-8">
                    <input type="password" name="password" class="form-control input-lg" id="password" placeholder="Enter Password">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-8 col-sm-offset-4">
                    <button type="submit" class="btn btn-success btn-lg btn-block">Submit</button>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-8 col-sm-offset-4">
                    <button type="button" class="btn btn-danger btn-lg btn-block">Forgot Password</button>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">

                </div>
            </div>
        </form>
    </div>
</div>