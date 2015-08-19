<div class="container-fluid contentBlock-top">
    <div class="row">
        <div class="col-md-9 col-sm-9 col-xs-12">
            <span class="h3 text-theme">Special Session - Add TPC</span>
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
                            <label for="profile" class="col-sm-3 control-label">Add tpc</label>
                            <div class="col-sm-9">
                                <input tpe="text" class="form-control" name="tpc" id="tpc" value="<?php echo set_value('tpc');?>" />
                            </div>
                            <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                                <?php echo form_error('tpc'); ?>
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