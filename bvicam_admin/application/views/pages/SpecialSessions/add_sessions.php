<div class="col-sm-12 col-md-12" id="contentPanel">
    <h1 class="page-header">Add Special Sesssion Tracks<span><a href="load" style="margin-left: 20px;font-size: 20px;">GoBack</a></span></h1>
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
				<form class="form-horizontal" role="form" action="#" method="post">

					<div class="form-group">
						<label for="track_number" class="col-sm-3 control-label">Track Number</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" value="<?php echo set_value('track_number'); ?>" name="track_number" id="track_number" placeholder="Enter track number">
						</div>
						<div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
							<?php echo form_error('track_number'); ?>
						</div>
					</div>
					
					<div class="form-group">
						<label for="track_name" class="col-sm-3 control-label">Track Name</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" value="<?php echo set_value('track_name'); ?>" name="track_name" id="track_name" placeholder="Enter track name">
						</div>
						<div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
							<?php echo form_error('track_name'); ?>
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