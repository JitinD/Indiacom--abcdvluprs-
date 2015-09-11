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
                                                       data-priv="<?php echo $privId[0]; ?>">
                                                <?php echo $operationName; ?>
                                            </td>
                                            <td>
                                                <?php
                                                if(isset($privilegeDirtyStatus[$privId[0]]))
                                                {
                                                    if ($privilegeDirtyStatus[$privId[0]] == 0)
                                                    {
                                                        ?>
                                                        <a class="btn btn-sm btn-default"
                                                           href="../disableRolePrivilege/<?php echo $roleInfo->role_id; ?>/<?php echo $privId[0]; ?>">Disable</a>
                                                    <?php
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <a class="btn btn-sm btn-default"
                                                           href="../enableRolePrivilege/<?php echo $roleInfo->role_id; ?>/<?php echo $privId[0]; ?>">Enable</a>
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
            <!--<table class="table table-responsive table-hover">
                <thead>
                <tr>
                    <th>Privilege Id</th>
                    <th>Entity/Module</th>
                    <th>Operation</th>
                </tr>
                </thead>
                <tbody>
                <?php
/*                foreach ($privilegeDetails as $privilege) {
                    */?>
                    <tr <?php /*if ($privilegeDirtyStatus[$privilege->privilege_id]) { */?> class="danger" <?php /*} */?>>
                        <td><?php /*echo $privilege->privilege_id; */?></td>
                        <td><?php /*echo $privilege->privilege_entity; */?></td>
                        <td><?php /*echo $privilege->privilege_operation; */?></td>
                        <td>
                            <?php
/*                            if ($privilegeDirtyStatus[$privilege->privilege_id] == 0) {
                                */?>
                                <a class="btn btn-sm btn-default"
                                   href="../disableRolePrivilege/<?php /*echo $roleInfo->role_id; */?>/<?php /*echo $privilege->privilege_id; */?>">Disable</a>
                            <?php
/*                            } else {
                                */?>
                                <a class="btn btn-sm btn-default"
                                   href="../enableRolePrivilege/<?php /*echo $roleInfo->role_id; */?>/<?php /*echo $privilege->privilege_id; */?>">Enable</a>
                            <?php
/*                            }
                            */?>
                            <a class="btn btn-sm btn-default"
                               href="../deleteRolePrivilege/<?php /*echo $roleInfo->role_id; */?>/<?php /*echo $privilege->privilege_id; */?>">Delete</a>
                        </td>
                    </tr>
                <?php
/*                }
                */?>

                </tbody>
            </table>-->
        </div>
    </div>
</div>
</div>

<script>
    $(document).ready(function () {
        $(".check_privilege").click(function()
        {
            var formAction = "";
            if($(this).is(":checked"))
            {
                formAction = "../addRolePrivilege/" + $("#privilege_form").attr("data-role") + "/" + $(this).attr("data-priv");
            }
            else
            {
                formAction = "../deleteRolePrivilege/" + $("#privilege_form").attr("data-role") + "/" + $(this).attr("data-priv");
            }
            $("#privilege_form").attr("action", formAction);
            $("#privilege_form").submit();
        });
    });
</script>