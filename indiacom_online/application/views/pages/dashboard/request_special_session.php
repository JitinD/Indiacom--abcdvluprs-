<div class="container-fluid contentBlock-top">
    <div class="row">
        <div class="col-md-9 col-sm-9 col-xs-12">
            <span class="h3 text-theme">Request for Special Session</span>
            <div class="row body-text">
				<?php
				if(isset($_SESSION[APPID]['message']))
				{
				?>
				<div class="alert alert-success alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<?php echo $_SESSION[APPID]['message'];
							unset($_SESSION[APPID]['message']); ?>
					</div>
					
					
				<?php
				}
				?>
				<div class="col-md-12">
                    <form class="form-horizontal" role="form" enctype="multipart/form-data" action="#" method="post">

						<div class="form-group">
                            <label for="session_name" class="col-sm-3 control-label">Session Title</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="<?php echo set_value('session_name'); ?>" name="session_name" id="session_name" placeholder="Enter session name">
                            </div>
                            <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                                <?php echo form_error('session_name'); ?>
                            </div>
                        </div>
						
						<div class="form-group">
                            <label for="session_aim" class="col-sm-3 control-label">Session Aim</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="<?php echo set_value('session_aim'); ?>" name="session_aim" id="session_aim" placeholder="Enter session aim">
                            </div>
                            <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                                <?php echo form_error('session_aim'); ?>
                            </div>
                        </div>
						<!--
						<div class="form-group">
                            <label for="aoc" class="col-sm-3 control-label">Areas of Coverage (sub-themes)</label>
                            <div class="col-sm-9" id="aoc">
                                <input type="text" class="aoc form-control" value="<?php echo set_value('aoc[]'); ?>" name="aoc[]" placeholder="Enter area of coverage">
                            </div>
                            <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                                <?php //echo form_error('aoc[]'); ?>
                            </div>
							<div class="col-sm-8 col-sm-offset-3">
                                    <button class="btn btn-success btn-sm" type="button" id="but_addAoc">
                                        <span class="glyphicon glyphicon-plus"></span>
                                    </button>
                            </div>
                        </div>

						<div class="form-group">
                            <label for="tpc" class="col-sm-3 control-label">Enter Names of Technical Programme Committee</label>
                            <div class="col-sm-9" id="tpc">
                                <input type="text" class="tpc form-control" value="<?php echo set_value('tpc[]'); ?>" name="tpc[]" placeholder="Enter Names of Technical Programme Committee">
                            </div>
                            <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                                <?php //echo form_error('tpc[]'); ?>
                            </div>
							<div class="col-sm-8 col-sm-offset-3">
                                    <button class="btn btn-success btn-sm" type="button" id="but_addtpc">
                                        <span class="glyphicon glyphicon-plus"></span>
                                    </button>
                            </div>
                        </div>
						
                        -->

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


<script type="text/javascript">

	    $("#but_addAoc").click(function()
        {
            var html =  "<div>" +
                "<input type=\"text\" name=\"aoc[]\" class=\"form-control\" placeholder=\"Enter area of coverage\">" +
                "<button type=\"button\"  value=\"Remove\" class=\"but_remove btn btn-sm btn-danger\">" +
                    "<span class=\"glyphicon glyphicon-minus\">" + "</span>" +
                "</button>" +
                "</div>";
            $("#aoc").append(html);
            $(".but_remove").click(function()
            {
                $(this).parentsUntil("#aoc").remove();
            });
            $('.aoc').change(function()
            {
                $(this).prev().val($(this).val());
            });
        });
		
		$("#but_addtpc").click(function()
        {
            var html =  "<div>" +
                "<input type=\"text\" name=\"tpc[]\" class=\"form-control\" placeholder=\"Enter Names of Technical Programme Committee\">" +
                "<button type=\"button\"  value=\"Remove\" class=\"but_remove_tpc btn btn-sm btn-danger\">" +
                    "<span class=\"glyphicon glyphicon-minus\">" + "</span>" +
                "</button>" +
                "</div>";
            $("#tpc").append(html);
            $(".but_remove_tpc").click(function()
            {
                $(this).parentsUntil("#tpc").remove();
            });
            $('.tpc').change(function()
            {
                $(this).prev().val($(this).val());
            });
        });
</script>