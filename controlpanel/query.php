<?PHP 
require_once('connection.php');
$search = $_GET['searchvalue'];
 if($_GET['searchtype']== 'menu2'){
	$sql = mysql_query("SELECT  * FROM safe_questions WHERE scenario_fk_id = $search AND question_isdeleted = 0  ORDER BY question_rank ASC");
		if(mysql_num_rows($sql) == 0){ 
 				$empty=0;
					echo 'Questions Not Available'; 
			} else{ 
				while($row = mysql_fetch_array($sql)) { 
					if($value){											
						$value = $value.":".base64_decode($row['menu2_internalname']).'#'.$row['question_id']; 
					 }else{
						$value = base64_decode($row['menu2_internalname']).'#'.$row['question_id']; 											
					}
				}
				echo $value;
		 }	 
    }	
}
?> 