<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 8/3/14
 * Time: 12:01 AM
 */
?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h1 class="page-header">Role - <?php echo $roleInfo->role_name; ?></h1>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <form action="#" method="post">
                <div class="col-sm-8 col-sm-offset-4 text-danger h5">
                    <?php if(isset($pageError)) echo $pageError; ?>
                    <?php echo validation_errors(); ?>
                </div>
                <table class="table">
                    <tr>
                        <td>
                            <button type="button" class="btn btn-primary" id="addPrivilege">Add privilege to role</button>
                        </td>
                        <td id="selectEntityPlaceHolder"></td>
                        <td id="selectOperationPlaceHolder"></td>
                        <td><button type="submit" id="submitButton" style="display: none;" class="btn btn-primary">Submit</button></td>
                    </tr>
                </table>
            </form>
            <table class="table table-responsive table-hover">
                <thead>
                <tr>
                    <th>Privilege Id</th>
                    <th>Entity</th>
                    <th>Operation</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach($privilegeDetails as $privilege)
                {
                    ?>
                    <tr>
                        <td><?php echo $privilege->privilege_id; ?></td>
                        <td><?php echo $privilege->privilege_entity; ?></td>
                        <td><?php echo $privilege->privilege_operation; ?></td>
                        <td><a href="#">Disable</a> / <a href="#">Delete</a></td>
                    </tr>
                <?php
                }
                ?>

                </tbody>
            </table>
        </td>
        </div>
    </div>
</div>
</div>

<script>
    $(document).ready(function() {
        $('#addPrivilege').click(function() {
            var operationOptions = "";
            var entityOptions = "";
            <?php
            foreach($entities as $entity)
            {
            ?>
                entityOptions += "<option value=\"<?php echo $entity; ?>\"><?php echo $entity; ?></option>";
            <?php
            }
            ?>
            var html = "<select name=\"entity\" class=\"form-control entityyList\">" +
                            "<option value>Select Entity</option>" +
                            entityOptions +
                        "</select>";
            var html2 = "<select name=\"operation\" class=\"form-control\">" +
                            "<option value>Select Operation</option>" +
                            "<option value=\"Select\">Select</option>" +
                            "<option value=\"Update\">Update</option>" +
                            "<option value=\"Insert\">Insert</option>" +
                            "<option value=\"Delete\">Delete</option>" +
                        "</select>";
            $('#selectEntityPlaceHolder').append(html);
            $('#selectOperationPlaceHolder').append(html2);
            $('#submitButton').css('display', 'initial');
            $(this).css('display', 'none');

            $('.entityyList').change(function() {
                var optionSelected = $(this).find("option:selected");
                $('#selectOperationPlaceHolder').empty();
                var html =  "<select name=\"operation\" class=\"form-control\">" +
                                "<option value>Select Operation</option>" +
                                "<option value=\"Select\">Select</option>" +
                                "<option value=\"Update\">Update</option>" +
                                "<option value=\"Insert\">Insert</option>" +
                                "<option value=\"Delete\">Delete</option>" +
                            "</select>";
                $('#selectOperationPlaceHolder').append(html);
            });
        });
    });
</script>