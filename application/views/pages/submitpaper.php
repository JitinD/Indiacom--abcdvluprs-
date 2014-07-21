<div class="container-fluid">
    <div class="row">
        <div class="col-md-9 col-sm-8 col-xs-12 col-md-offset-2 col-sm-offset-2 col-xs-offset-0">
            <span class="h1 text-theme">Submit Paper</span>
            <div class="row body-text">
                <div class="col-md-12">
                    <form class="form-horizontal" role="form" enctype="multipart/form-data" action="#" method="post">
                        <div class="form-group">
                            <label for="paper_title" class="col-sm-3 control-label">Paper Title</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="paper_title" id="paper_title" placeholder="Enter paper title">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="event" class="col-sm-3 control-label">Event</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="event" id="category">

                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="track" class="col-sm-3 control-label">Track</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="track" id="category">

                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="subject" class="col-sm-3 control-label">Subject</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="subject" id="category">

                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="paper_doc" class="col-sm-3 control-label">Upload Paper(.docx, .doc)</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="paper_doc" id="biodata" placeholder="Choose File">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="authors" class="col-sm-3 control-label">Authors</label>
                            <div class="col-sm-9">
                                <div id="authorList">
                                    <div>
                                        <input type="radio" name="mainAuthor">
                                        <input type="text" name="authors" placeholder="Author Name">
                                    </div>
                                </div>
                                <div class="input-group">
                                    <button class="btn btn-success btn-sm" type="button" id="but_addAuthor">
                                        <span class="glyphicon glyphicon-plus"></span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
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
                "<input type=\"radio\" name=\"mainAuthor\"> " +
                "<input type=\"text\" placeholder=\"Author Name\">" +
                "<button type=\"button\"  value=\"Remove\" class=\"but_remove btn btn-sm btn-danger\">" +"<span class=\"glyphicon glyphicon-minus\">"+"</span>" + "</button>"
                "</div>";
            $("#authorList").append(html);
            $(".but_remove").click(function()
            {
                $(this).parentsUntil("#authorList").remove();
            });
        });
    });
</script>