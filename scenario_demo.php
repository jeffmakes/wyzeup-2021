<?php 
	session_start();
	require_once('conf/conf.inc.php');
	
	# To register session for Question ids
	#session_register("session_questionids");
	
	# To Initailize the dbclass
	$db 	  = new dbclass1();
	$scenario_id = $_POST['scenario_id'];	
	
	# To display the contents of each sequences
	if($scenario_id){
		$sql = "SELECT question_id,scenario_fk_id,question_name,question_option1,question_option2,question_option3,question_option4,question_answer,question_image,question_rank,question_status FROM wyzeup_questionsdemo WHERE scenario_fk_id = ".$scenario_id." AND question_status = 1 AND  question_isdeleted=0 ORDER BY question_rank"; 
		$query_result 	   = db_execute_query($sql);
			while($row = mysqli_fetch_array($query_result)){ 
				  $arr_id[] = $row['question_id'];
				  $scenario_id = $row['scenario_fk_id'];
			  }
			  $total_questions = count($arr_id);
			  $mailcount = count($arr_id)- 1;
			  for($j=0;$j<$mailcount;$j++) {
			  $rank_val .= $arr_id[$j].",";  }
			 $rank_val .=$arr_id[$mailcount]; 
			$_SESSION["session_questionids"] = $rank_val;
	}
	
	if($_SESSION["session_questionids"]) {  
		$questionids    =  explode(",",$_SESSION["session_questionids"]);
		$tmpquestionids =  implode(",",$questionids);
		$rows           =  sizeof($questionids);
	}
	$i = 0; $j = 0;$k = 0;	$ans = '';
	 
?>
<!--!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd"-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Wyze Up - Scenario</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<SCRIPT language=Javascript src="divpos.js"></SCRIPT>
<link href="wyzeup_css/scenario.css" rel="stylesheet" type="text/css"/>
<link href="example/dtr/headings.css" rel="stylesheet" type="text/css" />
<script language="javascript"type="text/javascript">
function Select_Scenario(){
	if(document.frmgame.scenario_id.value ==''){
		document.frmgame.action="scenario_demo.php";
	}else{
		document.frmgame.action="scenario_demo.php?formaction=next";
	}
	document.frmgame.method="POST";
	document.frmgame.submit();
}
function Wyze_Answer(data){
 	var value = 0;
	var currentid = parseInt(document.getElementById("currentid").value);
	var dispid 	  = parseInt(document.getElementById("displayid").value);
	var flag 	  = parseInt(document.getElementById("flag").value);
    console.log("Answer button clicked");
    console.log("currentid " + currentid + " displayid " + dispid + " flag " + flag);
	if(document.getElementById("nextid").value < 4) {
		if(data == "Wyze"){		
			var url_w = "scenario_score_demo.php?answer="+data+"&questid="+currentid+"&displayid="+dispid+"&fg="+flag;
			var value = 1;
		}else if(data == "Unwyze") {
			var url_w = "scenario_score_demo.php?answer="+data+"&questid="+currentid+"&displayid="+dispid+"&fg="+flag;		
			var value  = 1;
		}
		if(value == 1){ 
			var xmlhttp = false;
			if (window.XMLHttpRequest) {
					xmlhttp = new XMLHttpRequest();
			}
			// If the user is using IE
			else if (window.ActiveXObject) {
					xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}		
			if(document.getElementById("currentid").value > 0 ){ 
					xmlhttp.open('GET', url_w, true);
					xmlhttp.onreadystatechange = function() {
						if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
							/**
							* Getting AJAX XML response 
							*/	
							document.getElementById("content_center2").style.display 	  = '';	
							document.getElementById("demo_loaderimage").style.display	  = '';		
                            var response     = xmlhttp.responseText.split("@##@"); 
							document.getElementById("display").style.display = '';
							//alert(response);
							if(response!=""){
								if(response[1]=='Yes'){
									document.getElementById("demo_loaderimage").src   	= "wyzeup_images/"+response[0];	
								}
								if(response[1]=='Yes'){
									document.getElementById("display").innerHTML   	= '<img src="wyzeup_images/img-correct.gif" width="91" height="28" id="dispimg">';
									document.getElementById("answer").value		= response[1];

								}
								else if(response[1]=='No'){
									document.getElementById("display").innerHTML   	= '<img src="wyzeup_images/img-wrong.gif" width="91" height="28" id="dispimg">';
									document.getElementById("answer").value		= response[1];
								}
								//else
									//document.getElementById("display").innerHTML   	= '<img src="wyzeup_images/spacer.gif" width="91" height="28" id="dispimg">';							
								if(response[2] >= 4){
									document.getElementById("displayid").value   	= '4';	
									
								}else{
									document.getElementById("displayid").value   	= response[2];		
								}						
								document.getElementById("flag").value 		 	    = response[3];						
							} else {
								document.getElementById("display").innerHTML   		= '';
								document.getElementById("answer").value				= '';
								document.getElementById("displayid").value   		= '0';
								document.getElementById("flag").value				= '';
							}
						}
					} 
					xmlhttp.send(null); 
			} else {
				document.getElementById("answer").value				= '';
				document.getElementById("display").innerHTML   		= '';
				document.getElementById("displayid").value   		= '0';
				document.getElementById("flag").value				= '1';
				
			}
		}		
	}					
}

function NextContent(order){ 
	var ajax = 0;
	var next_val  = parseInt(document.getElementById("nextid").value);
	var total	  = parseInt(document.getElementById("totalcnt").value);
	InitialiseScrollableArea();
 	if(order=="previous"){
			var previousid = parseInt(document.getElementById("nextid").value)-1;
			if(previousid >=0){
				var url = "Wyzeup_XMLresponse_demo.php?id="+previousid;
				var ajax = 1;
 			}  
 	}else { 	
		if(document.getElementById("answer").value != ''){
				if(document.getElementById("nextid").value < 3) { 
					var nextid = parseInt(document.getElementById("nextid").value) + 1;				
					var url = "Wyzeup_XMLresponse_demo.php?id="+nextid;		
					var ajax = 1;
				 }else{
					if(document.getElementById("nextid").value == 3){
						var nextid = parseInt(document.getElementById("nextid").value) + 1;
						var scenarioid = parseInt(document.getElementById("scenarioid").value);	
						var url = "Wyzeup_XMLresponse_demo.php?sid="+scenarioid;						
						var ajax = 1;
					}else{
						return false;
					}
				} 
		}else {	//document.getElementById("answer").value =='';
				if(document.getElementById("nextid").value <= 3){
					alert('You have to select wyze or unwyze.'); 
					return false;
				}
			//alert('You have already reached the final question.'); 
			//return false;
		}
	}
	if(ajax == 1){
		document.getElementById("loading").style.display 		 = "";
		document.getElementById("content_center1").style.display = "none";
		
		var xmlhttp = false;
		if (window.XMLHttpRequest) {
				xmlhttp = new XMLHttpRequest();
		}
		// If the user is using IE
		else if (window.ActiveXObject) {
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}		
 		if(document.getElementById("nextid").value >= 0 && document.getElementById("nextid").value <=2 ){ 
				xmlhttp.open('GET', url, true);
				xmlhttp.onreadystatechange = function() {
					if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
						/**
						* Getting AJAX XML response 
						*/				
						document.getElementById("loading").style.display 		 = "none";
						//document.getElementById("first_demo_image").style.display = "none";
						document.getElementById("content_center1").style.display = "";
						var response 	 = xmlhttp.responseText.split("@##@");				
						if(document.getElementById("nextid").value == 4) {
							document.getElementById("demo_image").style.display	  = "";
						}
						if(response!=""){
								document.getElementById("display").innerHTML = '';
								document.getElementById("demo_title").innerHTML   = response[0];
								document.getElementById("demo_content").innerHTML = response[1];
								if(response[2] !=""){									
									document.getElementById("demo_image").style.display = "";
									document.getElementById("demo_image").src   	= "scenario_images/"+response[2];			
								}else{
									document.getElementById("demo_image").style.display = "none";
								}			
								document.getElementById("currentid").value 		  = response[3];				
								document.getElementById("nextid").value 		  = response[4];
								document.getElementById("flag").value 		 	  = '0';
								document.getElementById("answer").value			  = '';			
						} /*else {
							document.getElementById("loading").style.display  = "none";
							document.getElementById("demo_title").innerHTML   = "";
							document.getElementById("demo_image").style.display	  = "none";
							document.getElementById("demo_loaderimage").style.display	  = "none";
							document.getElementById("demo_content").innerHTML 	 ='';
							document.getElementById("demo_content").innerHTML = "Thanks for participating.Try and choose another scenario from the drop down";							
							document.getElementById("nextid").value 		  = '4';
							document.getElementById("flag").value 		 	  = '0';
							document.getElementById("display").style.display  = '';
						}*/
					}
				} 
				xmlhttp.send(null); 
		} else if(document.getElementById("nextid").value == 3) {
				xmlhttp.open('GET', url, true);
				xmlhttp.onreadystatechange = function() {
					if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
						/**
						* Getting AJAX XML response 
						*/				
						document.getElementById("loading").style.display 		 = "none";
						//document.getElementById("first_demo_image").style.display = "none";
						document.getElementById("content_center1").style.display = "";
						var response 	 = xmlhttp.responseText.split("@##@");				
						if(document.getElementById("nextid").value == 4) {
							document.getElementById("demo_image").style.display	  = "";
						}
						if(response!=""){ 
								document.getElementById("display").innerHTML = '';
								document.getElementById("demo_title").innerHTML   = response[0];
								document.getElementById("demo_explanation").innerHTML = response[1];
								document.getElementById("demo_content").innerHTML = response[2];	
								if(response[3] !=""){									
									document.getElementById("demo_image").style.display = "";
									document.getElementById("demo_image").src   	= "scenario_images/"+response[3];			
								}else{
									document.getElementById("demo_image").style.display = "none";
								}				
								document.getElementById("nextid").value 		  = response[4];
								document.getElementById("flag").value 		 	  = '0';	
								document.getElementById("answer").value			  = '';	
						}
					}
				} 
				xmlhttp.send(null); 
			/*document.getElementById("loading").style.display   = "none";
			//document.getElementById("demo_content").innerHTML = "Thanks for participating.Try and choose another scenario from the drop down";
			//document.getElementById("content_body").innerHTML = "Welcome to Wyze Up Demo. Please select a Scenario from the drop down above";
			document.getElementById("nextid").value 		  = '4';
			document.getElementById("flag").value 		 	  = '0';
			document.getElementById("display").style.display  = '';*/
		}

	}
}
</script>
</head>
<body onload="InitialiseScrollableArea();">
<div id="main">
<div id="scenario_top">
<div id="scenario_list">
<form id="frmgame" name="frmgame" method="post" action="">
   <select name="scenario_id" id="scenario_id" onChange="javascript : Select_Scenario();">
     <option value="" selected="selected">Select Scenario</option>
              <?php
			global $con;
			$scenario_select="select scenario_id, scenario_name from wyzeup_scenariosdemo WHERE scenario_status = 1 AND scenario_isdeleted=0";
			$scenario_result = mysqli_query($con, $scenario_select);
			while ($scenario_row=mysqli_fetch_array($scenario_result)){
				if ($scenario_row["scenario_id"]<>$scenario_id)
					echo '<option value="' . $scenario_row["scenario_id"].'">' . $scenario_row["scenario_name"].'</option>';
				else
					echo '<option value="' . $scenario_row["scenario_id"].'" selected> ' . $scenario_row["scenario_name"].'</option>';
			}	
		?>
   </select>
</form>
</div>
</div>
<div id="content">
<div id="content_left"></div>
<div id="content_center">
<div id="content_body">
	<div id="loading" style="display:none; background-color:#46C3FD; width:650px"><img src="wyzeup_images/ajax-loader.gif"/></div>	 
	<?php  if($scenario_id) {  ?>
	<div id="content_center1">
		<?php 			 
			if($_SESSION["session_questionids"]) {  
			 if($questionids[$i]){
				$sql = "SELECT scenario_id,question_id,scenario_name,question_name,question_answer,question_image FROM wyzeup_scenariosdemo,wyzeup_questionsdemo WHERE scenario_fk_id = ".$scenario_id." AND scenario_id = scenario_fk_id AND question_status = 1 AND question_isdeleted=0 AND question_id = $questionids[$i]";
					$result     =  $db->query($sql);
					$row        =  $db->fetch_array($result);
					$question   =  $row["question_name"]; 
					$answer     =  $row["question_answer"];
					$img	    =  $row["question_image"];
					
  ?>
		<!--h1 id=""><?php  //$scenarioname = $row["scenario_name"]; echo '<img id="demo_title"  src="imagecreation.php?text='.$scenarioname.'">';  //echo $row["scenario_name"];?></h1-->
		<div id="demo_title"><?php echo $row["scenario_name"];?></div>
		<?php if($row["question_image"]){?>
		<img src="scenario_images/<?php echo $row["question_image"];?>" id="first_demo_image" />		
		<?php } ?>
		<img src="scenario_images/<?php echo $row["question_image"];?>" id="demo_image"  style="display:none; "/>
		<input type="hidden" name="testoptionvalue" value="<?php echo $testoptionvalue;?>">
		<input type="hidden" name="currentid" id="currentid" value="<?php echo $row["question_id"];?>" />
		<input type="hidden" name="nextid" id="nextid" value="<?php echo $i; ?>">	
		<input type="hidden" name="scenarioid" id="scenarioid" value="<?php echo $scenario_id;?>" />
		<input type="hidden" name="flag" id="flag" value="<?php echo $flag; ?>" />
		<input type="hidden" name="answer" id="answer" value="<?php echo $ans; ?>">
		<input type="hidden" name="totalcnt" id="totalcnt" value="<?php echo $mailcount; ?>" />
 		<div id="demo_explanation"></div>
		<div id="demo_content"><?php echo stripslashes(str_replace(chr(13),"<br />",$row["question_name"]));?></div>		
	<?php } } ?>	
	</div>
	<?php }else{ ?>

	<div id="content_center1">
		<div class="content_center_home">
			<img src="wyzeup_images/scenario-demo-text.gif" alt="welcome to wyze up please select a scenario to start!" title="welcome to wyze up please select a scenario to start!" />
		</div>
	</div>

	<?php } ?>
	
</div>
<?php if($_GET["formaction"]=="next"){ ?>
<div id="content_center2" style="padding:3px 0px 0px 0px"><img src="wyzeup_images/score0.gif" id="demo_loaderimage" title="Progress bar" /></div>
<?php } ?>
<div id="content_center2" style="display:none;"> 
<?php if($row_img["score_image"]!=""){?>
<img src="wyzeup_images/<?php  echo $row_img["score_image"];?>" width="26" height="332" id="demo_loaderimage" title="Progress bar" />
<?php } //else { ?>
<!--img src="wyzeup_images/score_img1.jpg" width="26" height="332" id="demo_loaderimage" title="Progress bar" /-->
<?php //--} ?>
</div>
</div>
<div id="content_right">
	<div id="scroll">
		<div id="text">
			Scroll Up
			<a class="fl_up" href="#" title="UP" onmouseover="javascript:PerformScroll(-7);" onmouseout="javascript:CeaseScroll();">Scroll Up</a>
			<a class="fl_down" href="#" title="DOWN" onmouseover="javascript:PerformScroll(7);" onmouseout="javascript:CeaseScroll();">Scroll Down</a>
			Scroll Down
	</div><br />
	<div id="display">
		<img src="wyzeup_images/spacer.gif" width="91" height="28" id="dispimg">
	</div><input type="hidden" name="displayid" id="displayid" value="<?php echo $j; ?>">
	
</div>

<?php if($scenario_id) {?>
	<div class="spanholder">
		<ul class="areas">
			<li id="wyzeshow"><a class="fl_wyze" href="#" style="cursor:pointer" title="Wyze" onClick="javascript:Wyze_Answer('Wyze');">wyze</a></li>
			<li id="unwyzeshow"><a class="fl_unwyze" href="#" style="cursor:pointer" title="Unwyze" onClick="javascript:Wyze_Answer('Unwyze');">Unwyze</a></li>
		</ul>
	</div>		
<?php } ?>
	</div>
</div>
		<div id="scenario_bottom">
				<div id="mainmenu">
					<ul>
						<!--li id="mm1"><a  style="cursor:pointer"onclick="javascript:NextContent('previous');" title="previous">Previous</a></li-->
						<?php if($scenario_id) {?>
						<li id="mm2"><a  style="cursor:pointer" onclick="javascript:NextContent('next');" title="next">next</a></li>																									
						<?php } ?>
					</ul>
				</div>
		</div>

</div>
</body>
</html>
<?php ob_end_flush(); ?>
