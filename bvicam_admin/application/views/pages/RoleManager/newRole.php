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
                    <label for="add_entity" class="col-sm-3 control-label">Add Entity</label>
                    <div class="col-sm-9">
                        <select class="form-control" id="add_entity">
                            <option value>Select Entity To Add</option>
                            <?php
                            foreach($entities as $entity)
                            {
                                ?>
                                <option value="<?php echo $entity->table_name; ?>"><?php echo $entity->table_name; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">

                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Entity wise privileges</label>
                    <div class="col-sm-9">
                        <table class="table table-responsive table-hover">
                            <thead>
                            <tr>
                                <th>Entity Name</th>
                                <th>Privileges</th>
                            </tr>
                            </thead>
                            <tbody id="items">

                            </tbody>
                        </table>
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
        $('#add_entity').change(function () {
            var optionSelected = $(this).find("option:selected");
            //var id = "#entity_" + $(optionSelected).val();
            //$(id).css('display', 'table-row');
            var html =  "<tr>" +
                        "<td>" + $(optionSelected).val() + "</td>" +
                        "<td>" +
                            "<ul style=\"list-style: none;\">" +
                                "<li><input type=\"checkbox\" name=\"" + $(optionSelected).val() + ":Select\"> Select" +
                                "<li><input type=\"checkbox\" name=\"" + $(optionSelected).val() + ":Update\"> Update" +
                                "<li><input type=\"checkbox\" name=\"" + $(optionSelected).val() + ":Insert\"> Insert" +
                                "<li><input type=\"checkbox\" name=\"" + $(optionSelected).val() + ":Delete\"> Delete" +
                            "</ul>" +
                        "</td>" +
                    "</tr>";
            $('#items').prepend(html);
        });

        $('.remove_entity').click(function() {
            var id = "#entity_" + $(this).val();
            $(id).css('display', 'none');
        })
    });
</script>