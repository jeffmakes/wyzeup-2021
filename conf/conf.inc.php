<?php
	header ("Pragma: no-cache");
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	
	require_once("conf.mysql.php");
	require_once("conf.std.php");
	require_once("conf.session.php");
	require_once("conf.errorlog.inc.php");
	require_once("conf.constants.inc.php");


// Local site DB
	/*define('DB_TYPE', 'mysql');							
	//define('DB_URL', '192.168.1.10'); 						
	define('DB_URL', 'localhost'); 						
	define('DB_PORT', '3306');							
	define('DB_USERNAME', 'root');				
//	define('DB_PASSWORD', 'rootanadocs');					
	define('DB_PASSWORD', '');					
	define('DB_NAME', 'wyzeup');	*/
// Live site DB	
	define('DB_URL', 'mysql.wyzeup.dreamhosters.com'); 						
	define('DB_PORT', '3306');							
	define('DB_USERNAME', 'wyzeup_dbuser');				
	define('DB_PASSWORD', 'spinning_disks');					
	define('DB_NAME', 'wyzeup');	
	/**
		* File inclusion
	*/

	#Connection	
	
	$con = mysqli_connect(DB_URL,DB_USERNAME,DB_PASSWORD) or die("Connection Failure");
	mysqli_select_db($con, DB_NAME) or die("DB Error");

	#URL settings

	//define('DB_DSN',"mysql://".DB_USERNAME.":".DB_PASSWORD."@".DB_URL."/".DB_NAME);	
	define('URL_BASE', 'http://www.wyzeup.co.uk/');	# Base URL

	//define('URL_BASE', 'http://192.168.1.4/safe/');	# Base URL
	define('SPREADSHEET_WRITER', ':../library:'); #For PEAR Package
	define('URL_ADMIN', URL_BASE.'controlpanel/');		# Administration URL
	define('URL_ADMIN_LOGIN', URL_ADMIN.'index.php');	# Administration Login URL
	define('URL_ADMIN_LOGIN_REQUIRED', URL_ADMIN.'index.php?status=login');	
	define('URL_LOGIN_REQUIRED','login.php?status=login'); # User login page
	define('URL_LOGOUT','login.php?status=logout');        # User logout page 
	ini_set ( 'max_execution_time', '24000');	
	error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
	if(strpos(strtolower($_SERVER['QUERY_STRING']), "union") || 
			  strpos(strtolower($_SERVER['QUERY_STRING']), "select") || 
			  strpos(strtolower($_SERVER['QUERY_STRING']), "1=0")){
		echo "Invalid Query String. Please click <a href='index.php'>here</a> to navigate to the home page.";
		die();
	}
	
?>
