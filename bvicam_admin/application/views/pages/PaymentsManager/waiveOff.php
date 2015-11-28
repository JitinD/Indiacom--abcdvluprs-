<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 1/19/15
 * Time: 10:32 AM
 */

?>

<div class="col-sm-12 col-md-12">
    <h1 class="page-header">New WaiveOff</h1>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <form class="form-horizontal" role="form" action="#" method="post">
                <div class="form-group">
                    <label for="waiveOffAmount" class="col-sm-3 control-label">WaiveOff Amount</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="waiveOffAmount" placeholder="Enter waiveoff amount">
                    </div>
                    <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                        <?php /*echo form_error('userName'); */?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="userEmail" class="col-sm-3 control-label">WaiveOff For</label>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="userEmail" class="col-sm-3 control-label">MID</label>
                            <div class="col-sm-4">
                                <?php
                                if(isset($paperMembers))
                                {
                                ?>
                                    <select class="form-control">
                                        <option>Select MID</option>
                                <?php
                                    foreach($paperMembers as $member)
                                    {
                                ?>
                                        <option><?php echo $member->submission_member_id; ?></option>
                                <?php
                                    }
                                ?>
                                    </select>
                                <?php
                                }
                                else
                                {
                                ?>
                                    <input type="text" class="form-control" name="mid[]" placeholder="Enter MID" value="<?php echo $mid; ?>">
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pid" class="col-sm-3 control-label">PID</label>
                            <div class="col-sm-4">
                                <?php
                                if(isset($memberPapers))
                                {
                                    ?>
                                    <select class="form-control">
                                        <option>Select PID</option>
                                        <?php
                                        foreach($memberPapers as $paper)
                                        {
                                            ?>
                                            <option><?php echo $paper->submission_paper_id; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                <?php
                                }
                                else
                                {
                                    ?>
                                    <input type="text" class="form-control" name="mid[]" placeholder="Enter MID" value="<?php echo $pid; ?>">
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="payhead" class="col-sm-3 control-label">Payhead</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="payhead[]">
                                    <option>Select Payhead</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="payhead" class="col-sm-3 control-label">Nationality</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="payhead[]">
                                    <option>Select Nationality</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="payhead" class="col-sm-3 control-label">Registration Category</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="mid[]">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="payhead" class="col-sm-3 control-label">Professional Body Member</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="mid[]">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                        <?php /*echo form_error('userEmail'); */?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-6">
                        <button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>