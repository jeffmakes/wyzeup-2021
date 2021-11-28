<?php 
session_start();
require_once("conf/conf.inc.php");
require_once('dao/school_dao.php');

#Object Instantiation for Scenario typeDAO
$school			  =  new SchoolDO();
$school_dao       =  new SchoolDAO(); 

if(!empty($_POST["txtusername"]) && !empty($_POST["txtpassword"])){	
	$username=$_POST["txtusername"];
	$password=$_POST["txtpassword"];
}else{
	$username=$_POST["memberusername"];
	$password=$_POST["memberpassword"];
}

session_register("session_schoolid");
session_register("session_schoolemail");
session_register("session_schoolname");
session_register("session_schoolpass"); 


$school      =  $school_dao -> School_Search_Single_Record($username,$password);

if($school == NULL) {
  	  html_refresh("login.php?status=invalid");
} else {
		session_register_school();
	
 		$schoolid 						   = $school -> school_id;
		$school_name 			  		   = $school -> school_name;
		$school_email 			  		   = $school -> school_email;
		$school_password 			 	   = $school -> school_password;
		$_SESSION["session_schoolid"]  	   = $schoolid;
		$_SESSION["session_schoolname"]    = $school_name;
		$_SESSION["session_schoolemail"]   = $school_email;
		$_SESSION["session_schoolpass"]    = $school_password;
		html_refresh("myaccount.php?action=view");
}
?>