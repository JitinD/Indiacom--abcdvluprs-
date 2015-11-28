<?php
/**
 * Created by PhpStorm.
 * User: saura_000
 * Date: 9/19/15
 * Time: 11:45 AM
 */
?>
<div id="contentPanel" class="col-sm-12 col-md-12">
    <h1 class="page-header">Event Manager</h1>
    <div class="col-md-12">
        <table class="table table-responsive">
            <thead>
            <tr>
                <th>Event Id</th>
                <th>Event Name</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th></th>
            </tr>
            </thead>

            <tbody>
            <?php
            foreach($events as $event)
            {
            ?>
                <tr class="<?php if($event->event_dirty) echo "danger"; ?>">
                    <td><?php echo $event->event_id; ?></td>
                    <td><?php echo $event->event_name; ?></td>
                    <td><?php echo $event->event_start_date; ?></td>
                    <td><?php echo $event->event_end_date; ?></td>
                    <td>
                        <a class="btn btn-sm btn-info" href="viewEvent/<?php echo $event->event_id; ?>">Edit Event</a>
                        <?php
                        if($event->event_dirty)
                        {
                        ?>
                            <button type="button" class="btn btn-sm btn-success enableEvent"
                                    data-event="<?php echo $event->event_id; ?>">Enable</button>
                        <?php
                        }
                        if(!$event->event_dirty)
                        {
                        ?>
                            <button type="button" class="btn btn-sm btn-danger disableEvent"
                                    data-event="<?php echo $event->event_id; ?>">Disable</button>
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
        <a class="btn btn-success"  href="newEvent"><span class="glyphicon glyphicon-plus"></span> Create new event</a>
    </div>
</div>
<script>
    $(document).ready(function()
    {
        $(".enableEvent").click(function()
        {
            var eventId = $(this).attr("data-event");
            var data = "eventId=" + eventId;
            var url = "/<?php echo BASEURL; ?>EventManager/enableEvent_AJAX";
            callAJAX(url, data);
        });

        $(".disableEvent").click(function()
        {
            var eventId = $(this).attr("data-event");
            var data = "eventId=" + eventId;
            var url = "/<?php echo BASEURL; ?>EventManager/disableEvent_AJAX";
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