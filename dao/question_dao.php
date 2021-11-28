<?php
require_once('../conf/conf.inc.php');

class QuestionDO {
	var $question_id;
	var $scenario_fk_id;
	var $question_name;
	var $question_option1;
	var $question_option2;
	var $question_option3;
	var $question_option4;
	var $question_answer;
	var $question_rank;
	var $question_status;
 } 
class QuestionDAO {
 	//Function for Create
	function Question_Create(&$question) {
		$error_messages   = $this->Question_ValidateCreate($question);
		if(!$error_messages){	
			if($question->question_status =='') $question->question_status = 0;
			$insert_query  = 'INSERT into '.TABLE_QUESTION.' (
											scenario_fk_id,
											question_name,
											question_option1,
											question_option2,
											question_option3,
											question_option4,
											question_answer,
											question_rank,
											question_status,
											question_isdeleted									
								 ) VALUES (
								 "'.$question->scenario_fk_id.'",
								 "'.addslashes($question->question_name).'",
								 "'.addslashes($question->question_option1).'",
								 "'.addslashes($question->question_option2).'",
								 "'.addslashes($question->question_option3).'",
								 "'.addslashes($question->question_option4).'",
								 "'.addslashes($question->question_answer).'",
								 "'.$question->question_rank.'",								 
								 "'.$question->question_status.'", 0
							  )';
			db_execute_query($insert_query);		
			$db_insert_id 	= mysql_insert_id();
			#File Upload			
  		   // $img_upld = $this->FileUpload($db_insert_id,$question->question_image);	
			$img_upld 		= $this->Image_thumbnailUpload($db_insert_id,$question->question_image);


			}
		return $error_messages;
	}
	//Validation Before Insertion
	function Question_ValidateCreate($question) {		
		if(check_row_exists(TABLE_QUESTION,'question_name',$question->question_name,'question_isdeleted',0)){
		   $error_messages['question_name'] = ERROR_QNAME_IS_DUPLICATE;
	    }	
		/*if(check_row_exists_for_row_type_update(TABLE_QUESTION, "question_rank", $question->question_rank,"question_id",$question->question_id,"question_isdeleted",0)) {
				$error_messages['question_rank'] = "The sequence already assigned to some other one";
		}*/	
  
		if(check_row_exists_two(TABLE_QUESTION,'question_rank',$question->question_rank,'scenario_fk_id',$question->scenario_fk_id,'question_isdeleted',0)){
		   $error_messages['question_rank'] = "The sequence already assigned to some other one";
	    }	
 		return $error_messages;
	}	
	//Function to update the table
	function Question_Update($question) {
		$error_messages   = $this->Question_ValidateUpdate($question); //echo count($error_messages);die();		
		if(!$error_messages){
			if($question->question_status =='') $question->question_status = 0;
			 $update_query  = 'UPDATE '.TABLE_QUESTION.' SET
								scenario_fk_id   	  = "'.$question->scenario_fk_id.'",
								question_name	 	  = "'.addslashes($question->question_name).'",
								question_option1	  = "'.addslashes($question->question_option1).'",
								question_option2	  = "'.addslashes($question->question_option2).'",
								question_option3	  = "'.addslashes($question->question_option3).'",
								question_option4	  = "'.addslashes($question->question_option4).'",
								question_answer	 	  = "'.addslashes($question->question_answer).'",
								question_rank	 	  = "'.$question->question_rank.'",
								question_status	 	  = "'.$question->question_status.'"	
							WHERE 
								question_id = '.$question->question_id;			
 			db_execute_query($update_query);
  		   // $img_upld = $this->FileUpload($question->question_id,$question->question_image);
   			$img_upld 		= $this->Image_thumbnailUpload($question->question_id,$question->question_image);

		}
	  return $error_messages;
	}
	function Question_ValidateUpdate($question) {
		if(check_row_exists_for_row_type_update(TABLE_QUESTION, "question_name", $question->question_name,"question_id",$question->question_id,"question_isdeleted",0)) {
			$error_messages['question_name'] = ERROR_QNAME_IS_DUPLICATE;
	    }
	
		/*if(check_row_exists_for_row_type_update_two(TABLE_QUESTION, "question_rank", $question->question_rank,"question_id",$question->question_id,'scenario_fk_id',$question->scenario_fk_id,"question_isdeleted",0)) {
		//if(check_row_exists_for_row_type_update_two(TABLE_QUESTION, "question_rank", $question->question_rank,'scenario_fk_id',$question->scenario_fk_id,"question_isdeleted",0)) {
				$error_messages['question_rank'] = "The sequence already assigned to some other one";
		}	*/
		$sqlqry = "select question_rank from wyzeup_questions where question_rank = $question->question_rank and question_isdeleted = 0 and scenario_fk_id = $question->scenario_fk_id";
		$resqry = mysql_query($sqlqry);
		if(mysql_num_rows($resqry)>0){ 
			$sqlqry1 = "select question_rank from wyzeup_questions where question_rank = $question->question_rank and question_isdeleted = 0 and scenario_fk_id = $question->scenario_fk_id and question_id = $question->question_id";
			$resqry1 = mysql_query($sqlqry1);
				if(mysql_num_rows($resqry1)>0){ 
				}else{
					$error_messages['question_rank'] = "The sequence already assigned to some other one";
				}				
		}
  		return $error_messages;
	}
	
	// Delete Process
	function Question_Delete(&$questionid){
		$delete_query  = 'UPDATE '.TABLE_QUESTION.' SET question_isdeleted  = 1 WHERE question_id ='. $questionid;
		db_execute_query($delete_query);
	}
	//Read
	function Question_Read(&$questionid)  {
			$query_select = "SELECT 
								question_id,
								scenario_fk_id,
								question_name,
								question_option1,
								question_option2,
								question_option3,
								question_option4,
								question_answer,
								question_image,
								question_rank,
								question_status
						 FROM
						 		".TABLE_QUESTION."
						 WHERE 
						 		question_id = ".$questionid." AND question_isdeleted=0";
						 //echo $query_select;
		$query_result = db_execute_query($query_select);
		$query_count = db_return_count($query_result);
		if ($query_count == 0) {
			return null;
		}
		$question 		= new QuestionDO();
		$data      		= db_return_object($query_result);  
		
		$question->question_id           	  = $data->question_id;
		$question->scenario_fk_id     		  = $data->scenario_fk_id;
		$question->question_name      	 	  = stripslashes($data->question_name);
		$question->question_option1      	  = stripslashes($data->question_option1);
		$question->question_option2      	  = stripslashes($data->question_option2);
		$question->question_option3      	  = stripslashes($data->question_option3);
		$question->question_option4      	  = stripslashes($data->question_option4);
		$question->question_answer      	  = stripslashes($data->question_answer);
		$question->question_image      		  = stripslashes($data->question_image);
		$question->question_rank        	  = $data->question_rank;
		$question->question_status        	  = $data->question_status;
		return $question;
	}
	 //List All Questions
	 function Question_List(&$question)  {
		 $query_select = "SELECT 
		 						question_id,
								scenario_fk_id,
								question_name,
								question_option1,
								question_option2,
								question_option3,
								question_option4,
								question_answer,
								question_image,
								question_rank,
								question_status
						 FROM 
						 		".TABLE_QUESTION."
						 WHERE 
								 question_isdeleted=0";						 
								//  echo '<font color=#FFFFFF>'.$query_select .'</font>';
								  
 		$query_result 	= db_execute_query($query_select);
		$query_count 	= db_return_count($query_result);
		if ($query_count == 0) { return null; }
		
		$question       	 =  new QuestionDO();
		while($data  = db_return_object($query_result))   {		
				$question->question_id           	  = $data->question_id;
				$question->scenario_fk_id     		  = $data->scenario_fk_id;
				$question->question_name      	 	  = stripslashes($data->question_name);
				$question->question_option1      	  = stripslashes($data->question_option1);
				$question->question_option2      	  = stripslashes($data->question_option2);
				$question->question_option3      	  = stripslashes($data->question_option3);
				$question->question_option4      	  = stripslashes($data->question_option4);
				$question->question_answer      	  = stripslashes($data->question_answer);
				$question->question_image      	 	  = stripslashes($data->question_image);				
				$question->question_rank        	  = $data->question_rank;
				$question->question_status        	  = $data->question_status;

				$question_list[]             	      = $question;
		 } //End of whileLoop
 		return $question_list;
	}	 
	// Fetching total number of available records
	function Question_TotalCount(&$scenario_id) {
			 $query_list   = "SELECT 
								question_id,
								scenario_fk_id,
								question_name,
								question_option1,
								question_option2,
								question_option3,
								question_option4,
								question_answer,
								question_image,
								question_rank,
								question_status
						 FROM 
						 		".TABLE_QUESTION."
						 WHERE 
								 question_isdeleted=0 AND scenario_fk_id=".$scenario_fk_id;
				$query_result = db_execute_query($query_list);
				$query_count  = db_return_count($query_result);
				return $query_count;
		}
	 function FileUpload($id,$file1)	{
   		if ($file1!='') {
 			$file1			= $id."_".$file1;
	 		$uploadfile     = '../question_images/'.$file1;			 
  			if (file_exists($uploadfile)) {
				unlink($uploadfile);
			}
  			if(move_uploaded_file($_FILES['question_image']['tmp_name'],$uploadfile)) {
  				$query="UPDATE ".TABLE_QUESTION." SET question_image ='".$file1."' WHERE question_id =".$id;
   				db_execute_query($query);
 			} else {
				$error_messages['question_image']="Sorry , there is a problem in uploading the image .Please try again.";
			}
 		}	
  		return $error_messages;
	} 
	
	# To Upload image with resizing
	
	function Image_thumbnailUpload($id,$file1)	{ 
   		if ($file1!='') {
			$filet			= $id."_".$file1;
			$img			= explode(".",$file1);
 			$srcfile        = 'thumb_'.$id.'_'.$file1;
			$destfile       = $id.'_'.$file1;
	 		$uploadfile     = '../scenario_images/'.$srcfile;			 
  			if (file_exists($uploadfile)) {
				unlink($uploadfile);
			}
			
			if(move_uploaded_file($_FILES['question_image']['tmp_name'],$uploadfile)) {
					$destination 	 = '../scenario_images/'.$destfile;		
					echo $query="UPDATE ".TABLE_QUESTION." SET  question_image ='".$destfile."' WHERE question_id=".$id;   				
					mysql_query($query);
					//Image Cropping
					//$img_crop       =  $this->ImageResize($filet);
					$thumbnail       =  $this->ImageDimensions($uploadfile,$destination);
				} else {
					$error_messages['question_image']="Sorry , there is a problem in uploading the Image .Please try again.";
				}
		}
	}
	
/**
* Image Cropping function
*
*/
	function ImageDimensions($srcfile,$destfile)
	{ //echo $srcfile;
		//if(exif_imagetype($srcfile)==IMAGETYPE_JPEG || exif_imagetype($srcfile)==IMAGETYPE_GIF) {	
			#Check Size and resize if required
			$picsize=getimagesize($srcfile);
			$source_x  = $picsize[0];
			$source_y  = $picsize[1];
			#Resizing Small Image
			define('SMALLPRODUCT_MAX_X',210);
			define('SMALLPRODUCT_MAX_Y',118);																	
			 if ($source_x > SMALLPRODUCT_MAX_X) {
				$ratio = SMALLPRODUCT_MAX_X / $source_x;
				$new_height = $ratio * $source_y; 
				$new_width  = SMALLPRODUCT_MAX_X;
			} else {
				$new_height =  $source_y; 
				$new_width  =  $source_x; 
			}
			
			$smallimage_resized=$this->resizeToFile($srcfile,$new_width, $new_height,$destfile ,75);
			return ($smallimage_resized!='') ? false : true;
		//}	
	}
 function ImageResize($imagename){
		$destination  =  "../scenario_images/thumb_".$imagename;
		$source		  =  "../scenario_images/".$imagename;
		$defined_width	= 210;$defined_height = 210;
		$dimensions   = getimagesize('../scenario_images/'.$imagename);
		if($dimensions[0] == $dimensions[1]){ // both are equal
				$Img_crop = $this->ImageCrop($imagename,$imagename);
		} else if($dimensions[0] < $dimensions[1]){ // width is lessthan height
				$ratio 		= $defined_width / $dimensions[0];
				$newheight  = $ratio * $dimensions[1]; 
				$newwidth   = $defined_width;		
				$File_resize       =  resizeToFile ($source, $newwidth, $newheight, $destination, 75);
				$Img_crop = $this->ImageCrop("thumb_".$imagename,$imagename);
				unlink($destination);
		} else if($dimensions[0] > $dimensions[1]){ // width is greater than height
				$ratio 		 = $defined_height / $dimensions[1];
				$newwidth    = $ratio * $dimensions[0]; 
				$newheight   = $defined_height;		
				$File_resize       =  $this->resizeToFile($source, $newwidth, $newheight, $destination, 75);
				$Img_crop = $this->ImageCrop("thumb_".$imagename,$imagename);
				unlink($destination);
		}
	}
	function ImageCrop($imagename,$dest) {
		// Set our crop dimensions.
		$width  = 210;
		$height = 210;
		// Get dimensions of existing image
		$dimensions = getimagesize('../scenario_images/'.$imagename);
		// Prepare canvas
		$canvas = imagecreatetruecolor($width,$height);
		$piece = imagecreatefromjpeg('../scenario_images/'.$imagename);		
		$newwidth = $width;$newheight = $height;
		$cropLeft = ($newwidth/2) - ($width/2);
		$cropHeight = ($newheight/2) - ($height/2);
		// Generate the cropped image
		//echo "cropLeft:: ".$cropLeft."$cropHeight:::".$cropHeight."<br>Width::".$width."Hwight:".$height."<br>Newwidth::".$newwidth."newheight:::".$newheight;
		imagecopyresized($canvas, $piece, 0,0, $cropLeft, $cropHeight, $width, $height, $newwidth, $newheight);
		// Write image or fail
		if (imagejpeg($canvas,'../scenario_images/thumb_'.$dest,90)) {
		} else {
			//echo 'Image crop failed';
		}
		// Clean-up
		
		imagedestroy($canvas);
		imagedestroy($piece);
	}
	function resizeToFile ($sourcefile, $dest_x, $dest_y, $targetfile, $jpegqual) {
		// Get the dimensions of the source picture 
		$picsize=getimagesize($sourcefile);
		$source_x  = $picsize[0];
		$source_y  = $picsize[1];
		$imagetype = $picsize['mime'];
		if(($dest_x > $source_x) && ($dest_y > $source_y)) {
			return $sourcefile;
		}
		# Creating the new image accroding to the source image type
		switch($imagetype){
			case 'image/png' : 	$source_id = imagecreatefrompng($sourcefile); break;
			case 'image/jpeg': 	$source_id = imagecreatefromjpeg($sourcefile); break;
			case 'image/gif' : 	$old_id    = imagecreatefromgif($sourcefile);
								$source_id = imagecreatetruecolor($source_x,$source_y);
								imagecopy($source_id,$old_id,0,0,0,0,$source_x,$source_y);
								break;
			default: break;
		}
		$target_id=imagecreatetruecolor($dest_x, $dest_y);
		$target_pic=imagecopyresampled($target_id,$source_id, 0,0,0,0, $dest_x,$dest_y, $source_x,$source_y);
		switch($imagetype){
			case 'image/png' : 	imagepng($target_id,"$targetfile",$jpegqual); break;
			case 'image/jpeg': 	imagejpeg ($target_id,"$targetfile",$jpegqual); break;
			case 'image/gif' : 	imagegif($target_id,"$targetfile"); 
								imagecolortransparent($target_id);
								break;
			default: break;
		}
		return $targetfile;
	}	
		
 } //End of DAO Class

?>