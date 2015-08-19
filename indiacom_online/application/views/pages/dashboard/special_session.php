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
                    <table class="table table-hover">
                      <thead>
                        <tr>
                            <th>
                                Details of Approved Special Sessions
                            </th>
                        </tr>
                      </thead>
                      <tbody>
                            <?php 
                                foreach($special_session as $session){
                                    echo "<tr>
                                        <td>
                                            <div>
                                                <table class='table table-hover'>
                                                    <tr>
                                                        <td>
                                                            Title
                                                        </td>
                                                        <td>";
                                    echo $session->title;
                                    echo                "</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Aim
                                                        </td>
                                                        <td>";
                                    echo $session->aim;
                                    echo                "</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            About Session Chairperson
                                                        </td>
                                                        <td>";
                                    echo $session->profile;
                                    echo                "</td>
                                                    </tr>";
                                    }
                                    ?>
                    </table>

                            <table class="table table-responsive table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Area of Coverage</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(empty($aoc))
                                {
                                    ?>
                                    <tr>
                                        <td colspan="3">
                                            You haven't submitted any area of coverage.
                                        </td>
                                    </tr>
                                <?php
                                } else{
                                ?>
                                <?php
                                    $index = 1;
                                    foreach($aoc as $coverage)
                                    {   
                                        ?>
                                        <tr>
                                            <td><?php echo $index++; ?></td>
                                            <td><?php echo $coverage->name; ?></td>
                                        </tr>
                                    <?php
                                    }
                                }   
                                ?>
                                </tbody>
                            </table>
                        

                            <table class="table table-responsive table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Technical Programmer Committe Member</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(empty($tpc))
                                {
                                    ?>
                                    <tr>
                                        <td colspan="3">
                                            You haven't submitted any tpc yet.
                                        </td>
                                    </tr>
                                <?php
                                } else{
                                ?>
                                <?php
                                    $index = 1;
                                    foreach($tpc as $tpc_person)
                                    {   
                                        ?>
                                        <tr>
                                            <td><?php echo $index++; ?></td>
                                            <td><?php echo $tpc_person->name; ?></td>
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
    </div>
</div>