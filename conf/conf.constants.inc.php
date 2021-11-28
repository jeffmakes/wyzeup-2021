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
/**
* Definitions for Form button
*/
 
define('BUTTON_ADD','Add'); 
define('BUTTON_UPDATE','Update');
define('BUTTON_EDIT','Modify');
define('BUTTON_RESET','Reset'); 
define('BUTTON_DELETE','Delete'); 
define('BUTTON_CHECKOUT','Checkout'); 
define('BUTTON_CONFIRM','Confirm'); 
define('BUTTON_REGISTER','Register');																
define('BUTTON_LOGIN','Login');
define('BUTTON_SUBMIT','Submit');
define('BUTTON_SEARCH','Search');
define('BUTTON_APPROVE','Approve And Activate');
define('BUTTON_DECLINE','Decline');

 
/** Login Error messages**/
define("ERROR_LOGIN_REQUIRED","You have to login to access the admin panel.");
define("ERROR_LOGOUT","You have been successfully logged out.");
define('ERROR_NO_EMAIL','Sorry, the email address you entered is not available in the database.');
define("FORGOT_PASSWORD","Your password has been successfully sent to your email address.");
define('ERROR_PASSWORD_OLD_INVALID','The old password that you entered is invalid.');
define('CHANGE_PASSWORD','Your password was successfully updated.');
define("ERROR_USER_IS_DUPLICATE",'The Staff you have specified already exists!');
define("ERROR_EMAIL_IS_DUPLICATE",'The email ID you have already exists!');
define("ERROR_NAME_IS_DUPLICATE",'The Scenario Name you have specified already exists!');
define("ERROR_QNAME_IS_DUPLICATE",'The Question Name you have specified already exists!');
define("ERROR_SNAME_IS_DUPLICATE",'The School Name you have specified already exists!');
define("ERROR_RANKNAME_IS_DUPLICATE",'The Rank you have specified already assigned!');

#Defining paging constants
define('PAGING_ROWS_PER_PAGE','10');

# Fro PDF Invoice
define('TRANSACTION_AMOUNT',19.95);
define('VAT',0.175);
define('INVOICE_NUMBER',10000);
/*

* Defnitions for Table names
**/
define('TABLE_ADMIN','wyzeup_administrators');
define('TABLE_SCENARIO','wyzeup_scenarios');
define('TABLE_QUESTION','wyzeup_questions');
define('TABLE_USER','wyzeup_users');
define('TABLE_SCHOOL','wyzeup_schools');
define('TABLE_RANK','wyzeup_ranks');
define('TABLE_INVOICE','wyzeup_invoice');

#Defining the Country Names
 $GLOBALS["arrcountries"]      	 = array ( 
									"AL" => "Albania", "DZ" => "Algeria", "AR" => "Argentina","AU" => "Australia", "AT" => "Austria", 
									"BN" => "Bangladesh ", "BE" => "Belgium", "BA" => "Bosnia","BR" => "Brazil", "BG" => "Bulgaria", "BM" => "Burma",
									"KH" => "Cambodia", "CA" => "Canada", "CL" => "Chile", "CN" => "China","CO" => "Colombia","HR" => "Croatia", "CZ" => "Czech Republic", 
									"DK" => "Denmark",
									"EG" => "Egypt", "EE" => "Estonia", 
									"FI" => "Finland","FR" => "France",
									"GH" => "Ghana", "GE" => "Georgia", "DE" => "Germany", "GR" => "Greece", "GT" => "Guatemala", 
									"HL" => "Holland", "HU" => "Hungary", 
									"IS" => "Iceland", "IN" => "India", "ID" => "Indonesia","IR" => "Iran", "IQ" => "Iraq","IE" => "Ireland", "IL" => "Israel", "IT" => "Italy",
									"JP" => "Japan", 
									"KR" => "Korea", 
									"LV" => "Latvia", "LB" => "Lebanon", "LY" => "Libya","LT" => "Lithuania", "LU" => "Luxembourg", 
									"MY" => "Malaysia", "MX" => "Mexico", "MZ" => "Mozambique", 
									"NG" => "Nigeria", "NL" => "Netherlands", "NZ" => "New Zealand", "KP" => "North Korea", "NO" => "Norway",
									"PK" => "Pakistan", "PE" => "Peru", "PH" => "Philippines", "PL" => "Poland","PT" => "Portugal", 
									"RO" => "Romania", "RU" => "Russia", "RW" => "Rwanda", 
									"SB" => "Serbia", "SG" => "Singapore", "SI" => "Slovenia",  "ZA" => "South Africa", "ES" => "Spain","SR" => "Slovak Republic", "SE" => "Sweden", "CH" => "Switzerland", 
									"TW" => "Taiwan", "TH" => "Thailand", "TR" => "Turkey",
									"UA" => "Ukraine", "GB" => "United Kingdom","US" => "United States", 
									"VE" => "Venezuela", "VN" => "Vietnam", 
									"ZW" => "Zimbabwe");
########################################################################################################
?>
