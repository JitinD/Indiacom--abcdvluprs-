<div class="container-fluid contentBlock-top">
    <div class="row">
        <div class="col-md-9 col-sm-9 col-xs-12">
            <span class="h3 text-theme">Special Session - Edit Profile</span>
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
                    <form class="form-horizontal" role="form" enctype="multipart/form-data" action="<?php echo $sid;?>" method="post">

						<div class="form-group">
                            <label for="profile" class="col-sm-3 control-label">Profile</label>
                            <div class="col-sm-9">
                                <textarea rows="10" class="form-control" name="profile" id="profile"><?php echo $chairper_profile;?></textarea>
                            </div>
                            <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                                <?php echo form_error('profile'); ?>
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