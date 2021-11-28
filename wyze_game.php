<?php 
	session_start();
	require_once('conf/conf.inc.php');
	require_once('dao/scenario_dao.php');
	session_register("session_questionids");
	session_register("test");
	
	$db 	  = new dbclass1();
	
	#User Existence validation
	/*
	if(isset($_SESSION['username'])==''){
		header("Location:index.php?err=login");
	}*/
	
	/*$qry_scen = "SELECT scenario_id,scenario_name,scenario_desc,scenario_image,scenario_status FROM ".TABLE_SCENARIO." WHERE scenario_isdeleted=0 AND scenario_status = 1";
	$query_result = db_execute_query($qry_scen);
	$query_count = db_return_count($query_result);*/
	
	$scenario_id = $_POST['scenario_id'];	
		if($scenario_id){
			$qry_scen = "SELECT question_id,scenario_fk_id,question_name,question_answer,question_image,question_rank,question_status FROM ".TABLE_QUESTION." WHERE scenario_fk_id = ".$scenario_id." AND question_status = 1 AND  question_isdeleted=0"; 
			$query_result 	   = db_execute_query($qry_scen);
			while($row = mysql_fetch_array($query_result)){ 
				  $arr_id[] = $row['question_id'];
				  $scenario_id = $row['scenario_fk_id'];
			  }
			  $mailcount = count($arr_id)- 1;
			  for($j=0;$j<$mailcount;$j++) {
			  $rank_val .= $arr_id[$j].",";  }
			$rank_val .=$arr_id[$mailcount]; 
			$_SESSION["session_questionids"] = $rank_val; 
		}
	$numberofquestions = $_POST['numrows'];
	if($_SESSION["session_questionids"]) {  
		$questionids    =  explode(",",$_SESSION["session_questionids"]);
		$tmpquestionids =  implode(",",$questionids);
		$rows           =  sizeof($questionids);
	}
	/*if($_POST['remainquestions']) {
		$remain_questions  = $_POST['remainquestions']+1;
	} else {
		$remain_questions  = 1;
	}*/
	if($_POST["nextid"]) {
	   $i = $_POST["nextid"]; 
	} else{
	   $i = 0 ;
	}
	if($_POST["answeredqid"]){ 
	  $answeredqid=$_POST["answeredqid"]; 
	 }else{
	   $answeredqid="";
	 }
	// if($_POST["inc"]) {$k=$_POST["inc"];}
		//else $k=0;
	 //Test Validation
	if($_POST["score"]) {
		$score  =  $_POST["score"];//Number of Correct Answers				
	}else{ 
		$score  =  0;
	} 
	$answer = $_POST['testoptionvalue']; 
	$useranswer = explode(",", $answer);
	if($answer){
		$cnt = sizeof($useranswer);
	}
	foreach ($useranswer as $value){
		if($value == 1){
			$pbar_value =$pbar_value + 1;
		}		
		//echo $value."<br>";		
	}
	if($cnt <= 4 && $cnt !== ""){
		create_progress();
	}
	if($pbar_value == 1){
		update_progress(25);
	}elseif($pbar_value == 2){
		update_progress(50);
	}elseif($pbar_value == 3){
		update_progress(75);	
	}elseif($pbar_value == 4){
		update_progress(100);	
	}
function create_progress() {
  // First create our basic CSS that will control the look of this bar:
  echo "<style>
		#text {
		  position: absolute;
		  top: 500px;
		  left: 50%;
		  margin: 0px 0px 0px -150px;
		  font-size: 18px;
		  text-align: center;
		  width: 300px;
		}
	 #barbox_a {
		  position: absolute;
		  top: 530px;
		  left: 50%;
		  margin: 0px 0px 0px -160px;
		  width: 304px;
		  height: 24px;
		  background-color: black;
		}
		.per {
		  position: absolute;
		  top: 530px;
		  font-size: 18px;
		  left: 50%;
		  margin: 1px 0px 0px 150px;
		  background-color: #FFFFFF;
		}		
		.bar {
		  position: absolute;
		  top: 532px;
		  left: 50%;
		  margin: 0px 0px 0px -158px;
		  width: 0px;
		  height: 20px;
		  background-color: #99CCFF;
		}		
		.blank {
		  background-color: white;
		  width: 300px;
		}
		</style>
		";
  // Now output the basic, initial, XHTML that will be overwritten later:
  echo "
		<div id='text'>Script Progress</div>
		<div id='barbox_a'></div>
		<div class='bar blank'></div>
		<div class='per'>0%</div>
		";
  // Ensure that this gets to the screen  immediately:
  flush();
}
function update_progress($percent) { 

  // First let's recreate the percent with the new one:
  echo "<div class='per'>{$percent}%</div>\n";

  // Now, output a new 'bar', forcing its width to 3 times the percent, since we have defined the percent bar to be at 300 pixels wide.
  echo "<div class='bar' style='width: ",$percent * 3, "px'></div>\n";

  // Now, again, force this to be immediately displayed:
  flush();
}	
?>
<html lang="english">
<title>Wyze Up</title>
<script language="javascript">
function Select_Scenario(){
	document.frmgame.action="wyze_game.php";
	document.frmgame.method="POST";
	document.frmgame.submit();
}
function Select_Questions(){
	document.form1.action="wyze_game.php";
	document.form1.method="POST";
	document.form1.submit();
}
/*function Select_Answer(){
	document.testfrm.btnsubmit.disabled = true;
	document.testfrm.btncancel.disabled = true;
	if(document.testfrm.btnsubmit.value){
		 if(document.testfrm.testoptionvalue.value){
			document.testfrm.testoptionvalue.value = document.testfrm.testoptionvalue.value + 1;
		 }else{
			document.testfrm.testoptionvalue.value = document.testfrm.testoptionvalue.value;
		 }
	 }elseif(document.testfrm.btncancel.value){
		 if(document.testfrm.testoptionvalue.value){
			document.testfrm.testoptionvalue.value = document.testfrm.testoptionvalue.value + 0;
		 }else{
			document.testfrm.testoptionvalue.value = document.testfrm.testoptionvalue.value;
		 }
	}
}*/
function Select_Wyze(){
	var id    =parseInt(document.testfrm.nextid.value);
	var count =parseInt(document.testfrm.numrows.value);
	if(document.testfrm.testoptionvalue.value == 0){
		if(document.testfrm.btnsubmit.value){
		document.testfrm.testoptionvalue.value = 1;
		}
	}else{
		if(document.testfrm.btnsubmit.value){
			document.testfrm.testoptionvalue.value = document.testfrm.testoptionvalue.value+","+1;
		}else{
			document.testfrm.testoptionvalue.value = document.testfrm.testoptionvalue.value;
		}	
	}
	document.testfrm.btncancel.disabled = true;
	/*if(document.testfrm.btnsubmit.value){
	  if(document.testfrm.testoptionvalue.value == 0){
		//document.testfrm.testoptionvalue.value = document.testfrm.testoptionvalue.value+","+document.testfrm.btnsubmit.value;
		document.testfrm.testoptionvalue.value = document.testfrm.testoptionvalue.value+","+1;
	  }
	  else{
	    //document.testfrm.testoptionvalue.value = document.testfrm.btnsubmit.value; //+","+document.testfrm.testoptionvalue.value;
		document.testfrm.testoptionvalue.value = document.testfrm.testoptionvalue.value; //+","+document.testfrm.testoptionvalue.value;
	  }
	}*/
}
function Select_UnWyze(){
	var id    =parseInt(document.testfrm.nextid.value);
	var count =parseInt(document.testfrm.numrows.value);
	if(document.testfrm.testoptionvalue.value == 0){
		if(document.testfrm.btncancel.value){
		document.testfrm.testoptionvalue.value = 1;
		}
	}else{
		if(document.testfrm.btncancel.value){
			document.testfrm.testoptionvalue.value = document.testfrm.testoptionvalue.value+","+0;
		}else{
			document.testfrm.testoptionvalue.value = document.testfrm.testoptionvalue.value;
		}	
	}
	document.testfrm.btnsubmit.disabled = true;
	/*if(document.testfrm.btncancel.value){
	  if(document.testfrm.testoptionvalue.value != 0){
		//document.testfrm.testoptionvalue.value = document.testfrm.testoptionvalue.value+","+document.testfrm.btncancel.value;
		document.testfrm.testoptionvalue.value = document.testfrm.testoptionvalue.value+","+0;
	  }else{
	   // document.testfrm.testoptionvalue.value = document.testfrm.btncancel.value; //+","+document.testfrm.testoptionvalue.value;
		 document.testfrm.testoptionvalue.value = document.testfrm.testoptionvalue.value; //+","+document.testfrm.testoptionvalue.value;
	  }
	}*/
}
function validate(){
 if(!document.testfrm.testoptionvalue.value){
	if(confirm("You haven't answered this question. Do you wish to continue?")) {	
		document.testfrm.action="wyze_game.php";
		document.testfrm.submit();
	}
 }else {
		document.testfrm.action="wyze_game.php";
		document.testfrm.submit();
 }
	//document.testfrm.action="wyze_game.php";
	//document.testfrm.method="POST";
	//document.testfrm.submit();
}
</script>
<table width="100%"  border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">
      <table width="760"  border="0" cellspacing="1" cellpadding="1">
        <tr>
          <td align="center"><form name="frmgame" method="post" action="">
		  <select name="scenario_id" class="txt_listbox" id="scenario_id" onChange="Select_Scenario();">
             <option value="" selected="selected">Select Scenario</option>
              <?php
			$query_select="select scenario_id, scenario_name from ".TABLE_SCENARIO." WHERE scenario_status = 1 AND scenario_isdeleted=0";
			$rs_select = mysql_query($query_select);
			while ($row_scen=mysql_fetch_array($rs_select)){
				if ($row_scen["scenario_id"]<>$scenario_id)
					echo '<option value="' . $row_scen["scenario_id"].'">' . $row_scen["scenario_name"].'</option>';
				else
					echo '<option value="' . $row_scen["scenario_id"].'" selected> ' . $row_scen["scenario_name"].'</option>';
			}	
		?>
          </select></form></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
  <td align="center">&nbsp;</td>
  </tr>
  <?php $k=0;		
  if($scenario_id ) { 
	if($_SESSION["session_questionids"]) {
  ?>
	<tr>
	<td align="center" class="para1"><form name="testfrm" method="post" action="">
	  <table width="760"  border="0" cellspacing="2" cellpadding="2">
	<?php 	
		if($questionids[$i]){
		$sql =  "SELECT * from ".TABLE_QUESTION." where scenario_fk_id = ".$scenario_id." AND question_status = 1 AND question_isdeleted=0 and question_id='$questionids[$i]'";
		//Questionids that are appeared for the Student
			if($answeredqid) {
				$answeredqid = $answeredqid.",".$questionids[$i]; 
			}else{
				$answeredqid = $questionids[$i];
			}
			$result     =  $db->query($sql);
			$row        =  $db->fetch_array($result);
			$question   =  $row["question_name"]; 
			$answer     =  $row["question_answer"];
			$img	    =  $row["question_image"];
	?>
	<!------------ Question ------------>
	<tr>
	  <td colspan="2"><?php echo $question; ?>
	  </td>
	</tr>
	<!-- Option -->
	<tr>
	<?php if($row['question_image']) {?>
	  <td width="51%" valign="top"><img src="<?php echo 'question_images/'.$img; ?>" border="0"></td>	
	<?php } ?>
	  <td width="49%"><input type="button" name="btnsubmit" value="Wyze" onClick="Select_Wyze();">	</td>
	</tr>
	<tr>
	  <td width="51%">&nbsp; </td>
	  <td width="49%">
	  <input name="btncancel" type="button" id="Cancel" value="Unwyze" onClick="Select_UnWyze();"></td>
	</tr>
	<tr>
	  <td colspan="2">
		  <input type="hidden" name="nextid" value="<?php echo ++$i;?>">
		  <input type="hidden" name="numrows" value="<?php echo $rows;?>">
		  <input type="hidden" name="answeredqid"	value="<?php echo $answeredqid;?>">
    	  <input type="hidden" name="scenario_id" value="<?php echo $scenario_id; ?>">
		  <?php if($_POST["testoptionvalue"]){ $testoptionvalue=$_POST["testoptionvalue"]; }
				else {  $testoptionvalue="0"; }
		  ?>
		  <input type="hidden" name="testoptionvalue" value="<?php echo $testoptionvalue;?>">
		  <input type="hidden" name="test" value="1">
		  <input type="hidden" name="remainquestions" value="<?php echo $remain_questions;?>">
	  </td>
	</tr>
	<tr>
	  <td><input name="btntest" type="button" onClick="javascript : history.go(-1);" value="Previous"></td>
	  <td align="right"><input name="btntest" type="button" onClick="javascript : validate();" value="Next"></td>
	  	</tr>	
	<?php  }else{  ?>
	<tr>
	<td align="center" colspan="2"><strong><font color="#666666">You have completed this test successfully.<bR></font></strong></td>
	</tr>
	<?php } ?>
	</table>
	</form></td>
	</tr>	
	<?php } else { ?>
	
	<?php }  //end of checking availability of question
	} else { ?>
	<tr>
	<td class="para">&nbsp;</td>
	</tr>
	<?php  }  ?>	
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
</table>
</html>