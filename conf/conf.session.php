<?php
	/*header("Pragma: no-cache");
	session_cache_limiter("nocache");
	session_start();*/
	/**
	 * Register session variables
	 * 
	*/
	function session_register_school() {
		session_register("session_schoolname");
		session_register("session_schoolpass"); 
 		session_register("session_schoolid");
	}
	function session_register_user() {
		session_register("session_username");
		session_register("session_password"); 
 		session_register("session_userid");
	}
	/**
	
	 * UnRegister session variables
	 * 
	*/
	function session_unregister_school() {
		session_unregister("session_schoolname");
		session_unregister("session_schoolpass");
 		session_unregister("session_schoolid");
 		session_destroy();
	}
	function session_unregister_user() {
		session_unregister("session_username");
		session_unregister("session_password");
 		session_unregister("session_userid");
 		session_destroy();
	}
    /**
	 * Check for the Valid user with username and password	 
	 * @ Session variables are used for validations
	 * @Return true on valid user
	*/
    function check_user_exist()
	{ 
		if(isset($_SESSION["session_schoolid"])) {
 			if( (isset($_SESSION["session_schoolid"]) && isset($_SESSION["session_schoolname"]) ) && ($_SESSION["session_schoolid"]!="" && $_SESSION["session_schoolname"]!="")) 
		   {
				$userid        = $_SESSION["session_schoolid"];
				$username 		= get_name(TABLE_SCHOOL,$userid, $field = 'school_name', $index = 'school_id');
				if($username == $_SESSION["session_schoolname"]){
					return true;
			   }
			} else {
				return false;
			}
	   } 
	}
	 /**
	 * Check for the Valid adminuser with username and password	 
	 * @ Session variables are used for validations
	 * @Return true on valid admin user
	*/
    function check_admin_exist()
	{ 
		 
 		if(isset($_SESSION["session_adminid"])) {
 			if((isset($_SESSION["session_adminid"]) && isset($_SESSION["session_adminname"])) && ($_SESSION["session_adminid"]!="" && $_SESSION["session_adminname"]!="")) 
		   {
				$adminid        = $_SESSION["session_adminid"];
				$admin_name 	= get_name(TABLE_ADMIN,$adminid, $field = 'administrator_username', $index = 'administrator_id');
				 
				if($admin_name == $_SESSION["session_adminname"]){
					return true;
			   }
			} 
			else {
				return false;
			}
		}
	}
    
    #Function to destroy the session and logoout
	function logout_user() {
 		session_unregister_user();
		header("Location:".URL_HOME."?status=success");
	}
 	
?>