<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 8/14/14
 * Time: 7:37 PM
 */
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 col-md-offset-2">
            <form role="form" action="setRole" method="post">
                <h2 class="form-signin-heading">Please select the role you want to login as:</h2>
                <select name="role_id" class="form-control">
                    <option value>Select Role</option>
                    <?php
                    foreach($roles as $role)
                    {
                    ?>
                        <option value="<?php echo $role->role_id; ?>"><?php echo $applications[$role->role_application_id] . " : " . $role->role_name; ?></option>
                    <?php
                    }
                    ?>
                </select>
                <div class="col-md-8 col-md-offset-2">
                    <input type="submit" style="margin-top: 10px;" class="btn btn-primary btn-block">
                </div>

            </form>
        </div>
    </div>
</div>