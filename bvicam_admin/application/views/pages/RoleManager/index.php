<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 8/1/14
 * Time: 11:47 PM
 */
?>
<div id="contentPanel" class="col-sm-12 col-md-12">
    <h1 class="page-header">Roles</h1>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <table class="table table-responsive table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Role Name</th>
                    <th>Role Application</th>
                    <th>Operations</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach($roles as $key=>$role)
                {
                    ?>
                    <tr <?php if($role->role_dirty) { ?> class="danger" <?php } ?>>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo $role->role_name; ?></td>
                        <td></td>
                        <td>
                            <a class="btn btn-sm btn-info" href="viewRole/<?php echo $role->role_id; ?>">Edit Role</a>
                            <?php
                            if($role->role_dirty == 0)
                            {
                                ?>
                                <button type="button" class="btn btn-sm btn-warning disableRole"
                                        data-role="<?php echo $role->role_id; ?>">Disable Role</button>
                            <?php
                            }
                            else
                            {
                                ?>
                                <button type="button" class="btn btn-sm btn-success enableRole"
                                        data-role="<?php echo $role->role_id; ?>">Enable Role</button>
                            <?php
                            }
                            ?>
                            <button type="button" class="btn btn-sm btn-danger deleteRole"
                                    data-role="<?php echo $role->role_id; ?>">Delete Role</button>
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
<script>
    $(document).ready(function()
    {
        $(".disableRole").click(function()
        {
            var roleId = $(this).attr("data-role");
            var data = "roleId=" + roleId;
            var url = "/<?php echo BASEURL; ?>RoleManager/disableRole_AJAX";
            callAJAX(url, data);
        });

        $(".enableRole").click(function()
        {
            var roleId = $(this).attr("data-role");
            var data = "roleId=" + roleId;
            var url = "/<?php echo BASEURL; ?>RoleManager/enableRole_AJAX";
            callAJAX(url, data);
        });

        $(".deleteRole").click(function()
        {
            if(!confirm("You clicked Delete Role. Are you sure you want to continue"))
                return;
            var roleId = $(this).attr("data-role");
            var data = "roleId=" + roleId;
            var url = "/<?php echo BASEURL; ?>RoleManager/deleteRole_AJAX";
            callAJAX(url, data);
        });

        function callAJAX(url, data)
        {
            $.ajax({
                type: "POST",
                url: url,
                data: data,
                success: function(msg){
                    if(msg == true)
                    {
                        location.reload();
                    }
                    else
                    {
                        alert("ERROR : " + msg);
                    }
                }
            });
        }
    });
</script>