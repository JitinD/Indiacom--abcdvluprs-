<div class="col-sm-12 col-md-12" id="contentPanel">
    <h1 class="page-header">View All Special Session Requests<span><a href="load" style="margin-left: 20px;font-size: 20px;">GoBack</a></span></h1>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<table class="table table-hover">
			  <thead>
				<tr>
					<th>
						Requested by
					</th>
					<th>
						title
					</th>
					<th>
						aim
					</th>
					<th>
						Phone
					</th>
				</tr>
			  </thead>
			  <tbody>
				<?php 
				
					foreach($titles as $track){
						echo '<tr>';
						echo '<td>'.$track->name.'</td>';
						echo '<td>'.$track->title.'</td>';
						echo '<td>'.$track->aim.'</td>';
						echo '<td>'.$track->phone.'</td>';
						echo '</tr>';
					}
				?>
			  
			  </tbody>
			</table>           
        </div>
    </div>
</div>