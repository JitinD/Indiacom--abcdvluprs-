<div class="container-fluid">
    <div class="row body-text">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <span class="h3">Requested Special Session</span>
                            

                      <table class="table table-hover">
                      <thead>
                        <tr>
                            <th style="width: 20px;">
                                S. No.
                            </th>
                            <th>
                                Requested Special Sessions
                            </th>
                        </tr>
                      </thead>
                      <tbody>
                            <?php 
                                $counter = 1;

                                if(!empty($special_session)){
                                    foreach($special_session as $spcl){
                                        echo "<tr>
                                            <td>";
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
                                        echo $spcl->title;
                                        echo                "</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Aim
                                                            </td>
                                                            <td>";
                                        echo $spcl->aim;
                                        echo                "</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                About Session Chairperson
                                                            </td>
                                                            <td>";
                                        echo $spcl->profile;
                                        echo                "</td>
                                                        </tr>";
                                        if($spcl->verified){
                                        echo            "<tr>
                                                            <td>
                                                            </td>
                                                            <td>
                                                            <a class='btn btn-primary' href='/".BASEURL."Dashboard/edit_session_Chairperson/".$spcl->sid;
                                        echo                "'>edit profile</a>
                                                            <a class='btn btn-primary' href='/".BASEURL."Dashboard/special_session_details/".$spcl->sid;
                                        echo                "'>view/add details</a>



                                        </td>
                                                        </tr>";
                                        } else{
                                             echo            "<tr>
                                                            <td>
                                                            </td>
                                                            <td>
                                                                This session has not been verified by the authorities, therefore no actions available
                                                            </td>
                                                        </tr>";
                                        }
                                        echo            "</table>
                                                </div>
                                            </td>
                                        </tr>";
                                     }
                                 } else{
                                    echo '<tr>
                                            <td colspan=2>
                                            No sessions requested
                                            </td>
                                        </tr>';
                                 }
                            ?>                          
                      </tbody>
                    </table>
                        
        </div>
    </div>
</div>