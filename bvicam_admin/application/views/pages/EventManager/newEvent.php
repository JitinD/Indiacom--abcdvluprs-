<?php
/**
 * Created by PhpStorm.
 * User: saura_000
 * Date: 9/19/15
 * Time: 12:10 PM
 */
?>

<div id="contentPanel" class="col-sm-12 col-md-12">
    <h1 class="page-header">Event Manager - New Event</h1>
    <div class="col-md-12">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <form role="form" action="#" method="post">
                <div class="form-group">
                    <label for="event_name" class="col-sm-3 control-label">Event Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="event_name" id="event_name" placeholder="Enter event name">
                    </div>
                    <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                        <?php echo form_error('event_name'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="event_desc" class="col-sm-3 control-label">Event Description</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="event_desc" id="event_desc" placeholder="Enter event description">
                    </div>
                    <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                        <?php echo form_error('event_desc'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="event_start_date" class="col-sm-3 control-label">Start Date</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control" name="event_start_date" id="event_start_date" placeholder="Enter event start date">
                    </div>
                    <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                        <?php echo form_error('event_start_date'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="event_end_date" class="col-sm-3 control-label">End Date</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control" name="event_end_date" id="event_end_date" placeholder="Enter event end date">
                    </div>
                    <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                        <?php echo form_error('event_end_date'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="event_paper_submission_start_date" class="col-sm-3 control-label">Paper Submission Start Date</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control" name="event_paper_submission_start_date" id="event_paper_submission_start_date" placeholder="Enter paper submission start date">
                    </div>
                    <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                        <?php echo form_error('event_paper_submission_start_date'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="event_paper_submission_end_date" class="col-sm-3 control-label">Paper Submission End Date</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control" name="event_paper_submission_end_date" id="event_paper_submission_end_date" placeholder="Enter paper submission end date">
                    </div>
                    <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                        <?php echo form_error('event_paper_submission_end_date'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="event_abstract_submission_end_date" class="col-sm-3 control-label">Abstract Submission End Date</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control" name="event_abstract_submission_end_date" id="event_abstract_submission_end_date" placeholder="Enter abstract submission end date">
                    </div>
                    <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                        <?php echo form_error('event_abstract_submission_end_date'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="event_abstract_acceptance_notification" class="col-sm-3 control-label">Abstract Acceptance Notification</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control" name="event_abstract_acceptance_notification" id="event_abstract_acceptance_notification" placeholder="Enter abstract acceptance notification">
                    </div>
                    <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                        <?php echo form_error('event_abstract_acceptance_notification'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="event_paper_submission_notification" class="col-sm-3 control-label">Paper Submission Notification</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control" name="event_paper_submission_notification" id="event_paper_submission_notification" placeholder="Enter paper submission notification">
                    </div>
                    <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                        <?php echo form_error('event_paper_submission_notification'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="event_review_info_avail_after" class="col-sm-3 control-label">Review Info Available After Date</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control" name="event_review_info_avail_after" id="event_review_info_avail_after" placeholder="Enter review info available after date">
                    </div>
                    <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                        <?php echo form_error('event_review_info_avail_after'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="event_clear_min_dues_by" class="col-sm-3 control-label">Clear Min Dues By Date</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control" name="event_clear_min_dues_by" id="event_clear_min_dues_by" placeholder="Enter clear min dues by date">
                    </div>
                    <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                        <?php echo form_error('event_clear_min_dues_by'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="event_email" class="col-sm-3 control-label">Event Email Id</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" name="event_email" id="event_email" placeholder="Enter Event Email">
                    </div>
                    <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                        <?php echo form_error('event_email'); ?>
                    </div>
                </div>

                <div id="new_tracks_list"></div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Add Track</label>
                    <div class="col-sm-9">
                        <div class="input-group contentBlock-top">
                            <button class="btn btn-success btn-sm" type="button" id="but_addTrack">
                                <span class="glyphicon glyphicon-plus"></span>
                            </button>
                            <p class="help-block">Click the add button to add tracks</p>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-6 col-sm-6">
                        <button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>

                <div id="new_track_template" style="display: none;">
                    <div class="form-group new_track" data-sno="-1">
                        <label for="" class="col-sm-3 control-label">
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-danger btn-sm but_remove_track">
                                    <span class="glyphicon glyphicon-minus"></span>
                                </button>
                            </div>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="event_tracks[]" placeholder="Track Name">
                            </div>
                        </label>
                        <div class="col-sm-9 subjects">
                            <div class="subjects_list"></div>
                            <div class="input-group contentBlock-top">
                                <button class="btn btn-success btn-sm but_add_subject" type="button">
                                    <span class="glyphicon glyphicon-plus"></span>
                                </button>
                                <p class="help-block">Click the add button to add subjects to track</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="new_subject_template" style="display: none;">
                    <div>
                        <input type="hidden" class="subject_real_val">
                        <input type="text" placeholder="Subject Name" class="subject_val form-control-static">
                        <button type="button" value="Remove" class="but_remove_subject btn btn-sm btn-danger">
                            <span class="glyphicon glyphicon-minus"></span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function()
    {
        var newTrackHtml = $("#new_track_template").html();
        var newSubjectHtml = $("#new_subject_template").html();
        var sno = 0;
        $("#but_addTrack").click(function()
        {
            $(".new_track", $("#new_track_template")).attr("data-sno", sno++);
            $("#new_tracks_list").append($("#new_track_template").html());
            $(".but_remove_track").off('click');
            $(".but_remove_track").click(function()
            {
                $(this).parentsUntil("#new_tracks_list").remove();
            });
            $(".but_add_subject").off('click');
            $(".but_add_subject").click(function()
            {
                var sno = $(this).parent().parent().parent().attr("data-sno");
                $(".subject_val", $("#new_subject_template")).attr("name", sno + "_subjects[]");
                $('.subjects_list', $(this).parent().parent()).append($("#new_subject_template").html());
                $(".but_remove_subject").off('click');
                $(".but_remove_subject").click(function()
                {
                    $(this).parentsUntil(".subjects_list").remove();
                });
            });
        });
    });
</script>