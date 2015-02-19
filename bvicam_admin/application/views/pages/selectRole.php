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
        <div class="col-md-12">
            <h1 class="page-header">Select Role</h1>
            <form role="form" action="setRole" method="post">
                <h3 class="form-signin-heading">Please select the role you want to login as:</h3>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <select name="role_id" class="form-control input-lg">
                            <option value>Select Role</option>
                            <?php
                            foreach($roles as $role)
                            {
                                ?>
                                <option value="<?php echo $role->role_id; ?>"><?php echo $role->role_name; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <input type="submit" class="btn btn-lg btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>