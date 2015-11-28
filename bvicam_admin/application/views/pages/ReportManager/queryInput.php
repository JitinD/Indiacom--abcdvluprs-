<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 2/18/15
 * Time: 8:07 PM
 */
?>
<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">Reports Manager</h1>

        <p>
            Enter a SQL query, and hit Submit.
        </p>

        <form class="form-horizontal" enctype="multipart/form-data" method="post">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="comment">Query:</label>
                    <textarea class="form-control" rows="5" id="query" name="query"></textarea>

                    <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                        <?php echo form_error('query'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>


            </div>
        </form>

    </div>

</div>
<div>

    <?php if (isset($error)&&$error == 0) {
        echo "Only select queries allowed";
    }
    ?>
</div>
</div>
