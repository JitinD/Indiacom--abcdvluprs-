<script src="/<?php echo PATH ?>assets/js/AJAX.js"></script>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-9 col-sm-9 col-xs-12">
            <span class="h3 text-theme">Edit Profile</span>
            <div class="row body-text">
                <div class="col-md-12">
                    <form class="form-horizontal" enctype="multipart/form-data" method = "post" >
                        <div class="form-group">
                            <label for="salutation"   class="col-sm-3 control-label"><span class="glyphicon glyphicon-asterisk text-danger"></span> Salutation</label>
                            <div class="col-sm-3">
                                <select id="salutation" name="salutation" value="<?php echo $editProfile['member_salutation']; ?>" class="form-control">
                                    <option value="Mr"<?=$editProfile['member_salutation'] == "Mr" ? ' selected="selected"' : ''?>>Mr</option>
                                    <option value="Ms"<?=$editProfile['member_salutation'] == "Ms" ? ' selected="selected"' : ''?>>Ms</option>
                                    <option value="Mrs"<?=$editProfile['member_salutation'] == "Mrs" ? ' selected="selected"' : ''?>>Mrs</option>
                                    <option value="Dr"<?=$editProfile['member_salutation'] == "Dr" ? ' selected="selected"' : ''?>>Dr</option>
                                    <option value="Prof"<?=$editProfile['member_salutation'] == "Prof" ? ' selected="selected"' : ''?>>Prof</option>
                                    <option value="Sir"<?=$editProfile['member_salutation'] == "Sir" ? ' selected="selected"' : ''?>>Sir</option>
                          </select>
                            </div>
                            <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                                <?php echo form_error('name'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-3 control-label"><span class="glyphicon glyphicon-asterisk text-danger"></span> Name</label>
                            <div class="col-sm-9">
                                <input type="text" name = "name" maxlength = "50" class = "form-control" value="<?php echo $editProfile['member_name']; ?>" id="name" placeholder="Enter name">
                            </div>
                            <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                                <?php echo form_error('name'); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-sm-3 control-label"><span class="glyphicon glyphicon-asterisk text-danger"></span> Email</label>
                            <div class="col-sm-9">
                                <input type="email" name = "email" class="form-control" value="<?php echo $editProfile['member_email']; ?>" id="email" placeholder="Enter email">
                            </div>
                            <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                                <?php echo form_error('email'); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address" class="col-sm-3 control-label"><span class="glyphicon glyphicon-asterisk text-danger"></span> Address</label>
                            <div class="col-sm-9">
                                <textarea name = "address" maxlength = "100" class = "form-control" id="address" placeholder="Enter full address"><?php echo $editProfile['member_address']; ?></textarea>
                            </div>
                            <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                                <?php echo form_error('address'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pincode" class="col-sm-3 control-label"><span class="glyphicon glyphicon-asterisk text-danger"></span> Pincode</label>
                            <div class="col-sm-9">
                                <input type="tel" name = "pincode" maxlength = "10" class="form-control" id="pincode" value="<?php echo $editProfile['member_pincode']; ?>" placeholder="Enter Pincode or Zipcode">
                            </div>
                            <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                                <?php echo form_error('pincode'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phoneNumber" class="col-sm-3 control-label"><span class="glyphicon glyphicon-asterisk text-danger"></span> Phone Number</label>
                            <div class="col-sm-9">
                                <input type="tel" name = "phoneNumber" maxlength = "20" class="form-control" id="phoneNumber" value="<?php echo $editProfile['member_phone']; ?>" placeholder="Enter Phone Number">
                            </div>
                            <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                                <?php echo form_error('phoneNumber'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mobileNumber" class="col-sm-3 control-label"><span class="glyphicon glyphicon-asterisk text-danger"></span>Mobile Number</label>
                            <div class="col-sm-9">
                                <div class="col-sm-4">
                                    <input type="tel" name = "countryCode"  maxlength="5" class="form-control" id="countryCode" value="<?php echo $editProfile['member_country_code']; ?>" placeholder="Enter Country Code">
                                </div>
                                <div class="col-sm-8">
                                    <input type="tel" name = "mobileNumber"  maxlength="10" class="form-control" id="mobileNumber" value="<?php echo $editProfile['member_mobile']; ?>" placeholder="Enter Mobile Number">
                                </div>
                            </div>
                            <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                                <?php echo form_error('countryCode'); ?>
                                <?php echo form_error('mobileNumber'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="fax" class="col-sm-3 control-label">Fax Number</label>
                            <div class="col-sm-9">
                                <input type="tel" name = "fax" maxlength = "20" class="form-control" id="fax" value="<?php echo $editProfile['member_fax']; ?>" placeholder="Enter Fax Number">
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="biodata" class="col-sm-3 control-label">Biodata</label>
                            <div class="col-sm-9">
                                <?php
                                if($editProfile['member_biodata_path'] != null)
                                {
                                ?>
                                    <div class="col-sm-4">
                                        <a title="Download Biodata" class="btn btn-primary btn-block" href="/<?php echo $editProfile['member_biodata_path']; ?>" >Download <span class="glyphicon glyphicon-cloud-download"></span> </a>
                                    </div>
                                <?php
                                }
                                ?>
                                <div class="col-sm-8">
                                    <input type="file" name = "biodata" class="form-control" id="biodata" placeholder="Choose File">
                                </div>
                            </div>
                            <!--<div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                                <?php
/*                                echo form_error('biodata');
                                if(isset($uploadError)) echo $uploadError;
                                */?>
                            </div>-->
                        </div>
                        <div class="form-group">
                            <label for="csimembershipno" class="col-sm-3 control-label">CSI Membership Number</label>
                            <div class="col-sm-9">
                                <input type="tel" name = "csimembershipno" maxlength = "30" class="form-control" id="csimembershipno" value="<?php echo $editProfile['member_csi_mem_no']; ?>" placeholder="Enter CSI Membership Number">
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="ietemembershipno" class="col-sm-3 control-label">IETE Membership Number</label>
                            <div class="col-sm-9">
                                <input type="tel" name = "ietemembershipno" maxlength = "30" class="form-control" id="ietemembershipno" value="<?php echo $editProfile['member_iete_mem_no']; ?>" placeholder="Enter IETE Membership Number">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="category" class="col-sm-3 control-label"><span class="glyphicon glyphicon-asterisk text-danger"></span> Category</label>
                            <div class="col-sm-9">
                                <select name = "category" class="form-control" id="category" >
                                    <?php foreach($member_categories as $category)
                                    {
                                        ?>
                                    <option value ="<?php echo $category -> member_category_id ?>" <?=$editProfile['member_category_id'] ==  $category -> member_category_id  ? 'selected="selected"' : ''?>><?php echo $category -> member_category_name ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                                <?php echo form_error('category'); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="organization" class="col-sm-3 control-label"><span class="glyphicon glyphicon-asterisk text-danger"></span> Organization</label>
                            <div class="col-sm-9">
                                <input type="text" name = "organization" autocomplete="off" class="form-control" id="keyword" value="<?php echo $miniProfile['organization_name']; ?>" placeholder="Start typing name of Organization here">
                                <div id="ajax_response"></div>
                            </div>
                            <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                                <?php echo form_error('organization'); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="department" class="col-sm-3 control-label"><span class="glyphicon glyphicon-asterisk text-danger"></span>Department</label>
                            <div class="col-sm-9">
                                <input type="tel" name = "department" class="form-control" id="department" value="<?php echo $editProfile['member_department']; ?>" placeholder="Enter your department">
                            </div>
                            <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                                <?php echo form_error('department'); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="designation" class="col-sm-3 control-label">Designation</label>
                            <div class="col-sm-9">
                                <input type="text" name = "designation" class="form-control" id="designation" value="<?php echo $editProfile['member_designation']; ?>" placeholder="Enter Designation in the Organization">
                            </div>

                        </div>
                            
                        <div class="form-group">
                            <label for="experience" class="col-sm-3 control-label">Experience</label>
                            <div class="col-sm-9">
                                <input type="tel" name = "experience" maxlength = "2" class="form-control" id="experience" value="<?php echo $editProfile['member_experience']; ?>" placeholder="Enter Experience in the Organization">
                            </div>
                        </div>

                        <div class="form-group">
                                <div class="col-sm-6 col-sm-offset-2">
                                    <span class="body-text text-danger">
                                        <?php
                                        if(isset($error))
                                            echo $error;
                                        ?>

                                    </span>
                                </div>

                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-success">Save Changes</button>
                                <button type="reset" class="btn btn-danger">Cancel</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>