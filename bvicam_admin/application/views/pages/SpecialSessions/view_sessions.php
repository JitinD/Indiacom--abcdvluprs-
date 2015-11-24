<div class="col-sm-12 col-md-12" id="contentPanel">
    <h1 class="page-header">Verify Tracks<span><a href="load" style="margin-left: 20px;font-size: 20px;">GoBack</a></span></h1>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<table class="table table-hover">
			  <thead>
				<tr>
					<th>
						track number
					</th>
					<th>
						track name
					</th>
				</tr>
			  </thead>
			  <tbody>
				<?php 
				
					foreach($titles as $track){
						echo '<tr>';
						echo '<td>'.$track->track_number.'</td>';
						echo '<td>'.$track->track_name.'</td>';
						echo '</tr>';
					}
				?>
			  
			  </tbody>
			</table>           
        </div>
    </div>
</div>