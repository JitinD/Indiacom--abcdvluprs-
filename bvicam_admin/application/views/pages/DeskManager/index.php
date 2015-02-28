<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 2/14/15
 * Time: 2:22 PM
 */
?>

<div id="contentPanel" class="col-sm-10 col-md-10">
    <h1 class="page-header">Desk Manager</h1>

    <div class="row">
        <div class="col-md-12">
            <form id="searchByForm" method="post" class="form-inline">
                <div class="form-group">
                    <div class="col-sm-8">
                        <?php
                        $search_parameters = array("MemberID", "PaperID", "MemberName");
                        ?>
                        <div class="btn-group" data-toggle="buttons">
                            <?php
                            foreach ($search_parameters as $parameter) {
                                ?>
                                <label class="btn btn-lg btn-primary">
                                    <input type="radio" class="searchBy" name="searchBy" value="
                        <?php echo $parameter; ?>"
                                        <?php
                                        if (isset($parameter) && $parameter == "MemberID")
                                            echo "checked";
                                        ?>
                                        >
                                    <?php echo $parameter; ?>
                                </label>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <div class="input-group input-group-lg">
                                <input type="text" class=" form-control" name="searchValue" placeholder="Search">

                                <div class="input-group-btn">
                                    <button type="button" id="submitButton" class="btn btn-lg btn-primary">
                                        <i class="glyphicon glyphicon-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>

            </form>
        </div>

    </div>
    <!--    <div class="row">-->
    <!---->
    <!--        <form id="searchByForm" class="form-horizontal" enctype="multipart/form-data" method="post">-->
    <!--            <div class="form-group">-->
    <!--                <label for="searchBy" class="col-sm-3 control-label">Search by</label>-->
    <!---->
    <!--                <div class="col-sm-5">-->
    <!--                    --><?php
    //                    $search_parameters = array("MemberID", "PaperID", "MemberName");
    //                    ?>
    <!--                    <div class="btn-group" data-toggle="buttons">-->
    <!--                        --><?php
    //                        foreach ($search_parameters as $parameter) {
    //                            ?>
    <!--                            <label class="btn btn-primary">-->
    <!--                                <input type="radio" class="searchBy" name="searchBy" value="-->
    <?php //echo $parameter; ?><!--"-->
    <!--                                    --><?php
    //                                    if (isset($parameter) && $parameter == "MemberID")
    //                                        echo "checked";
    //                                    ?>
    <!--                                    >-->
    <!--                                --><?php //echo $parameter; ?>
    <!--                            </label>-->
    <!--                        --><?php
    //                        }
    //                        ?>
    <!--                    </div>-->
    <!---->
    <!--                </div>-->
    <!--            </div>-->
    <!---->
    <!--            <div class="form-group">-->
    <!--                <label for="searchValue" class="col-sm-3 control-label"><span class="glyphicon "></span> Search-->
    <!--                    Value</label>-->
    <!---->
    <!--                <div class="col-sm-5">-->
    <!--                    <input type="text" class="searchValue form-control" name="searchValue" maxlength="50"-->
    <!--                           value="-->
    <?php //echo set_value('searchValue'); ?><!--" id="searchValue" placeholder="Enter value">-->
    <!--                </div>-->
    <!--            </div>-->
    <!--            <div class="form-group">-->
    <!--                <div class="col-sm-offset-3 col-sm-6">-->
    <!--                    <button type="button" id="submitButton" class="btn btn-primary">Submit</button>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--            <div class="col-sm-8 col-sm-offset-2 bg-danger text-danger h2" id="errorText">-->
    <!--                --><?php //echo form_error('searchValue'); ?>
    <!--            </div>-->
    <!--            <div class="col-sm-8 col-sm-offset-2 text-danger bg-danger h2" id="errorText">-->
    <!--                --><?php //echo form_error('searchBy'); ?>
    <!--            </div>-->
    <!--        </form>-->
    <!---->
    <!--    </div>-->


    <div id="memberList">
        <table class="table table-responsive table-hover" id="matchingMemberRecords">
            <thead>
            <tr>
                <th>Member ID</th>
                <th>Member Name</th>
            </tr>
            <tbody>
            </tbody>
            </thead>
        </table>
    </div>

</div>

<script>
    $(document).ready(function () {

        $('#memberList').hide();
        $("input:radio[value = MemberID]").prop('checked', 'checked');

        $('#submitButton').click(function () {

            if ($("input[name=searchBy]:checked").val() == "MemberName") {
                $.ajax({
                    type: "POST",
                    url: "/<?php echo BASEURL; ?>index.php/DeskManager/home",
                    data: "searchBy=MemberName&searchValue=" + $('#searchValue').val(),
                    success: function (records) {
                        if (records != null) {
                            $('#memberList').show();
                            $("#matchingMemberRecords").find('tbody').empty();

                            var obj = jQuery.parseJSON(records);

                            $.each(obj, function (key, value) {
                                $("#matchingMemberRecords").find('tbody').append($('<tr>').append($('<td  class = "member">').text(value.member_id)).append($('<td>').text(value.member_name)));

                            });

                        }

                    }
                });
            }
            else {
                $('#searchByForm').submit();
            }
        });

        $("#searchByForm").keypress(function (e) {
            if (e.which == 13) {
                $("#submitButton").click();
                event.preventDefault();
            }
        });

        $(document).ajaxSuccess(function () {
            $('.member').click(function () {
                var member_id = $(this).text();

                $('#searchValue').val(member_id);
                $("input:radio[value = MemberID]").prop('checked', 'checked');
                //alert($("input[name=searchBy]:checked").val());
                $('#searchByForm').submit();
            });
        });

    });

</script>

