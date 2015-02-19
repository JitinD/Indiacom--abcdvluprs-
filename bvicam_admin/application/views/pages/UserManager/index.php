<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 8/13/14
 * Time: 8:56 PM
 */
?>

<div class="col-sm-10 col-md-10" id="contentPanel">
    <h1 class="page-header">Manage Users</h1>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <table class="table table-responsive table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>User Name</th>
                    <th>Registrar</th>
                    <th>Operations</th>
                </tr>

                </thead>
                <tbody>
                <?php
                foreach($users as $key=>$user)
                {
                    ?>
                    <tr <?php if($user->user_dirty) { ?> class="danger" <?php } ?>>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo $user->user_name; ?></td>
                        <td>
                            <?php
                            if(in_array($user, $registrars))
                                echo "Yes";
                            else
                                echo "No";
                            ?>
                        </td>
                        <td>
                            <a class="btn btn-sm btn-info" href="viewUser/<?php echo $user->user_id; ?>">Edit User</a>
                            <?php
                            if($user->user_dirty == 0)
                            {
                            ?>
                                <a class="btn btn-sm btn-danger" href="disableUser/<?php echo $user->user_id; ?>">Disable User</a>
                            <?php
                            }
                            else
                            {
                            ?>
                                <a class="btn btn-sm btn-success" href="enableUser/<?php echo $user->user_id; ?>">Enable User</a>
                            <?php
                            }
                            ?>
                            <?php
                            if(!in_array($user, $registrars))
                            {
                            ?>
                                <a class="btn btn-sm btn-danger" href="deleteUser/<?php echo $user->user_id; ?>">Delete User</a>
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
        </div>
    </div>
</div>
</div>