<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 8/1/14
 * Time: 11:47 PM
 */
?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h1 class="page-header">Roles</h1>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <table class="table table-responsive table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Role Name</th>
                    <th>Operations</th>
                </tr>

                </thead>
                <tbody>
                <?php
                foreach($roles as $key=>$role)
                {
                    ?>
                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo $role->role_name; ?></td>
                        <td>
                            <<<<<<< HEAD
                            <a href="viewRole/<?php echo $role->role_id; ?>">Edit Role</a>
                            /
                            <?php
                            if($role->role_dirty == 0)
                            {
                                ?>
                                <a href="disableRole/<?php echo $role->role_id; ?>">Disable Role</a>
                            <?php
                            }
                            else
                            {
                                ?>
                                <a href="enableRole/<?php echo $role->role_id; ?>">Enable Role</a>
                            <?php
                            }
                            ?>
                            =======
                            <a class="btn btn-primary" href="viewRole/<?php echo $role->role_id; ?>">Edit Role</a>
                            <a class="btn btn-primary"  href="#">Disable Role</a>
                            <a class="btn btn-danger"  href="#">Delete Role</a>
                            >>>>>>> da804f7ce1fe2ff815fbb74b5e2d7b81ba468633
                        </td>
                    </tr>
                <?php
                }
                ?>
                </tbody>
            </table>
            <a class="btn btn-success"  href="newRole"><span class="glyphicon glyphicon-plus"></span> Create new role</a>
        </div>
    </div>
</div>
</div>