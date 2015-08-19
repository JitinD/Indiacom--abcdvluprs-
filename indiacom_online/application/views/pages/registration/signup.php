<script src="/<?php echo PATH ?>assets/js/AJAX.js"></script>
<link rel="stylesheet" href="/<?php echo PATH ?>assets/css/AJAXstyle.css">


<div class="row contentBlock-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1 class="text-theme">Member Registration</h1>
        <hr>
        <p class="text-muted body-text">
            Note: The certificate acknowledging your contributions would be generated based on the records submitted
            here by you.
        </p>
    </div>
</div>
<div class="row">
    <div class="col-lg-10 col-md-9 col-sm-9 col-xs-12 well well-sm">
        <form class="form-horizontal" enctype="multipart/form-data" method="post">
            <div class="form-group">
                <label for="salutation" class="col-sm-3 control-label">
                    Salutation *</label>

                <div class="col-sm-3">

                    <?php
                    $salutation = array("Mr", "Ms", "Mrs", "Dr", "Prof");
                    ?>

                    <select id="salutation" name="salutation" class="form-control">
                        <?php
                        foreach ($salutation as $value) {
                            ?>
                            <option
                                value= <?php echo $value ?> <?php if (set_value('salutation') == $value) echo "selected"; ?>><?php echo $value ?></option>
                        <?php
                        }
                        ?>

                    </select>
                </div>
                <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                    <?php echo form_error('salutation'); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-3 control-label">Name *</label>

                <div class="col-sm-9">
                    <input type="text" name="name" maxlength="50" class="form-control"
                           value="<?php echo set_value('name'); ?>" id="name" placeholder="Enter name">
                </div>
                <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                    <?php echo form_error('name'); ?>
                </div>
            </div>

            <div class="form-group">
                <label for="email" class="col-sm-3 control-label">Email *</label>

                <div class="col-sm-9">
                    <input type="email" name="email" class="form-control" value="<?php echo set_value('email'); ?>"
                           id="email" placeholder="Enter email">
                </div>
                <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                    <?php echo form_error('email'); ?>
                </div>
            </div>
            
            <div class="form-group">
                <label for="country" class="col-sm-3 control-label">Country *</label>

                <div class="col-sm-9">
                    <input type="text" name="country" class="form-control" value="<?php echo set_value('country'); ?>"
                           id="country" placeholder="Enter country">
                </div>
                <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                    <?php echo form_error('country'); ?>
                </div>
            </div>

            <div class="form-group">
                <label for="address" class="col-sm-3 control-label">Address *</label>

                <div class="col-sm-9">
                    <textarea name="address" maxlength="100" class="form-control" id="address"
                              placeholder="Enter full address"><?php echo set_value('address'); ?></textarea>
                </div>
                <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                    <?php echo form_error('address'); ?>
                </div>
            </div>
            
            <div class="form-group">
                <label for="city" class="col-sm-3 control-label">City *</label>

                <div class="col-sm-9">
                    <input type="city" name="city" class="form-control" value="<?php echo set_value('city'); ?>"
                           id="city" placeholder="Enter city">
                </div>
                <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                    <?php echo form_error('city'); ?>
                </div>
            </div>
            
            <div class="form-group">
                <label for="pincode" class="col-sm-3 control-label">Pincode</label>

                <div class="col-sm-9">
                    <input type="tel" name="pincode" maxlength="10" class="form-control" id="pincode"
                           value="<?php echo set_value('pincode'); ?>" placeholder="Enter Pincode or Zipcode">
                </div>
                <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                    <?php echo form_error('pincode'); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="telephoneNumber" class="col-sm-3 control-label">Telephone Number *</label>
                <div class="col-sm-2">
                    <div class="input-group">
                      <div class="input-group-addon">+</div>
                        <input type="tel" name="telephoneNumber_country" maxlength="20" class="form-control" id="telephoneNumber_country"
                           value="<?php echo set_value('telephoneNumber_country'); ?>" placeholder="Country Code">
                           
                    </div>
                    <span id="helpBlock" class="help-block">Country Code</span>
                </div>
                <div class="col-sm-2">
                     <input type="tel" name="telephoneNumber_city" maxlength="20" class="form-control" id="telephoneNumber_city"
                           value="<?php echo set_value('telephoneNumber_city'); ?>" placeholder="City Code">
                           <span id="helpBlock" class="help-block">City Code</span>
                </div>
                
                <div class="col-sm-5">
                    <input type="tel" name="telephoneNumber" maxlength="20" class="form-control" id="telephoneNumber"
                           value="<?php echo set_value('telephoneNumber'); ?>" placeholder="Enter Telephone Number">
                           <span id="helpBlock" class="help-block">Telephone Number</span>
                </div>

                <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                    <?php echo form_error('telephoneNumber'); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="mobileNumber" class="col-sm-3 control-label">Mobile Number *</label>

                <div class="col-sm-9">
                    <div class="col-sm-4">
                    <div class="input-group">
                        <div class="input-group-addon">+</div>
                            <input type="tel" name="countryCode" maxlength="5" class="form-control" id="countryCode"
                               value="<?php echo set_value('countryCode'); ?>" placeholder="Country Code">
                        </div>
                        <span id="helpBlock" class="help-block">Country Code</span>
                    </div>
                    <div class="col-sm-8">
                        <input type="tel" name="mobileNumber" maxlength="10" class="form-control" id="mobileNumber"
                               value="<?php echo set_value('mobileNumber'); ?>" placeholder="Enter Mobile Number">
                               <span id="helpBlock" class="help-block">10 digit mobile number</span>
                    </div>
                </div>
                <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                    <?php echo form_error('countryCode'); ?>
                    <?php echo form_error('mobileNumber'); ?>
                </div>
            </div>
            
            <div class="form-group">
                <label for="fax" class="col-sm-3 control-label">Fax Number</label>
                <div class="col-sm-2">
                    <div class="input-group">
                      <div class="input-group-addon">+</div>
                      <input type="tel" name="fax_country" maxlength="3" class="form-control" id="fax_country"
                               value="<?php echo set_value('fax_country'); ?>" placeholder="Country Code">
                    </div>
                </div>
                <div class="col-sm-2">
                    <input type="tel" name="fax_city" maxlength="5" class="form-control" id="fax_city"
                           value="<?php echo set_value('fax_city'); ?>" placeholder="City Code">
                </div>
                
                <div class="col-sm-5">
                    <input type="tel" name="fax" maxlength="20" class="form-control" id="fax"
                           value="<?php echo set_value('fax'); ?>" placeholder="Enter Fax Number">
                </div>
            </div>

            <div class="form-group">
                <label for="biodata" class="col-sm-3 control-label">Biodata</label>

                <div class="col-sm-9">
                    <input type="file" name="biodata" class="form-control" id="biodata" placeholder="Choose File">
                </div>
                <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                    <?php
                    echo form_error('biodata');
                        if (isset($uploadError)) {
                            echo $uploadError;
                            echo "Allowed formats- doc, docx";
                        };
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="ietemembershipno" class="col-sm-3 control-label">IEEE Membership Number</label>

                <div class="col-sm-9">
                    <input type="tel" name="ietemembershipno" maxlength="30" class="form-control" id="ietemembershipno"
                           value="<?php echo set_value('ietemembershipno'); ?>"
                           placeholder="Enter IETE Membership Number">
                </div>
            </div>
            <div class="form-group">
                <label for="csimembershipno" class="col-sm-3 control-label">CSI Membership Number</label>

                <div class="col-sm-9">
                    <input type="tel" name="csimembershipno" maxlength="30" class="form-control" id="csimembershipno"
                           value="<?php echo set_value('csimembershipno'); ?>"
                           placeholder="Enter CSI Membership Number">
                </div>


            </div>

            <div class="form-group">
                <label for="category" class="col-sm-3 control-label">Category *</label>
                
                <div class="col-sm-9">
                    <select name="category" class="form-control" id="category">
                        <?php foreach ($member_categories as $category) {
                            ?>
                            <option
                                value="<?php echo $category->member_category_id ?>" <?php if (set_value('category') == $category->member_category_id) echo "selected"; ?>><?php echo $category->member_category_name ?></option>
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
                <label for="organization" class="col-sm-3 control-label">Organization *</label>

                <div class="col-sm-9">
                    <input type="text" name="organization" autocomplete="off" class="form-control" id="keyword"
                           value="<?php echo set_value('organization'); ?>"
                           placeholder="Start typing name of Organization here">

                    <div id="ajax_response"></div>
                </div>
                <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                    <?php echo form_error('organization'); ?>
                </div>
            </div>

            <div class="form-group">
                <label for="department" class="col-sm-3 control-label">Department *</label>

                <div class="col-sm-9">
                    <input type="text" name="department" class="form-control" id="department"
                           value="<?php echo set_value('department'); ?>" placeholder="Enter your department">
                </div>
                <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                    <?php echo form_error('department'); ?>
                </div>
            </div>

            <div class="form-group category-based">
                <label for="designation" class="col-sm-3 control-label">Designation</label>

                <div class="col-sm-9">
                    <input type="text" name="designation" class="form-control" id="designation"
                           value="<?php echo set_value('designation'); ?>"
                           placeholder="Enter Designation in the Organization">
                </div>
            </div>

            <div class="form-group category-based">
                <label for="experience" class="col-sm-3 control-label">Experience</label>

                <div class="col-sm-9">
                    <input type="text" name="experience" maxlength="2" class="form-control" id="experience"
                           value="<?php echo set_value('experience'); ?>"
                           placeholder="Enter Experience in the Organization">
                </div>
            </div>
            <div class="form-group">
                <label for="captcha" class="col-sm-3 control-label">Captcha</label>

                <div class="col-sm-9">
                    <div class="row">
                        <div class="g-recaptcha" data-sitekey="6LcQQwYTAAAAAIz1OAMs4WX1np0LJfmm_vDCCexw"></div>
                        <div class="col-sm-8 col-sm-offset-4 text-danger h5" id="errorText">
                            <?php echo form_error('g-recaptcha-response'); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-primary">Sign Up</button>
                    <button type="reset" class="btn btn-danger">Reset</button>
                </div>
            </div>

        </form>

    </div>

</div>