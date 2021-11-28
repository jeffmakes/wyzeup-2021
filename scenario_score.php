<?php 
	session_start();
	require_once('conf/conf.inc.php');
	
	#To get the Answer 
	$value      = $_GET['answer'];
	$quest_id 	= $_GET['questid'];
	$display_id = $_GET['displayid'];
	$flagvalue  = $_GET['fg'];
	
	if($display_id  != 5){
		$select_qry = "SELECT question_answer,question_image FROM wyzeup_questions WHERE  question_id=".$quest_id." AND question_isdeleted = 0";
		$result = mysql_query($select_qry);
		if(mysql_num_rows($result)){ 
			$row = mysql_fetch_array($result); 
			if($row['question_answer'] == $value){ 
					if($flagvalue == 1){ 
						$j = $display_id;
					}else {						
					 	if($display_id==4) {$j=$display_id;
						}else {$j = $display_id+1;	}
					} 
					//$j = $display_id+1;
					$flag=1; 
					$correct= "Yes";
					$query = "SELECT score_id,score_image,score_value FROM wyzeup_score WHERE score_value=".$j." AND score_isdeleted = 0 ";
					$qry_result = mysql_query($query);
					$row_img = mysql_fetch_array($qry_result);
				echo $row_img["score_image"]."@##@".$correct."@##@".$j."@##@".$flag."@##@".$value;		
			}
			else{
					/*if($flagvalue == 1){ 
						$j = $display_id;
					}else {					 	
						if($display_id==4) {$j=$display_id;
						}else {$j = $display_id+1;	}
					} */
					$j = $display_id;
					$flag=1;
					$correct= "No";
					$query = "SELECT score_id,score_image,score_value FROM wyzeup_score WHERE score_value=".$j." AND score_isdeleted = 0 ";
					$qry_result = mysql_query($query);
					$row_img = mysql_fetch_array($qry_result);
				echo $row_img["score_image"]."@##@".$correct."@##@".$j."@##@".$flag."@##@".$value;			
			}
		}
	}
?>