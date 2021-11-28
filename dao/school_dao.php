<?php
/**
* This is the database access file for . 
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
*/

class SchoolDO {
	var $school_id;
	var $school_name;
	var $school_password;
	var $school_contactname;
	var $school_contactperson_position;
	var $school_startdate;
	var $school_enddate;
	var $school_address;
	var $school_email;
	var $school_invoice_to;
	var $school_proforma_invoice;
	var $school_phone;	
	var $school_status;	
 } 
class SchoolDAO {
 	//Function for Create
	function School_Create(&$school) {
		$error_messages = $this->School_ValidateCreate($school);
		if(!$error_messages) {
			$insert_query  = 'INSERT into '.TABLE_SCHOOL.' (
											school_name,
											school_password,
											school_contactname,
											school_contactperson_position,
											school_startdate,
											school_enddate,
											school_expirydate,
											school_address1,
											school_address2,
											school_city,
											school_country,
											school_zipcode,
											school_email,
											school_invoice_to,
											school_proforma_invoice,
											school_phone,
											school_status,
											school_isdeleted									
								 ) VALUES (
								 "'.addslashes($school->school_name).'",
								 "'.$school->school_password.'",
								 "'.addslashes($school->school_contactname).'",
								 "'.addslashes($school->school_contactperson_position).'",
								 "'.$school->school_startdate.'",
								 "'.$school->school_enddate.'",
								 "'.$school->school_expirydate.'",
								 "'.addslashes($school->school_address1).'",
								 "'.addslashes($school->school_address2).'",
								 "'.$school->school_city.'",
								 "'.$school->school_country.'",
								 "'.$school->school_zipcode.'",
								 "'.$school->school_email.'",
								 "'.addslashes($school->school_invoice_to).'",
								 "'.addslashes($school->school_proforma_invoice).'",
								 "'.$school->school_phone.'",
								  "'.$school->school_status.'", 0
							  )';
					db_execute_query($insert_query);		
					$db_insert_id 	= mysql_insert_id();
			}
			if($error_messages)
				return $error_messages;
			else
				return $db_insert_id;
	}
	
	
	//Function for Create schools from front end
	function School_Create_Public(&$school) {
		$error_messages = $this->School_ValidateCreate($school);
		if(!$error_messages) {
			$insert_query  = 'INSERT into '.TABLE_SCHOOL.' (
											school_name,
											school_password,
											school_contactname,
											school_contactperson_position,
											school_startdate,
											school_enddate,
											school_expirydate,
											school_address1,
											school_address2,
											school_city,
											school_country,
											school_zipcode,
											school_email,
											school_invoice_to,
											school_proforma_invoice,
											school_phone,
											school_status,
											school_isdeleted									
								 ) VALUES (
								 "'.addslashes($school->school_name).'",
								 "'.$school->school_password.'",
								 "'.addslashes($school->school_contactname).'",
								 "'.addslashes($school->school_contactperson_position).'",
								 "'.$school->school_startdate.'",
								 "'.$school->school_enddate.'",
								 "'.$school->school_expirydate.'",
								 "'.addslashes($school->school_address1).'",
								 "'.addslashes($school->school_address2).'",
								 "'.$school->school_city.'",
								 "'.$school->school_country.'",
								 "'.$school->school_zipcode.'",
								 "'.$school->school_email.'",
								 "'.addslashes($school->school_invoice_to).'",
								 "'.addslashes($school->school_proforma_invoice).'",
								 "'.$school->school_phone.'",
								 0, 0
							  )';
					db_execute_query($insert_query);		
					$db_insert_id 	= mysql_insert_id();
					$error_messages = $this->School_InvoiceCreate($school,$db_insert_id);
			}
			//return $error_messages;
			if($error_messages)
					return $error_messages;
			 else
					return $db_insert_id;
	}
	
	
	function School_InvoiceCreate(&$school,$schoolid) {

			$insert_query  = 'INSERT into '.TABLE_INVOICE.' (
											invoice_number,
											invoice_amount,
											invoice_school_fk_id,
											invoice_address1,
											invoice_address2,
											invoice_city,
											invoice_country,
											invoice_date,											
											invoice_isdeleted									
								 ) VALUES (
								 "'.$school->invoice_number.'",
								 "'.$school->invoice_amount.'",
								 "'.$schoolid.'",								
								 "'.addslashes($school->school_address1).'",
								 "'.addslashes($school->school_address2).'",
								 "'.$school->school_city.'",
								 "'.$school->school_country.'",
								 "'.$school->school_startdate.'", 0
							  )';
				db_execute_query($insert_query);		
				$db_insert_id1	= mysql_insert_id();
			
	}
	
	
	//Function to update the table
	function School_Update($school) {
		$error_messages   = $this->School_ValidateUpdate($school);
		if(!$error_messages){
			 $update_query  = 'UPDATE '.TABLE_SCHOOL.' SET
								school_name    		 			  = "'.addslashes($school->school_name).'",
								school_contactname	 			  = "'.addslashes($school->school_contactname).'",
								school_contactperson_position	  = "'.addslashes($school->school_contactperson_position).'",
								school_startdate 	 			  = "'.$school->school_startdate.'",
								school_enddate	 	 			  = "'.$school->school_enddate.'",
								school_expirydate 	 			  = "'.$school->school_expirydate.'",
								school_address1	 				  = "'.addslashes($school->school_address1).'",
								school_address2	 				  = "'.addslashes($school->school_address2).'",
								school_city	 		 			  = "'.$school->school_city.'",
								school_country	 	 			  = "'.$school->school_country.'",
								school_zipcode	 	 			  = "'.$school->school_zipcode.'",
								school_email	 				  = "'.$school->school_email.'",
								school_invoice_to 				  = "'.addslashes($school->school_invoice_to).'",
								school_proforma_invoice			  = "'.addslashes($school->school_proforma_invoice).'",
								school_phone	 				  = "'.$school->school_phone.'",
								school_status	 				  = "'.$school->school_status.'"
							WHERE 
								school_id = '.$school->school_id;			
 			db_execute_query($update_query);  //($to, $username, $pass,$subject)
			$dt	   = date("Y-m-d");
			//$mail = Sendmail_30Day_before($dt);
			/*if($school->school_status ==1){
				$send_email = $this->SendMail($school->school_email,$school->school_contactname,$school->school_email,$school->school_password,'Your School Email Activation Details');	
			}		*/		
		}
		return $error_messages;
	}
	
	function School_Update_decline($school) {
			$update_query  = 'UPDATE '.TABLE_SCHOOL.' SET
								school_status               = 2
 							 WHERE 
								school_id = '.$school->school_id;										
			db_execute_query($update_query);
			return $error_messages;
	}
	function School_Update_delete($school) {
			$delete_query  = 'DELETE FROM  '.TABLE_SCHOOL.' WHERE school_id = '.$school->school_id;										
			db_execute_query($delete_query);
			return $error_messages;
	}
	
	function School_ValidateUpdate($school) 
	{  
	  if($school->school_name == "" || !isset($school->school_name)) {
			$error_messages['school_name'] = 'enter the school name';
	  }
		if($school->school_contactname == "" || !isset($school->school_contactname)) {
			$error_messages['school_contactname'] = 'enter the contact person ';
		}
	  if($school->school_contactperson_position == "" || !isset($school->school_contactperson_position)) {
			$error_messages['school_contactperson_position'] = 'enter the position';
	  }
	 /* if(!validate_date($school->school_startdate,'-')){
			$error_messages['school_startdate'] = 'enter the valid Start date';
	  }
	  if(!validate_date($school->school_enddate,'-')){
			$error_messages['school_enddate'] = 'enter the valid End date';
	  }
	  if(CompareDate($school->school_startdate,$school->school_enddate)){
			$error_messages['school_compdate'] = 'End date is smaller than Start date';
	  }*/
	  if($school->school_address1 == "" || !isset($school->school_address1)) {
			$error_messages['school_address1'] = 'enter the address1';
		}
		/*if($school->school_address2 == "" || !isset($school->school_address2)) {
			$error_messages['school_address2'] = 'enter the address2';
		}*/
		if($school->school_city == "" || !isset($school->school_city)) {
			$error_messages['school_city'] = 'enter the City';
		}
		if($school->school_country == "0") { 
			$error_messages['school_country'] = 'select the country';
		}
		if($school->school_zipcode == "" || !isset($school->school_zipcode)) {
			$error_messages['school_zipcode'] = 'enter the postcode';
		}
	  if($school->school_invoice_to == "" || !isset($school->school_invoice_to)) {
			$error_messages['school_invoice_to'] = 'enter the invoice to';
	  }
	  if($school->school_proforma_invoice == "" || !isset($school->school_proforma_invoice)) {
			$error_messages['school_proforma_invoice'] = 'enter the proforma invoice';
	  }
	  if($school->school_email == "" || !isset($school->school_email)) {
			$error_messages['school_email'] = 'enter E-Mail id';
		}
		if (eregi("^[a-zA-Z0-9_]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$]", $school->school_email)) 
		{
		  $error_messages['school_email'] = 'enter valid Email Id';
		}
		if($school->school_phone == "" || !isset($school->school_phone)) {
			$error_messages['school_phone'] = 'enter the phone';
		}
//			if(check_row_exists_for_row_type_update('tblmember','member_email',addslashes($member->member_email),'member_pk_id',$member->member_pk_id,'member_isdeleted',0))			{

	  if(check_row_exists_for_row_type_update(TABLE_SCHOOL,'school_email',addslashes($school->school_email),'school_id',$school->school_id,'school_isdeleted',0))
	    {
		   $error_messages['school_email'] = ERROR_EMAIL_IS_DUPLICATE;
	    }
  		return $error_messages;
	}
	//Validation Before Insertion
	function School_ValidateCreate($school) {		
		if($school->school_name == "" || !isset($school->school_name)) {
			$error_messages['school_name'] = 'enter the School name';
		}
		if($school->school_contactname == "" || !isset($school->school_contactname)) {
			$error_messages['school_contactname'] = 'enter the Contact person name';
		}
		if($school->school_contactperson_position == "" || !isset($school->school_contactperson_position)) {
			$error_messages['school_contactperson_position'] = 'enter the Contact person position';
		}
		if($school->school_password == "" || !isset($school->school_password)) { 
			$error_messages['school_password'] = 'enter the password';
		}
		if($school->frontend =='front'){
			if($school->school_confirm_password == "" || !isset($school->school_confirm_password)) {
				$error_messages['school_confirm_password'] = 'enter the confirm password';
			}
			
			#Check for the match of password and confirm password
			if($school->school_password && $school->school_confirm_password && ($school->school_password != $school->school_confirm_password)) {
				$error_messages['school_password_mismatch'] = 'passwords do not match';
			}
		}
		
		/*if($school->school_startdate == "" || !isset($school->school_startdate)) {
			$error_messages['school_startdate'] = 'enter the Start date';
		}
		if(!validate_date($school->school_startdate,'-')){
			$error_messages['school_startdate'] = 'enter the valid Start date';
		}
		if($school->school_enddate == "" || !isset($school->school_enddate)) {
			$error_messages['school_enddate'] = 'enter the End date';
		}
		if(!validate_date($school->school_enddate,'-')){
			$error_messages['school_enddate'] = 'enter the valid End date';
		}
		if(CompareDate($school->school_startdate,$school->school_enddate)){
			$error_messages['school_compdate'] = 'End date is smaller than Start date';
		}*/
		if($school->school_address1 == "" || !isset($school->school_address1)) {
			$error_messages['school_address1'] = 'enter the Address1';
		}
		/*if($school->school_address2 == "" || !isset($school->school_address2)) {
			$error_messages['school_address2'] = 'enter the Address2';
		}*/
		if($school->school_city == "" || !isset($school->school_city)) {
			$error_messages['school_city'] = 'enter the City';
		}
		if($school->school_country == "0") { 
			$error_messages['school_country'] = 'select the Country';
		}
		if($school->school_zipcode == "" || !isset($school->school_zipcode)) {
			$error_messages['school_zipcode'] = 'enter the postcode';
		}
		if($school->school_email == "" || !isset($school->school_email)) {
			$error_messages['school_email'] = 'enter E-Mail id';
		}
		if($school->school_email != ""){
			$retunvalue = email_validate($school->school_email);
			if($retunvalue == 1){
				$error_messages['school_email_id'] = 'enter valid Email Id';
			}
//			echo $retunvalue;die();
			//if (eregi("^[a-zA-Z0-9_]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$]", $school->school_email)) 
			/*if  (!eregi("^[a-z]+[a-z0-9_-]*(([.]{1})|([a-z0-9_-]*))[a-z0-9_-]+[@]{1}[a-z0-9_-]+[.](([a-z]{2,3})|([a-z]{3}[.]{1}[a-z]{2}))+[.](([a-z]{2,3})|([a-z]{3}[.]{1}[a-z]{2}))$",$school->school_email))// || (!eregi("^[a-zA-Z0-9_]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$]",$school->school_email)) )
			{
			  $error_messages['school_email_id'] = 'enter valid Email Id';
			}else if(!eregi("^[a-z]+[a-z0-9_-]*(([.]{1})|([a-z0-9_-]*))[a-z0-9_-]+[@]{1}[a-z0-9_-]+[.](([a-z]{2,3})|([a-z]{3}[.]{1}[a-z]{2}))$",$school->school_email))
			{
				$error_messages['school_email_id1'] = 'enter valid Email Id';
			}*/
		}
		if($school->school_invoice_to == "" || !isset($school->school_invoice_to)) {
			$error_messages['school_invoice_to'] = 'enter the Invoice to';
		}
		if($school->school_proforma_invoice == "" || !isset($school->school_proforma_invoice)) {
			$error_messages['school_proforma_invoice'] = 'enter the proforma invoice';
		}
		if($school->school_phone == "" || !isset($school->school_phone)) {
			$error_messages['school_phone'] = 'enter the Phone';
		}
	   /* if(check_row_exists(TABLE_SCHOOL,'school_email',$school->school_email,'school_isdeleted',0)){
		   $error_messages['school_email'] = ERROR_EMAIL_IS_DUPLICATE;
	    }	*/
		 if(check_row_exists_two(TABLE_SCHOOL,'school_email',$school->school_email,'school_status',0,'school_isdeleted',0)){
		   $error_messages['school_email'] = ERROR_EMAIL_IS_DUPLICATE;
	    }	
 		return $error_messages;
	}
	// Delete Process
	function School_Delete(&$schoolid){
		$delete_query  = 'UPDATE '.TABLE_SCHOOL.' SET school_isdeleted  = 1   WHERE school_id ='. $schoolid;
		db_execute_query($delete_query);
	}
	//Read
	function School_Read(&$schoolid)  {
			$query_select = "SELECT 
								school_id,
								school_name,
								school_password,
								school_contactname,
								school_contactperson_position,
								DATE_FORMAT(school_startdate,'%d-%m-%Y') as school_startdate,
								DATE_FORMAT(school_enddate,'%d-%m-%Y') as school_enddate,
								DATE_FORMAT(school_expirydate,'%d-%m-%Y') as school_expirydate,
								school_address1,
								school_address2,
								school_city,
								school_country,
								school_zipcode,
								school_email,
								school_invoice_to,
								school_proforma_invoice,
								school_phone,								
								school_status
						 FROM
						 		".TABLE_SCHOOL."
						 WHERE 
						 		school_id = ".$schoolid." AND school_isdeleted=0";
						 //echo $query_select;
		$query_result = db_execute_query($query_select);
		$query_count = db_return_count($query_result);
		if ($query_count == 0) {
			return null;
		}
		$school 		= new SchoolDO();
		$data      		= db_return_object($query_result);  
		
		$school->school_id           	 		 = $data->school_id;
		$school->school_name     				 = stripslashes($data->school_name);
		$school->school_password   		 		 = $data->school_password;
		$school->school_contactname      		 = stripslashes($data->school_contactname);		
		$school->school_contactperson_position  = stripslashes($data->school_contactperson_position);
		$school->school_startdate    	 		= $data->school_startdate;
		$school->school_enddate	    	  		= $data->school_enddate;
		$school->school_expirydate    	  = $data->school_expirydate;
		$school->school_address1	      		= stripslashes($data->school_address1);		
		$school->school_address2		  		= stripslashes($data->school_address2);
		$school->school_city    		  		= $data->school_city;
		$school->school_country    		  		= $data->school_country;
		$school->school_zipcode    		  		= $data->school_zipcode;
		$school->school_email    		  		= $data->school_email;
		$school->school_invoice_to		  		= stripslashes($data->school_invoice_to);
		$school->school_proforma_invoice  		= stripslashes($data->school_proforma_invoice);
		$school->school_phone    		  		= $data->school_phone;				
		$school->school_status        	  		= $data->school_status;
		return $school;
	}
	//Search
	function School_Search_Single_Record($searchstring1,$searchstring2)   {

		/*$stored_value  = get_name(TABLE_SCHOOL, $searchstring1, 'school_password',  'school_email');
		$searchstring2 = pw_check($searchstring2,$stored_value);*/
			
		$query_select = "SELECT school_id,school_name,school_password,school_contactname,school_contactperson_position,
								school_startdate,school_enddate,school_expirydate,school_address1,school_address2,school_city,
								school_country,	school_zipcode,school_email,school_invoice_to,school_proforma_invoice,school_phone,school_status						
						 FROM ".TABLE_SCHOOL."
						 WHERE  school_status = 1 AND school_expirydate >= CURDATE() AND school_email  LIKE BINARY  '".$searchstring1."' AND
						        school_password  LIKE BINARY  '".$searchstring2."' AND school_isdeleted = 0";
		
		$query_result 	= db_execute_query($query_select);
		$query_count 	= db_return_count($query_result);
		if ($query_count == 0) { return null; }
		
		$school 		= new SchoolDO();
		$data       	=  db_return_object($query_result);  
		
		$school->school_id           	  = $data->school_id;
		$school->school_name     		  = stripslashes($data->school_name);
		$school->school_password   		  = $data->school_password;
		$school->school_contactname       = stripslashes($data->school_contactname);		
		$school->school_contactperson_position  = stripslashes($data->school_contactperson_position);	
		$school->school_startdate    	  = $data->school_startdate;
		$school->school_enddate	    	  = $data->school_enddate;
		$school->school_expirydate    	  = $data->school_expirydate;
		$school->school_address1	      = stripslashes($data->school_address1);		
		$school->school_address2		  = stripslashes($data->school_address2);
		$school->school_city    		  = $data->school_city;
		$school->school_country    		  = $data->school_country;
		$school->school_zipcode    		  = $data->school_zipcode;
		$school->school_email    		  = $data->school_email;
		$school->school_invoice_to		  = stripslashes($data->school_invoice_to);
		$school->school_proforma_invoice  = stripslashes($data->school_proforma_invoice);	
		$school->school_phone    		  = $data->school_phone;				
		$school->school_status        	  = $data->school_status;
		return $school;
		}	
	
	 //List All Schools
	 function School_List(&$school)  {
		 $query_select = "SELECT 
		 						school_id,
								school_name,
								school_password,
								school_contactname,
								school_contactperson_position,
								school_startdate,
								school_enddate,
								school_expirydate,
								school_address1,
								school_address2,
								school_city,
								school_country,
								school_zipcode,
								school_email,
								school_invoice_to,
								school_proforma_invoice,
								school_phone,								
								school_status
						 FROM 
						 		".TABLE_SCHOOL."
						 WHERE 
								 school_isdeleted=0";						 
								//  echo '<font color=#FFFFFF>'.$query_select .'</font>';
								  
 		$query_result 	= db_execute_query($query_select);
		$query_count 	= db_return_count($query_result);
		if ($query_count == 0) { return null; }
		
		$school       	 =  new SchoolDO();
		while($data  = db_return_object($query_result))   {
				$school->school_id           	  = $data->school_id;
				$school->school_name     		  = stripslashes($data->school_name);
				$school->school_password   		  = $data->school_password;
				$school->school_contactname       = stripslashes($data->school_contactname);		
				$school->school_contactperson_position  = stripslashes($data->school_contactperson_position);	
				$school->school_startdate    	  = $data->school_startdate;
				$school->school_enddate	    	  = $data->school_enddate;
				$school->school_expirydate    	  = $data->school_expirydate;
				$school->school_address1		  = stripslashes($data->school_address1);		
				$school->school_address2		  = stripslashes($data->school_address2);
				$school->school_address3		  = stripslashes($data->school_address3);
				$school->school_city    		  = $data->school_city;
				$school->school_country    		  = $data->school_country;
				$school->school_zipcode    		  = $data->school_zipcode;
				$school->school_email    		  = $data->school_email;
				$school->school_invoice_to		  = stripslashes($data->school_invoice_to);
				$school->school_proforma_invoice  = stripslashes($data->school_proforma_invoice);	
				$school->school_phone    		  = $data->school_phone;				
				$school->school_status        	  = $data->school_status;
				$school_list[]             	      = $school;
		 } //End of whileLoop
 		return $school_list;
	}	 
	// Fetching total number of available records
	function School_TotalCount(&$school) {
			    $query_list   = "SELECT 
										school_id,
										school_name,
										school_password,
										school_contactname,
										school_contactperson_position,
										school_startdate,
										school_enddate,
										school_expirydate,
										school_address1,
										school_address2,
										school_city,
										school_country,
										school_zipcode,
										school_email,
										school_invoice_to,
										school_proforma_invoice,
										school_phone,								
										school_status
						 FROM 
						 		".TABLE_SCHOOL."
						 WHERE 
								 school_isdeleted=0";
				$query_result = db_execute_query($query_list);
				$query_count  = db_return_count($query_result);
				return $query_count;
		}
	// To send email
	//function SendMail($to, $txtname, $txtemail, $txtcomments, $subject) {
	function SendMail($to,$username,$schoolname,$pass,$subject) {
	
		global $body;
		$headers  = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";	
		$headers .= "From: wyzeup <admin@wyzeup.com>\r\n";
		$headers .= "X-Priority: 3\r\n";
		$headers .= "X-MSMail-Priority: High\r\n";
		$headers .= "X-Mailer: wyzeup \r\n";	
		$message ='<p><span class="paragraph">Hi '.$username.'</span>,</p>
						<table width="70%" border="0" cellspacing="1" cellpadding="4" bgcolor="#7FA2B5" align="center">
						  <tr bgcolor="#7FA2B5" class="paragraph">
							<td colspan="3" align=center><font color="#FFFFFF"><strong><strong>Wyze Up  Login Details </strong></strong></font></td>
						  </tr>
						  <tr bgcolor="#FFFFFF">
							<td align="right" class="paragraph">Username :</td>
							<td align="left" class="paragraph">'.$schoolname.'</td>
						  </tr>
						  <tr bgcolor="#FFFFFF">
							<td align="right" class="paragraph">Password :</td>
							<td align="left" class="paragraph">'.$pass.'</td>
						  </tr></table>
				<p><span class="paragraph">Regards,</span></p>
				<p><span class="paragraph">The Wyze Up Team. </span></p>';
		@mail($to, $subject, $message, $headers);
		$body = "";
		return true;	
	}		
		
  } //End of DAO Class
?>