<?php
/**
 * Created by PhpStorm.
 * User: saura_000
 * Date: 9/22/15
 * Time: 1:00 PM
 */
?>

<div id="contentPanel" class="col-sm-12 col-md-12">
    <h1 class="page-header">Co-Convener Manager - Assign Tracks</h1>
    <div class="col-md-12">
        <table class="table">
            <thead>
            <tr>
                <th>Convener Name</th>
                <?php
                foreach($events as $event)
                {
                ?>
                    <th><?php echo $event->event_name; ?></th>
                <?php
                }
                ?>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach($coConveners as $coConvener)
            {
            ?>
                <tr>
                    <td><?php echo $coConvener->user_name; ?></td>
                    <?php
                    foreach($events as $event)
                    {
                    ?>
                        <td>
                            <ul class="list-group">
                                <?php
                                $hasTrack = false;
                                foreach($tracks[$event->event_id] as $track)
                                {
                                    $isTrack = false;
                                    if($coConvenerTrack[$coConvener->user_id][$event->event_id]!=null && $coConvenerTrack[$coConvener->user_id][$event->event_id]->track_id == $track->track_id)
                                    {
                                        $hasTrack = true;
                                        $isTrack = true;
                                    }
                                ?>
                                    <li class="list-group-item <?php if($isTrack) echo "active"; ?> track" style="cursor: pointer;"
                                        data-user="<?php echo $coConvener->user_id; ?>"
                                        data-track="<?php echo $track->track_id; ?>">
                                        <?php echo $track->track_name; ?>
                                    </li>
                                <?php
                                }
                                ?>
                                <li class="list-group-item <?php if(!$hasTrack) echo "active"; ?>">No Track</li>
                            </ul>
                            <?php /*echo "Track " . $coConvenerTrack[$coConvener->user_id][$event->event_id]->track_number . " : " . $coConvenerTrack[$coConvener->user_id][$event->event_id]->track_name; */?>
                        </td>
                    <?php
                    }
                    ?>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function()
    {
        $(".track").click(function()
        {
            var userId = $(this).attr("data-user");
            var trackId = $(this).attr("data-track");
            var data = "userId=" + userId + "&trackId=" + trackId;
            var ref = $(this);
            $.ajax({
                type: "POST",
                url: "/<?php echo BASEURL; ?>CoConvenerManager/setTrackCoConvener_AJAX",
                data: data,
                success: function (msg) {
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
        });
    });
</script>