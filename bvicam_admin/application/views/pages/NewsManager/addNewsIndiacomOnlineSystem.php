<!--<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <form class="form-horizontal" enctype="multipart/form-data" method = "post">
        <div class="row">-->
        <div class="form-group">
            <label for="event" class="col-sm-3 control-label">Event</label>
            <div class="col-sm-6">
                <select id="event" name="event" class="form-control">
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
            </div>
            <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                <?php echo form_error('event'); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="stickyDate" class="col-sm-3 control-label">Sticky Date</label>
            <div class="col-sm-6">
                <input type="date" name = "stickyDate" class="form-control" id="stickyDate">
            </div>
            <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                <?php echo form_error('stickyDate'); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="attachmentUrl" class="col-sm-3 control-label">Upload Attachments</label>
            <div class="col-sm-6">
                <input type="file" name = "attachments[]" class="form-control" id="attachmentUrl" multiple="">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-3 control-label">Attachment Names</label>
            <div class="col-sm-6">
                <div class="form-group">
                    <div class="col-sm-6" id="div_attachments">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-6 col-sm-offset-3">
                <button type="submit" class="btn btn-success">Submit</button>
                <button type="reset" class="btn btn-danger">Clear</button>
            </div>
        </div>
    </form>
</div>

<script>
    $(document).ready(function()
    {
        $("input:file").change(function (){
            var elem = document.getElementById('attachmentUrl');
            $('#div_attachments').empty();
            for(var i=0; i<elem.files.length; i++)
            {
                var inputNode = document.createElement("input");
                inputNode.setAttribute("type", "text");
                inputNode.setAttribute("name", "attachmentNames[]");
                inputNode.setAttribute("class", "form-control");
                inputNode.setAttribute("id", "attachmentName");
                inputNode.setAttribute("placeholder", "Attachment Name");
                inputNode.setAttribute("value", elem.files.item(i).name);

                $('#div_attachments').append(inputNode);
            }
        });
    });
</script>