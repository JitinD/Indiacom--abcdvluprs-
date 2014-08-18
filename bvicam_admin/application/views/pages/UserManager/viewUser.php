<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 8/13/14
 * Time: 9:11 PM
 */
?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h1 class="page-header">Manage User - <?php echo $userInfo->user_name; ?></h1>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <form action="#" method="post">
                <div class="col-sm-8 col-sm-offset-4 text-danger h5">
                    <?php if(isset($pageError)) echo $pageError; ?>
                    <?php echo validation_errors(); ?>
                </div>
                <table class="table">
                    <tr>
                        <td id="selectEntityPlaceHolder">
                            <select name="event" class="form-control">
                                <option value>Select Event</option>
                                <?php
                                foreach($events as $event)
                                {
                                ?>
                                    <option value="<?php echo $event->event_id; ?>"><?php echo $event->event_name; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </td>
                        <td id="selectOperationPlaceHolder">
                            <select name="role" class="form-control">
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
                        </td>
                        <td><button type="submit" id="submitButton" class="btn btn-primary">Submit</button></td>
                    </tr>
                </table>
            </form>
            <table class="table table-responsive table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Event Name</th>
                    <th>Role Name</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach($userEventsAndRoles as $key=>$userEventAndRole)
                {
                    ?>
                    <tr>
                        <td><?php echo $key; ?></td>
                        <td><?php echo $userEventAndRole->event_name; ?></td>
                        <td><a href="../../RoleManager/viewRole/<?php echo $userEventAndRole->role_id; ?>"><?php echo $userEventAndRole->role_name; ?></a></td>
                        <td>
                            <?php
                            if($userEventAndRole->user_event_role_mapper_dirty == 0)
                            {
                                ?>
                                <a href="../disableUserEventRole/<?php echo $userInfo->user_id; ?>/<?php echo $userEventAndRole->event_id; ?>/<?php echo $userEventAndRole->role_id; ?>">Disable</a>
                            <?php
                            }
                            else
                            {
                                ?>
                                <a href="../enableUserEventRole/<?php echo $userInfo->user_id; ?>/<?php echo $userEventAndRole->event_id; ?>/<?php echo $userEventAndRole->role_id; ?>">Enable</a>
                            <?php
                            }
                            ?>
                            / <a href="../deleteUserEventRole/<?php echo $userInfo->user_id; ?>/<?php echo $userEventAndRole->event_id; ?>/<?php echo $userEventAndRole->role_id; ?>">Delete</a>
                        </td>
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
        $('#addEventRole').click(function() {
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