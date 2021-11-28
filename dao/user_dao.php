<?php
require_once('../conf/conf.inc.php');
class UserDO {
	var $users_id;
	var $users_fname;
	var $users_lname;
	var $users_email;
	var $users_username;
	var $users_password;
	var $users_status;
 } 

class UserDAO {
 	//Function for Create
	function User_Create(&$user) {
		$error_messages = $this->User_ValidateCreate($user);
		if(!$error_messages) {
			if($user->users_status =='') $user->users_status = 0;
			$insert_query  = 'INSERT into '.TABLE_USER.' (
											users_fname,
											users_lname,
											users_email,
											users_username,
											users_password,
											users_status,
											users_isdeleted									
								 ) VALUES (
								 "'.$user->users_fname.'",
								 "'.$user->users_lname.'",
								 "'.$user->users_email.'",
								 "'.$user->users_username.'",
								 "'.$user->users_password.'",
								 "'.$user->users_status.'",0
							  )';
			db_execute_query($insert_query);		
			}	
			return $error_messages;
	}
	//Function to update the table
	function User_Update($user) {
		$error_messages   = $this->User_ValidateUpdate($user);
		if(!$error_messages){
			if($user->users_status =='') $user->users_status = 0;
			$update_query  = 'UPDATE '.TABLE_USER.' SET
								users_fname         = "'.$user->users_fname.'",
								users_lname			= "'.$user->users_lname.'",
								users_email			= "'.$user->users_email.'",
								users_username		= "'.$user->users_username.'",
								users_password		= "'.$user->users_password.'",
								users_status		= "'.$user->users_status.'"								
							WHERE 
								users_id = '.$user->users_id;										
 			db_execute_query($update_query);
		}
		return $error_messages;
	}
	function User_ValidateUpdate($user) {
		if(check_row_exists_for_row_type_update(TABLE_USER, "users_username", $user->users_username,"users_id",$user->users_id,"users_isdeleted",0)) {
			$error_messages['users_username'] = ERROR_QNAME_IS_DUPLICATE;
	    }
		if(check_row_exists_for_row_type_update(TABLE_USER, "users_email", $user->users_email,"users_id",$user->users_id,"users_isdeleted",0)) {
			$error_messages['users_email'] = ERROR_QNAME_IS_DUPLICATE;
	    }
		/*if(check_row_exists_update(TABLE_USER,'users_username',$user->users_username,'users_id',$user->users_id,'users_isdeleted',0))
	    {
		   $error_messages['users_username'] = ERROR_USER_IS_DUPLICATE;
	    }
	    if(check_row_exists_update(TABLE_USER,'users_email',$user->users_email,'users_id',$user->users_id,'users_isdeleted',0))
	    {
		   $error_messages['users_email'] = ERROR_EMAIL_IS_DUPLICATE;
	    }*/
		
  		return $error_messages;
	}
	//Validation Before Insertion
	function User_ValidateCreate($user) {		
		if(check_row_exists(TABLE_USER,'users_username',$user->users_username,'users_isdeleted',0)){
		   $error_messages['users_username'] = ERROR_USER_IS_DUPLICATE;
	    }	
	    if(check_row_exists(TABLE_USER,'users_email',$user->users_email,'users_isdeleted',0)){
		   $error_messages['users_email'] = ERROR_EMAIL_IS_DUPLICATE;
	    }
		
 		return $error_messages;
	}
	// Delete Process
	function User_Delete(&$userid){
		$delete_query  = 'UPDATE '.TABLE_USER.' SET users_isdeleted  = 1   WHERE users_id ='. $userid;
		db_execute_query($delete_query);
	}
	//Read
	function User_Read(&$userid)  {
			$query_select = "SELECT 
								users_id,
								users_fname,
								users_lname,
								users_email,
								users_username,
								users_password,
								users_status
						 FROM
						 		".TABLE_USER."
						 WHERE 
						 		users_id = ".$userid." AND users_isdeleted=0";
						 //echo $query_select;
		$query_result = db_execute_query($query_select);
		$query_count = db_return_count($query_result);
		if ($query_count == 0) {
			return null;
		}
		$user 		= new UserDO();
		$data       = db_return_object($query_result);  
		
		$user->users_id           	  = $data->users_id;
		$user->users_fname     		  = $data->users_fname;
		$user->users_lname      	  = $data->users_lname;
		$user->users_email    		  = $data->users_email;
		$user->users_username    	  = $data->users_username;
		$user->users_password     	  = $data->users_password;
		$user->users_status        	  = $data->users_status;
		return $user;
	}
	 //List All Users
	 function User_List(&$user)  {
		 $query_select = "SELECT 
		 						users_id,
								users_fname,
								users_lname,
								users_email,
								users_username,
								users_password,
								users_status
						 FROM 
						 		".TABLE_USER."
						 WHERE 
								 users_isdeleted=0";						 
								//  echo '<font color=#FFFFFF>'.$query_select .'</font>';
								  
 		$query_result 	= db_execute_query($query_select);
		$query_count 	= db_return_count($query_result);
		if ($query_count == 0) { return null; }
		
		$user       	 =  new UserDO();
		while($data  = db_return_object($query_result))   {
				$user->users_id           	  = $data->users_id;
				$user->users_fname     		  = $data->users_fname;
				$user->users_lname      	  = $data->users_lname;
				$user->users_email    		  = $data->users_email;
				$user->users_username    	  = $data->users_username;
				$user->users_password     	  = $data->users_password;
				$user->users_status        	  = $data->users_status;				
				$user_list[]             	 = $user;
		 } //End of whileLoop
 		return $user_list;
	}	 
	// Fetching total number of available records
	function User_TotalCount(&$user) {
			    $query_list   = "SELECT 
								users_id,
								users_fname,
								users_lname,
								users_email,
								users_username,
								users_password,
								users_status
						 FROM 
						 		".TABLE_USER."
						 WHERE 
								 users_isdeleted=0";
				$query_result = db_execute_query($query_list);
				$query_count  = db_return_count($query_result);
				return $query_count;
		}
  } //End of DAO Class

?>