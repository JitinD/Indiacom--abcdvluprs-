<?php 
	$track_number = 5;
?>

<div class="container-fluid contentBlock-top">
    <div class="row">
        <div class="col-md-9 col-sm-9 col-xs-12">
            <span class="h3 text-theme">Call for Special Session</span>
            <div class="row body-text">
				<div class="col-md-12">
					<table class="table table-hover">
					  <thead>
						<tr>
							<th>
								S. No.
							</th>
							<th>
								Details of Approved Special Sessions
							</th>
						</tr>
					  </thead>
					  <tbody>
							<?php 
								$counter = 1;
								
								foreach($sessions as $session){
									
									if($session->verified == 1){
										echo "<tr>
											<td>
												";
										echo $track_number;
										echo ".";
										echo $counter++;
										echo "
											</td>
											<td>
												<div>
													<table class='table table-hover'>
														<tr>
															<td>
																Title
															</td>
															<td>";
										echo $session->title;
										echo				"</td>
														</tr>
														<tr>
															<td>
																Aim
															</td>
															<td>";
										echo $session->aim;
										echo				"</td>
														</tr>
														<tr>
															<td>
																Session Chairperson
															</td>
															<td>";
										echo $session->profile;
										echo				"</td>
														</tr>

														<tr>
															<td>
																Organisation
															</td>
															<td>";
										echo $session->organization_name;
										echo				"</td>
														</tr>


														<tr>
															<td>
																Mobile
															</td>
															<td>";
										echo $session->phone;
										echo				"</td>
														</tr>

														<tr>
															<td>
																Email
															</td>
															<td>";
										echo $session->email;
										echo				"</td>
														</tr>
														<tr>
															<td>
																
															</td>
															<td><a class='btn btn-primary' href='\\".BASEURL."Dashboard\special_session\\".$session->sid;
										echo				"'>Click here to know more</a></td>
														</tr>
														
													</table>
												</div>
											</td>
										</tr>";
									}
									if($counter==1){
									echo "	<tr>
												<td>
												</td>
												<td>
													No Approved sessions are there yet 
												</td>
											</tr>";
									}
								}
							?>							
					  </tbody>
					</table>
				</div>
            </div>
        </div>
    </div>
</div>
