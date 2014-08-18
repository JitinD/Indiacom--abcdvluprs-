<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 8/13/14
 * Time: 8:56 PM
 */
?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h1 class="page-header">Manage Users</h1>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <table class="table table-responsive table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>User Name</th>
                    <th>Operations</th>
                </tr>

                </thead>
                <tbody>
                <?php
                foreach($users as $key=>$user)
                {
                    ?>
                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo $user->user_name; ?></td>
                        <td>
                            <a href="viewUser/<?php echo $user->user_id; ?>">Edit User</a>
                            /
                            <?php
                            if($user->user_dirty == 0)
                            {
                            ?>
                                <a href="disableUser/<?php echo $user->user_id; ?>">Disable User</a>
                            <?php
                            }
                            else
                            {
                            ?>
                                <a href="enableUser/<?php echo $user->user_id; ?>">Enable User</a>
                            <?php
                            }
                            ?>
                        </td>
                    </tr>
                <?php
                }
                ?>
                </tbody>
            </table>
            <a class="btn btn-success"  href="newUser"><span class="glyphicon glyphicon-plus"></span> Create new user</a>
        </div>
    </div>
</div>
</div>