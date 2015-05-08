<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 8/6/14
 * Time: 12:21 AM
 */

include(dirname(__FILE__) . "/../../../global_config/paths.php");

/*
 * End all paths with /
 */

//Upload Folders
define('UPLOAD_FOLDER', 'uploads/');
define('PAPER_FOLDER', 'papers/');
define('CONVENER_REVIEW_FOLDER', 'convener_reviews/');
define('REVIEWER_REVIEW_FOLDER', 'reviewer_reviews/');
define('COMPLIANCE_REPORT_FOLDER', 'compliance_reports/');
define('BIODATA_FOLDER', 'biodata/');
define('TEMP_BIODATA_FOLDER','biodata_temp/');

//Upload base path
define('UPLOAD_PATH', UPLOAD_PATH_PREFIX.UPLOAD_FOLDER);