<div class="container-fluid">
    <div class="row">
        <div class="col-md-9 col-sm-8 col-xs-12 col-md-offset-2 col-sm-offset-2 col-xs-offset-0">
            <span class="h1 text-theme">Submit Paper</span>
            <div class="row body-text">
                <div class="col-md-12">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label for="name" class="col-sm-3 control-label">Paper Title</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="paper_title" placeholder="Enter paper title">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-3 control-label">Event</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="category">

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-3 control-label">Track</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="category">

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-3 control-label">Subject</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="category">

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="biodata" class="col-sm-3 control-label">Upload Paper(.docx, .doc)</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" id="biodata" placeholder="Choose File">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="biodata" class="col-sm-3 control-label">Authors</label>
                            <div class="col-sm-9">
                                <div id="authorList">
                                    <div>
                                        <input type="radio" name="mainAuthor">
                                        <input type="text" placeholder="Author Name">
                                    </div>
                                </div>
                                <div class="input-group">

                                    <button class="btn btn-success btn-sm" type="button" id="but_addAuthor"><span class="glyphicon glyphicon-plus"></span> Add Author</button>
                                </div>
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
                "<button type=\"button\"  value=\"Remove\" class=\"but_remove btn btn-sm btn-danger\">" +"<span class=\"glyphicon glyphicon-minus\">"+"</span>"+"Remove" + "</button>"
                "</div>";
            $("#authorList").append(html);
            $(".but_remove").click(function()
            {
                $(this).parentsUntil("#authorList").remove();
            });
        });
    });
</script>