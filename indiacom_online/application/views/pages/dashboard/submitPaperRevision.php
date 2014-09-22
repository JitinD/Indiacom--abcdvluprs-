<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 7/26/14
 * Time: 9:07 PM
 */
?>

<div class="container-fluid contentBlock-top">
    <div class="row">
        <div class="col-md-9 col-sm-9 col-xs-12">
            <span class="h3 text-theme">Submit Paper Revision</span>
            <div class="row body-text">
                <div class="col-md-12">
                    <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                        <?php if(isset($submitPaperRevisionError)) echo $submitPaperRevisionError; ?>
                    </div>
                    <form class="form-horizontal" role="form" enctype="multipart/form-data" method="post">
                        <div class="form-group">
                            <label for="paper_title" class="col-sm-3 control-label">Paper Title</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="<?php echo $paper_title; ?>" name="paper_title" id="paper_title" readonly>
                            </div>
                            <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="paper_code" class="col-sm-3 control-label">Paper Code</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="<?php echo $paper_code; ?>" name="paper_code" id="paper_title" readonly>
                            </div>
                            <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="paper_version" class="col-sm-3 control-label">Version Number</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="<?php echo $paper_version; ?>" name="paper_version" id="paper_version" readonly>
                            </div>
                            <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="paper_revision_doc" class="col-sm-3 control-label">Upload Paper Revision(.docx, .doc)</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="paper_revision_doc" id="paper_revision_doc" placeholder="Choose File">
                            </div>
                            <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                                <?php
                                if(isset($uploadRevisionError)) echo $uploadRevisionError;
                                ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="compliance_report_doc" class="col-sm-3 control-label">Compliance Report Path(.pdf)</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="compliance_report_doc" id="compliance_report_doc" placeholder="Choose File">
                            </div>
                            <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                                <?php
                                if(isset($uploadReportError)) echo $uploadReportError;
                                ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="authors" class="col-sm-3 control-label">Author Member IDs</label>
                            <div class="col-sm-9">
                                <div id="authorList">
                                <?php
                                    foreach($paper_authors as $author)
                                    {
                                    ?>
                                        <div>
                                            <input type="text" name="authors[]" class="authors" value="<?php echo $author; ?>" readonly>
                                            <?php
                                            if($paper_main_author != $author)
                                            {
                                            ?>
                                                <button type="button" value="<?php echo $author; ?>" class="but_remove btn btn-sm btn-danger"><span class="glyphicon glyphicon-minus"></span></button>
                                            <?php
                                            }
                                            else
                                            {
                                            ?>
                                                Main Author(To remove change main author)
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="input-group contentBlock-top">
                                    <button class="btn btn-success btn-sm" type="button" id="but_addAuthor" click="sam();">
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
                                <button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
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
                "<input type=\"text\" name=\"added_authors[]\" class=\"authors\" placeholder=\"Author Id\">" +
                "<button type=\"button\"  value=\"Remove\" class=\"but_remove btn btn-sm btn-danger\">" +
                "<span class=\"glyphicon glyphicon-minus\">" + "</span>" +
                "</button>" +
                "</div>";
            $("#authorList").append(html);
            $(".but_remove").click(function()
            {
                $(this).parentsUntil("#authorList").remove();
            });
        });
        $(".but_remove").click(function()
        {
            if(confirm("Are you sure you want to remove Member ID " + $(this).val() + " as author?"))
            {
                $(this).parentsUntil("#authorList").remove();
                var html = "<input type=\"hidden\" name=\"removed_authors[]\" value=\"" + $(this).val() + "\">";
                $('#authorList').append(html);
            }
        });
    });
</script>