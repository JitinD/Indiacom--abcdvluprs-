<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 8/3/14
 * Time: 12:01 AM
 */
?>

<div class="col-sm-12 col-md-12">
    <h1 class="page-header">Role - <?php echo $roleInfo->role_name; ?></h1>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <form id="privilege_form" action="#" method="post" data-role="<?php echo $roleInfo->role_id; ?>">
                <div class="col-sm-8 col-sm-offset-4 text-danger h5">
                    <?php if (isset($pageError)) echo $pageError; ?>
                    <?php echo validation_errors(); ?>
                </div>
                <table class="table table-responsive">
                    <thead>
                    <tr>
                        <th>Module Name</th>
                        <th>Module Operations</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($modules[$roleInfo->role_application_id."a"]['Page'] as $moduleName => $privs)
                    {
                    ?>
                        <tr>
                            <td><?php echo $moduleName; ?></td>
                            <td>
                                <table class="table table-responsive table-condensed">
                                    <?php
                                    foreach($privs as $operationName => $privId)
                                    {
                                    ?>
                                        <tr <?php if (isset($privilegeDirtyStatus[$privId[0]]) && $privilegeDirtyStatus[$privId[0]]) { ?> class="danger" <?php } ?>>
                                            <td>
                                                <input type="checkbox" <?php echo (isset($privilegeDirtyStatus[$privId[0]])) ? "checked" : ""; ?>
                                                       class="check_privilege"
                                                       data-priv="<?php echo $privId[0]; ?>"
                                                       data-role="<?php echo $roleInfo->role_id; ?>">
                                                <?php echo $operationName; ?>
                                            </td>
                                            <td>
                                                <?php
                                                if(isset($privilegeDirtyStatus[$privId[0]]))
                                                {
                                                    if ($privilegeDirtyStatus[$privId[0]] == 0)
                                                    {
                                                        ?>
                                                        <button class="btn btn-sm btn-warning disablePrivilege" type="button"
                                                                data-role="<?php echo $roleInfo->role_id; ?>"
                                                                data-priv="<?php echo $privId[0]; ?>">Disable</button>
                                                    <?php
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <button class="btn btn-sm btn-success enablePrivilege" type="button"
                                                                data-role="<?php echo $roleInfo->role_id; ?>"
                                                                data-priv="<?php echo $privId[0]; ?>">Enable</button>
                                                    <?php
                                                    }
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </table>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>
</div>

<script>
    $(document).ready(function () {
        $(".check_privilege").click(function()
        {
            var privId = $(this).attr("data-priv");
            var roleId = $(this).attr("data-role");
            var data = "roleId=" + roleId + "&privilegeId=" + privId;
            var url = "/<?php echo BASEURL; ?>RoleManager/";
            if($(this).is(":checked"))
            {
                url += "addRolePrivilege_AJAX";
            }
            else
            {
                url += "deleteRolePrivilege_AJAX";
            }
            callAJAX(url, data);
        });

        $(".enablePrivilege").click(function()
        {
            var roleId = $(this).attr("data-role");
            var privId = $(this).attr("data-priv");
            var data = "roleId=" + roleId + "&privilegeId=" + privId;
            var url = "/<?php echo BASEURL; ?>RoleManager/enableRolePrivilege_AJAX";
            callAJAX(url, data);
        });

        $(".disablePrivilege").click(function()
        {
            var roleId = $(this).attr("data-role");
            var privId = $(this).attr("data-priv");
            var data = "roleId=" + roleId + "&privilegeId=" + privId;
            var url = "/<?php echo BASEURL; ?>RoleManager/disableRolePrivilege_AJAX";
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