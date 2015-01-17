<!--<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h3 class="text-theme">Papers Assigned</h3>
    <table class="table table-hover table-striped body-text">
        <thead>
        <tr>
            <th>#</th>
            <th>Code</th>
            <th>Title</th>
            <th>Version number</th>
        </tr>
        </thead>
        <tbody>
        <?php
/*            if(empty($papers))
            {
                */?>
                <tr>
                    <td colspan="5">
                        No papers assigned yet.
                    </td>
                </tr>
            <?php
/*            }
            else
            {
            */?>
            <?php
/*                foreach($papers as $index=>$paper)
                {
                    */?>
                    <tr>
                        <td><?php /*echo $index+1; */?></td>
                        <td><?php /*echo $paper->paper_code; */?></td>
                        <td><a href="/<?php /*echo BASEURL; */?>FinalPaperReviewer/paperInfo/<?php /*echo $paper->paper_id."/".$paper->paper_version_id; */?>"><?php /*echo $paper->paper_title; */?></a></td>
                        <td ><?php /*echo $paper->paper_version_number; */?></td>
                    </tr>
            <?php
/*
                }
            }
            */?>
        </tbody>
    </table>
</div>
-->

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h3 class="text-theme">Papers Assigned</h3><br/>

    <ul id="Tabs" class="nav nav-tabs">

        <li class="active">
            <a href="#NRA" data-toggle="tab">
                No Reviewer Assigned
            </a>
        </li>

        <li>
            <a href="#PR" data-toggle="tab">
                Papers Reviewed
            </a>
        </li>

        <li>
            <a href="#PNR" data-toggle="tab">
                Papers Not Reviewed
            </a>
        </li>
        <li>
            <a href="#RS" data-toggle="tab">
                Reviews Sent
            </a>
        </li>

    </ul><br/>

    <div id="TabContents" class="tab-content">

        <div class="tab-pane fade in active" id="NRA">

            <table class="table table-hover table-striped body-text">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Code</th>
                        <th>Title</th>
                        <th>Version number</th>
                    </tr>
                </thead>

                <tbody>
                    <?php

                        if(empty($no_reviewer_papers))
                        {
                            ?>
                            <tr>
                                <td colspan="5">
                                    No papers assigned yet.
                                </td>
                            </tr>
                        <?php
                        }
                        else
                        {
                            foreach($no_reviewer_papers as $index=>$paper)
                            {
                        ?>
                                <tr>
                                    <td><?php echo $index+1; ?></td>
                                    <td><?php echo $paper->paper_code; ?></td>
                                    <td><a href="/<?php echo BASEURL; ?>FinalPaperReviewer/paperInfo/<?php echo $paper->paper_id."/".$paper->paper_version_id; ?>"><?php echo $paper->paper_title; ?></a></td>
                                    <td><?php echo $paper->paper_version_number; ?></td>
                                </tr>
                            <?php

                            }
                        }
                    ?>
                </tbody>

            </table>

        </div>

        <div class="tab-pane fade" id="PR">

            <table class="table table-hover table-striped body-text">

                <thead>
                <tr>
                    <th>#</th>
                    <th>Code</th>
                    <th>Title</th>
                    <th>Version number</th>
                </tr>
                </thead>

                <tbody>
                    <?php

                    if(empty($reviewed_papers))
                    {
                        ?>
                        <tr>
                            <td colspan="5">
                                No papers assigned yet.
                            </td>
                        </tr>
                    <?php
                    }
                    else
                    {
                        foreach($reviewed_papers as $index=>$paper)
                        {
                            ?>
                            <tr>
                                <td><?php echo $index+1; ?></td>
                                <td><?php echo $paper->paper_code; ?></td>
                                <td><a href="/<?php echo BASEURL; ?>FinalPaperReviewer/paperInfo/<?php echo $paper->paper_id."/".$paper->paper_version_id; ?>"><?php echo $paper->paper_title; ?></a></td>
                                <td><?php echo $paper->paper_version_number; ?></td>
                            </tr>
                        <?php

                        }
                    }
                    ?>
                </tbody>

            </table>


        </div>

        <div class="tab-pane fade" id="PNR">

            <table class="table table-hover table-striped body-text">

                <thead>
                <tr>
                    <th>#</th>
                    <th>Code</th>
                    <th>Title</th>
                    <th>Version number</th>
                </tr>
                </thead>

                <tbody>
                    <?php

                    if(empty($not_reviewed_papers))
                    {
                        ?>
                        <tr>
                            <td colspan="5">
                                No papers assigned yet.
                            </td>
                        </tr>
                    <?php
                    }
                    else
                    {
                        foreach($not_reviewed_papers as $index=>$paper)
                        {
                            ?>
                            <tr>
                                <td><?php echo $index+1; ?></td>
                                <td><?php echo $paper->paper_code; ?></td>
                                <td><a href="/<?php echo BASEURL; ?>FinalPaperReviewer/paperInfo/<?php echo $paper->paper_id."/".$paper->paper_version_id; ?>"><?php echo $paper->paper_title; ?></a></td>
                                <td><?php echo $paper->paper_version_number; ?></td>
                            </tr>
                        <?php

                        }
                    }
                    ?>
                </tbody>

            </table>


        </div>

        <div class="tab-pane fade" id="RS">

            <table class="table table-hover table-striped body-text">

                <thead>
                <tr>
                    <th>#</th>
                    <th>Code</th>
                    <th>Title</th>
                    <th>Version number</th>
                </tr>
                </thead>

                <tbody>
                <?php

                if(empty($convener_reviewed_papers))
                {
                    ?>
                    <tr>
                        <td colspan="5">
                            No papers assigned yet.
                        </td>
                    </tr>
                <?php
                }
                else
                {
                    foreach($convener_reviewed_papers as $index=>$paper)
                    {
                        ?>
                        <tr>
                            <td><?php echo $index+1; ?></td>
                            <td><?php echo $paper->paper_code; ?></td>
                            <td><a href="/<?php echo BASEURL; ?>FinalPaperReviewer/paperInfo/<?php echo $paper->paper_id."/".$paper->paper_version_id; ?>"><?php echo $paper->paper_title; ?></a></td>
                            <td><?php echo $paper->paper_version_number; ?></td>
                        </tr>
                    <?php

                    }
                }
                ?>
                </tbody>

            </table>


        </div>

    </div>

</div>

<script>
    $(document).ready(function()
    {
        $('tr').on("click", function() {
            if($(this).attr('href') !== undefined){
                document.location = $(this).attr('href');
            }
        });
    });
</script>
