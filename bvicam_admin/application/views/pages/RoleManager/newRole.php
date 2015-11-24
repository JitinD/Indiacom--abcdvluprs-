<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 8/2/14
 * Time: 1:07 AM
 */
?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h1 class="page-header">Roles</h1>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <form class="form-horizontal" role="form" action="#" method="post">
                <div class="form-group">
                    <label for="role_name" class="col-sm-3 control-label">Role Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="role_name" id="role_name" placeholder="Enter role name">
                    </div>
                    <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                        <?php echo form_error('role_name'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="application" class="col-sm-3 control-label">Application</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="application" id="application">
                            <option value>Select Application</option>
                            <?php
                            foreach($applications as $application)
                            {
                                ?>
                                <option value="<?php echo $application->application_id; ?>"><?php echo $application->application_name; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                        <?php echo form_error('role_name'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="add_module" class="col-sm-3 control-label">Select Module Privileges</label>
                    <div class="col-sm-9">
                        <?php
                        foreach($modules as $application => $appModules)
                        {
                        ?>
                            <table class="table table-responsive modules" style="display: none;" id="appModules<?php echo $application; ?>">
                                <thead>
                                <tr>
                                    <th>Module Name</th>
                                    <th>Module Operations</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach($appModules['Page'] as $moduleName => $operations)
                                {
                                    ?>
                                    <tr>
                                        <td><input type="checkbox"> <?php echo $moduleName; ?></td>
                                        <td>
                                            <ul style="list-style: none;">
                                                <?php
                                                foreach($operations as $operationName => $privs)
                                                {
                                                    ?>
                                                    <li>
                                                        <input type="checkbox" name="<?php echo $moduleName . ":" . $operationName; ?>">
                                                        <?php echo $operationName; ?>
                                                    </li>
                                                <?php
                                                }
                                                ?>
                                            </ul>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">

                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-6">
                        <button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<script>
    $(document).ready(function()
    {
        $('#application').change(function () {
            var appId = $(this).val() + "a";
            $('.modules').hide();
            $("#appModules" + appId).show();
        });

        $('.remove_entity').click(function() {
            var id = "#entity_" + $(this).val();
            $(id).css('display', 'none');
        })
    });
</script>