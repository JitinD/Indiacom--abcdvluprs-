<div class="container-fluid">
    <div class="row body-text">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <span class="h3">Special Session Details</span>
            <br/><br/>
                <a class="btn btn-primary" href="/<?php echo BASEURL?>Dashboard/add_aoc/<?php echo $sid;?>" role="button">Add AOC</a>
                <a class="btn btn-primary" href="/<?php echo BASEURL?>Dashboard/add_tpc/<?php echo $sid;?>" role="button">Add TPC</a>
            <br/>

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