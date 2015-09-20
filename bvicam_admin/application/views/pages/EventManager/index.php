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
                <tr>
                    <td><?php echo $event->event_id; ?></td>
                    <td><?php echo $event->event_name; ?></td>
                    <td><?php echo $event->event_start_date; ?></td>
                    <td><?php echo $event->event_end_date; ?></td>
                    <td><a class="btn btn-sm btn-default" href="viewEvent/<?php echo $event->event_id; ?>">Edit Event</a></td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
        <a class="btn btn-success"  href="newEvent"><span class="glyphicon glyphicon-plus"></span> Create new event</a>
    </div>
</div>