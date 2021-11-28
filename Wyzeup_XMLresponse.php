<?php 
/**
* Header inclusion for generation XML file 
*/	
/*header("Pragma: no-cache");
header("Expires: " . gmdate("D, d M Y H:i:s", time() + (-1*60)) . " GMT");
header("Content-type: text/xml"); */
 
session_start();
require_once('conf/conf.inc.php');

//TO get the values for each scenarios continuously.
$i=$_GET['id'];
$anser_id = $_GET['ansid'];
$questionids    =  explode(",",$_SESSION["session_questionids"]);

if($i<4){
	if($questionids[$i] != ''){
		$sql = "SELECT scenario_id,question_id,scenario_name,question_name,question_answer,question_image FROM wyzeup_scenarios,wyzeup_questions WHERE scenario_id = scenario_fk_id AND question_id = $questionids[$i]";
		$res = mysql_query($sql);
		if(mysql_num_rows($res)){
			$row = mysql_fetch_array($res);
			/*$desc		 = $row["question_name"];
			$desc = preg_replace('/</',' <',$desc);
			$desc = preg_replace('/>/','> ',$desc);
			$desc = html_entity_decode(strip_tags($desc));
			$desc = preg_replace('/[\n\r\t]/',' ',$desc);
			$desc = preg_replace('/  /',' ',$desc);*/
			$questionname = stripslashes(str_replace(chr(13),"<br />",$row["question_name"]));
			//echo "<?xml version='1.0'<title>".htmlentities($result["title"])."</title><nextcontid>".$nextid."</nextcontid><content>".htmlentities($result["content"])."</content><image>".$result["image"]."</image><loaderimage>".$result["loaderimage"]."</loaderimage>";
			echo $row["scenario_name"]."@##@".$questionname."@##@".$row["question_image"]."@##@".$row["question_id"]."@##@".$i;
		}
	}
}
 if($_GET['sid']){
	$sqlqry = "SELECT  scenario_name ,scenario_desc  FROM wyzeup_scenarios WHERE scenario_id =".$_GET['sid'];
	$result = mysql_query($sqlqry);
	$row_scene 	=  mysql_fetch_array($result);		
	$description = stripslashes(str_replace(chr(13),"<br />",$row_scene["scenario_desc"]));
	echo  $row_scene["scenario_name"]."@##@".'<b>Explanation<b>'."@##@".$description."@##@".''."@##@".'4';
}
?>