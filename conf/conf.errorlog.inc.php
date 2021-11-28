<?php
/**
* This is the Website Error Constants File. 
*
* This files holds all the error messages shown on the website.
* It also has the label for various form buttons as well as size for various form controls
*
*/
/**
* Database Abstraction Class.
*
* This class holds all the methods required to perform operations on the database. 
* Currently the abstraction is done only for MySQL.
* @access   public
* @author   Tarun
*/
  
 
 #Defining paging constants
define('ERROR_INVALID_IMAGE','Please select a valid image type');
define('ERROR_CAR_IMAGE_IS_MANDATORY','Please select a  car image');
define('ERROR_CAR_IMAGE_IS_DUPLICATE','The car image already exists');
#admin messages
define('ERROR_SALUTATION_IS_MANDATORY','Please select the salutation.');
define('ERROR_FIRST_NAME_IS_MANDATORY','Please enter the first name.');
define('ERROR_SUR_NAME_IS_MANDATORY','Please enter the sur name.');
define('ERROR_EMAIL_IS_MANDATORY','Please enter the email.');
define('ERROR_INVALID_USERNAME','Invalid username and password. Please try again.');
define('ERROR_INVALID_EMAIL','Please enter valid email id."username@smaple.com"');
define("ERROR_DUPLICATE_RECORD","The email address already exist.");

#content Messages
define('ERROR_PAGETITLE_IS_MANDATORY','Please enter the page title.');
define('ERROR_PAGENAME_IS_MANDATORY','Please enter the page name.');
define('ERROR_PAGECONTENT_IS_MANDATORY','Please enter the page content.');
#Car images
define("ERROR_UPLOAD_FAILURE","There is an error in uploading the car image .Please try again");

 ########################################################################################################
?>
