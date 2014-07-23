<div class="container-fluid">
    <div class="row">
        <div class="col-md-9 col-sm-9 col-xs-12">
            <span class="h3 text-theme">Upload Revision</span>
            <div class="row body-text">
                <div class="col-md-12">
                    <form class="form-horizontal" role="form" enctype="multipart/form-data" action="#" method="post">
                        <div class="form-group">
                            <label for="paper_id" class="col-sm-3 control-label">Paper ID</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="<?php echo set_value('paper_id'); ?>" name="paper_id" id="paper_id" placeholder="Enter paper ID">
                            </div>
                            <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                                <?php echo form_error('paper_id'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="paper_title" class="col-sm-3 control-label">Paper Title</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="<?php echo set_value('paper_title'); ?>" name="paper_title" id="paper_title" placeholder="Enter paper title">
                            </div>
                            <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                                <?php echo form_error('paper_title'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="paper_version" class="col-sm-3 control-label">Paper Version</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="<?php echo set_value('paper_version'); ?>" name="paper_version" id="paper_version" placeholder="Enter paper version">
                            </div>
                            <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                                <?php echo form_error('paper_version'); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="paper_doc" class="col-sm-3 control-label">Upload Paper Version(.docx, .doc)</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="paper_doc" id="paper_doc" placeholder="Choose File">
                            </div>
                            <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                                <?php echo form_error('paper_doc'); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="paper_compliance_doc" class="col-sm-3 control-label">Upload Compliance Report(.docx, .doc)</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="paper_compliance_doc" id="biodata" placeholder="Choose File">
                            </div>
                            <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                                <?php echo form_error('paper_compliance_doc'); ?>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="authors" class="col-sm-3 control-label">Authors</label>
                            <div class="col-sm-9">
                                <p class="help-block">Use Radio button to select one author as Contact Author</p>
                                <div id="authorList">
                                    <div>
                                        <input type="radio" checked name="main_author" class="main_author" value="<?php echo $_SESSION['member_id']; ?>">
                                        <input type="text" name="authors[]" placeholder="Author Id" class="authors" value="<?php echo $_SESSION['member_id']; ?>">
                                    </div>

                                </div>
                                <div class="input-group contentBlock-top">
                                    <button class="btn btn-success btn-sm" type="button" id="but_addAuthor">
                                        <span class="glyphicon glyphicon-plus"></span>
                                    </button>
                                </div>
                            </div>
                            <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                                <?php echo form_error('main_author'); ?>
                            </div>
                            <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                                <?php echo form_error('authors'); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" name="submit" value="submit" class="btn btn-success">Upload</button>
                                <button type="reset" class="btn btn-danger">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function()
    {
        $("#but_addAuthor").click(function()
        {
            var html =  "<div>" +
                "<input type=\"radio\" name=\"main_author\" class=\"main_author\"> " +
                "<input type=\"text\" name=\"authors[]\" class=\"authors\" placeholder=\"Author Id\">" +
                "<button type=\"button\"  value=\"Remove\" class=\"but_remove btn btn-sm btn-danger\">" +
                    "<span class=\"glyphicon glyphicon-minus\">" + "</span>" +
                "</button>" +
                "</div>";
            $("#authorList").append(html);
            $(".but_remove").click(function()
            {
                $(this).parentsUntil("#authorList").remove();
            });
            $('.authors').change(function()
            {
                $(this).prev().val($(this).val());
            });
        });

        $('#events').change(function () {
            var optionSelected = $(this).find("option:selected");
            $('#tracks').empty();
            $('#subjects').empty();
            $('#tracks').append('<option>Select Track</option>');
            $('#subjects').append('<option>Select Subject</option>');
            $.ajax({
                type: "POST",
                url: "http://localhost/Indiacom2015/index.php/Dashboard/tracks",
                data: "eventId="+optionSelected.val(),
                success: function(msg){
                    if(msg != 0)
                    {
                        $('#tracks').append(msg);
                    }

                    else
                    {

                    }
                }
            });
        });

        $('#tracks').change(function () {
            var optionSelected = $(this).find("option:selected");
            $('#subjects').empty();
            $('#subjects').append('<option>Select Subject</option>')
            $.ajax({
                type: "POST",
                url: "http://localhost/Indiacom2015/index.php/Dashboard/subjects",
                data: "trackId="+optionSelected.val(),
                success: function(msg){
                    if(msg != 0)
                    {
                        $('#subjects').append(msg);
                    }
                    else
                    {

                    }
                }
            });
        });
    });
</script>