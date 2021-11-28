<?php
class ScenarioDO {
	var $scenario_id;
	var $scenario_name;
	var $scenario_desc;
	var $scenario_image;
	var $scenario_status;
	var $scenario_isdeleted;
 } 
class ScenarioDAO {
 	//Function for Create
	function Scenario_Create(&$scenario) {
		$error_messages   = $this->Scenario_ValidateCreate($scenario);
		if(!$error_messages){
			if($scenario->scenario_status =='') $scenario->scenario_status = 0;
			$insert_query  = 'INSERT into '.TABLE_SCENARIO.' (
											scenario_name,
											scenario_desc,
											scenario_status,
											scenario_isdeleted									
								 ) VALUES (
								 "'.$scenario->scenario_name.'",
								 "'.addslashes($scenario->scenario_desc).'",								 
								 '.$scenario->scenario_status.', 0
							  )';
			db_execute_query($insert_query);		
			$db_insert_id 	= mysql_insert_id();
			#File Upload
		// $img_upld = $this->FileUpload($db_insert_id,$scenario->scenario_image);	
		 }
		return $error_messages;

	}
	//Function to update the table
	function Scenario_Update($scenario) {
		$error_messages   = $this->Scenario_ValidateUpdate($scenario);
		if(!$error_messages){
			if($scenario->scenario_status =='') $scenario->scenario_status = 0;
			$update_query  = 'UPDATE '.TABLE_SCENARIO.' SET
								scenario_name     = "'.$scenario->scenario_name.'",
								scenario_desc	  = "'.addslashes($scenario->scenario_desc).'",
								scenario_status	  = "'.$scenario->scenario_status.'"	
							WHERE 
								scenario_id = '.$scenario->scenario_id;			
 			db_execute_query($update_query);
			//$img_upld =$this->FileUpload($scenario->scenario_id,$scenario->scenario_image);			
		}
		return $error_messages;
	}
	function Scenario_ValidateUpdate($scenario) {
		if(check_row_exists_for_row_type_update(TABLE_SCENARIO, "scenario_name", $scenario->scenario_name,"scenario_id",$scenario->scenario_id,"scenario_isdeleted",0)) {
			$error_messages['scenario_name'] = ERROR_QNAME_IS_DUPLICATE;
	    }
		/* if(check_row_exists_for_row_type(TABLE_SCENARIO, "scenario_name", $scenario->scenario_name,"scenario_isdeleted",0)) {
			$error_messages['scenario_name'] = ERROR_NAME_IS_DUPLICATE;
	    }

	    if(check_row_exists_update(TABLE_SCENARIO,'scenario_name',$scenario->scenario_name,'scenario_id',$scenario->scenario_id,'scenario_isdeleted',0))
	    {
		   $error_messages['scenario_name'] = ERROR_SNAME_IS_DUPLICATE;
	    }*/
  		return $error_messages;
	}
	//Validation Before Insertion
	function Scenario_ValidateCreate($scenario) {		
	    if(check_row_exists(TABLE_SCENARIO,'scenario_name',$scenario->scenario_name,'scenario_isdeleted',0)){
		   $error_messages['scenario_name'] = ERROR_NAME_IS_DUPLICATE;
	    }	
 		return $error_messages;
	}
	// Delete Process
	function Scenario_Delete(&$scenarioid){
		$delete_query  = 'UPDATE '.TABLE_SCENARIO.' SET scenario_isdeleted  = 1   WHERE scenario_id ='. $scenarioid;
		db_execute_query($delete_query);
	}
	//Read
	function Scenario_Read(&$scenarioid)  {
			$query_select = "SELECT 
								scenario_id,
								scenario_name,
								scenario_desc,
								scenario_image,
								scenario_status
						 FROM
						 		".TABLE_SCENARIO."
						 WHERE 
						 		scenario_id = ".$scenarioid." AND scenario_isdeleted=0";
						 //echo $query_select;
		$query_result = db_execute_query($query_select);
		$query_count = db_return_count($query_result);
		if ($query_count == 0) {
			return null;
		}
		$scenario 		= new ScenarioDO();
		$data       = db_return_object($query_result);  
		
		$scenario->scenario_id           	  = $data->scenario_id;
		$scenario->scenario_name     		  = $data->scenario_name;
		$scenario->scenario_desc      	 	  = stripslashes($data->scenario_desc);
		$scenario->scenario_image    		  = $data->scenario_image;
		$scenario->scenario_status        	  = $data->scenario_status;
		return $scenario;
	}
	 //List All Scenarios
	 function Scenario_List(&$scenario)  {
		 $query_select = "SELECT 
		 						scenario_id,
								scenario_name,
								scenario_desc,
								scenario_image,
								scenario_status
						 FROM 
						 		".TABLE_SCENARIO."
						 WHERE 
								 scenario_isdeleted=0";						 
								//  echo '<font color=#FFFFFF>'.$query_select .'</font>';
								  
 		$query_result 	= db_execute_query($query_select);
		$query_count 	= db_return_count($query_result);
		if ($query_count == 0) { return null; }
		
		$scenario       	 =  new ScenarioDO();
		while($data  = db_return_object($query_result))   {
				$scenario->scenario_id           	  = $data->scenario_id;
				$scenario->scenario_name     		  = $data->scenario_name;
				$scenario->scenario_desc      	 	  = stripslashes($data->scenario_desc);
				$scenario->scenario_image    		  = $data->scenario_image;
				$scenario->scenario_status        	  = $data->scenario_status;				
				$scenario_list[]             	      = $scenario;
		 } //End of whileLoop
 		return $scenario_list;
	}	 
	// Fetching total number of available records
	function Scenario_TotalCount(&$scenario) {
			    $query_list   = "SELECT 
								scenario_id,
								scenario_name,
								scenario_desc,
								scenario_image,
								scenario_status
						 FROM 
						 		".TABLE_SCENARIO."
						 WHERE 
								 scenario_isdeleted=0";
				$query_result = db_execute_query($query_list);
				$query_count  = db_return_count($query_result);
				return $query_count;
		}
	 function FileUpload($id,$file1)	{
   		if ($file1!='') {
 			$file1			= $id."_".$file1;
	 		$uploadfile     = '../scenario_images/'.$file1;			 
  			if (file_exists($uploadfile)) {
				unlink($uploadfile);
			}
  			if(move_uploaded_file($_FILES['scenario_image']['tmp_name'],$uploadfile)) {
  				$query="UPDATE ".TABLE_SCENARIO." SET  scenario_image ='".$file1."' WHERE scenario_id=".$id;
   				db_execute_query($query);
 			} else {
				$error_messages['scenario_image']="Sorry , there is a problem in uploading the image .Please try again.";
			}
 		}	
  		return $error_messages;
	} 
  } //End of DAO Class

?>