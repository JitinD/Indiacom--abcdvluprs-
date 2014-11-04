<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <div class="row">
        <div class="col-sm-6">
            <h3 class="text-theme">Reviewer assignment due</h3>
            <table class="table table-striped table-condensed body-text">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Paper Code</th>
                    <th>Title</th>
                    <th>Version number</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(empty($papersWithoutReviewers))
                {
                    ?>
                    <tr>
                        <td colspan="5">
                            No papers without assigned reviewer
                        </td>
                    </tr>
                <?php
                }
                else
                {
                    ?>
                    <?php
                    foreach($papersWithoutReviewers as $index=>$paper)
                    {
                        ?>
                        <tr>
                            <td><?php echo $index+1; ?></td>
                            <td><?php echo $paper->paper_code; ?></td>
                            <td><a href="/<?php echo BASEURL; ?>FinalPaperReviewer/paperInfo/<?php echo $paper->paper_id."/".$paper->paper_version_id; ?>"><?php echo $paper->paper_title; ?></a></td>
                            <td ><?php echo $paper->paper_version_number; ?></td>
                        </tr>
                    <?php

                    }
                }
                ?>
                </tbody>
            </table>
        </div>
        <div class="col-sm-6">
            <h3 class="text-theme">Convener review due</h3>
            <table class="table table-striped table-condensed body-text">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Paper Code</th>
                    <th>Title</th>
                    <th>Version number</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(empty($papersWithConvenerReviewDue))
                {
                    ?>
                    <tr>
                        <td colspan="5">
                            No convener reviews due.
                        </td>
                    </tr>
                <?php
                }
                else
                {
                    ?>
                    <?php
                    foreach($papersWithConvenerReviewDue as $index=>$paper)
                    {
                        ?>
                        <tr>
                            <td><?php echo $index+1; ?></td>
                            <td><?php echo $paper->paper_code; ?></td>
                            <td><a href="/<?php echo BASEURL; ?>FinalPaperReviewer/paperInfo/<?php echo $paper->paper_id."/".$paper->paper_version_id; ?>"><?php echo $paper->paper_title; ?></a></td>
                            <td ><?php echo $paper->paper_version_number; ?></td>
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