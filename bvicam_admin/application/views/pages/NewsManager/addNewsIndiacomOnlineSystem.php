<!--<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <form class="form-horizontal" enctype="multipart/form-data" method = "post">
        <div class="row">-->
            <div class="form-group">
            <label for="attachmentName" class="col-sm-3 control-label">Attachment Name</label>
            <div class="col-sm-6">
                <input type="text" name = "attachmentName" class="form-control" id="attachmentName">
            </div>
        </div>
        <div class="form-group">
            <label for="attachmentUrl" class="col-sm-3 control-label">Attachment URL</label>
            <div class="col-sm-6">
                <input type="file" name = "attachmentUrl" class="form-control" id="attachmentUrl">
            </div>
        </div>
        <div class="form-group">
            <label for="stickyDate" class="col-sm-3 control-label">Sticky Date</label>
            <div class="col-sm-6">
                <input type="date" name = "stickyDate" class="form-control" id="stickyDate">
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