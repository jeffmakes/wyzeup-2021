<?php 
	ob_start();
	session_start();
	require_once('../conf/conf.inc.php');
	require_once('../dao/question_dao.php');
	
	#User Existence validation
	$url = URL_ADMIN_LOGIN_REQUIRED;
	if(!check_admin_exist()){	  
	  html_refresh($url);
	}	
	$menuactive="QUESTIONS";
	
	#Object Instantiation for Scenario typeDAO
	$question  			  =  new QuestionDO();
	$question_dao         =  new QuestionDAO(); 
	
	$submit			= trim($_GET['action']);
	$scenario_id	= $_GET["scenario_id"];
	
	# Scenarios Details
	$question->question_id		= trim($_POST['question_id']);	 
	if($_POST["scenario_foreign"]){
		$question->scenario_fk_id 	= trim($_POST["scenario_foreign"]);
	}else{
		$question->scenario_fk_id 	= trim($_POST["scenario_fk_id"]);	
	}
	$question->question_name	= trim($_POST["question_name"]);
	$question->question_option1	= trim($_POST["question_option1"]);
	$question->question_option2	= trim($_POST["question_option2"]);
	$question->question_option3	= trim($_POST["question_option3"]);
	$question->question_option4	= trim($_POST["question_option4"]);
	$question->question_answer	= trim($_POST["question_answer"]);		
	$question->question_image	= trim($_FILES["question_image"]["name"]);
	$question->question_rank	= trim($_POST["question_rank"]);	
	$question->question_status	= trim($_POST["question_status"]);
	$submit 		        	= $_POST['action1'];

	#Add operation check
	if(empty($submit) && empty($_POST['question_id'])) {
		$question_id	=	trim($_GET['question_id']);	
		$submit		    =	trim($_GET['action']);	
	}
	if (empty($submit)) {
 		  define('SUBMIT_BUTTON', BUTTON_ADD); 
		  $submit = "add";
	}
		
	if ($submit == BUTTON_ADD) {
		define('SUBMIT_BUTTON', BUTTON_ADD);		
		 if ($error_messages != 0) { 
			if($_POST["scenario_fk_id"]){
				 $qry ="SELECT count(*)as total FROM wyzeup_questions WHERE question_isdeleted=0 AND scenario_fk_id=".$question->scenario_fk_id;
			}else{
				$qry ="SELECT question_id,scenario_fk_id,question_name, question_option1,question_option2,question_option3,question_option4,question_answer,question_image,question_status FROM safe_questions WHERE question_isdeleted=0 AND scenario_fk_id=".$_POST["scenario_id"];
			}						
			$rs = mysql_query($qry);
			$row = mysql_fetch_array($rs);
			//$cnt = mysql_num_rows($rs);
		}
		
		if($row['total'] < 4){ 
			$error_messages        = $question_dao->Question_Create($question);
		}else{ 
			$error_messages['quest_count']="Sorry , Already 4 questions has been entered for this Scenario.";
		} 
		 if (!$error_messages) { 
		 	unset($question);
			unset($question_dao);
			html_refresh("question_view.php");			
		 } 
 	  } 
	   if ($submit == BUTTON_EDIT) {
			define('SUBMIT_BUTTON', BUTTON_EDIT); 		
 			$error_messages   =  $question_dao->Question_Update($question);
 			if (!$error_messages) {		
			 	unset($question);
				unset($question_dao);		
				html_refresh("question_view.php");			
			}	
	  } 
	  if ($submit == "edit" || $submit == "view") {
			define('SUBMIT_BUTTON', BUTTON_EDIT); 
			$submit = SUBMIT_BUTTON;	
			$question	= $question_dao->Question_Read($question_id);
 	} 
	  if ($submit == "delete") {
			$question_dao->Question_Delete($question_id);
			html_refresh("question_view.php");
				//if($_GET["scenario_id"]){		
					//html_refresh("question_view.php?scenario_id=".$_GET["scenario_id"]);
				//}
		  }	
	  if($submit == "add"){
		$submit = SUBMIT_BUTTON;
	  }	
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Wyze Up</title>

<script language="JavaScript" type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script> 
<link href="../wyzeup_css/ricoLiveGrid.css" type="text/css" rel="stylesheet" />
<script src="../includes/prototype.js" type="text/javascript"></script>
<script src="../includes/ricoCommon.js" type="text/javascript"></script>
<script src="../includes/ricoLiveGrid.js" type="text/javascript"></script>
<script language="JavaScript" src="../includes/formvalidation.js"></script>
<script type="text/javascript">
var customerGrid, ex3, detailGrid;
function bodyOnLoad() {
  //var opts = {  columnSpecs   : [{canSort:false,canHide:false}], headingRow    : 0, frozenColumns : 0, prefetchBuffer: true };
  /*
  var opts = {  specDate      : {type:'date',canFilter:true},
                columnSpecs   : [,,,,,],
                headingRow    : 0,
                frozenColumns : 0,
                prefetchBuffer: true
             }; 
	*/
	var opts = {  
                headingRow    : 0,
                frozenColumns : 0,
                prefetchBuffer: true
             }; 			  
  //var opts = {  };
  // -1 on the next line tells LiveGrid to determine the number of rows based on window size
 // ex3=new Rico.LiveGrid ('ex3', 10, 100, 'products_xmlquery.php',opts);
}
function setFilter() {
//
}
function keyfilter(txtbox,idx) {
  ex3.columns[idx].setFilter('LIKE',txtbox.value+'%',Rico.TableColumn.USERFILTER,function() {txtbox.value='';});
}

function validate() {
	var form_name = document.frmquestion;	
	if(SelectValidate(form_name.scenario_foreign,"the scenario name")==false){return false;}
	if(TextValidate(form_name.question_name,"the question name")==false){return false;}	
	/*if(TextValidate(form_name.question_option1,"the option1")==false){return false;}
	if(TextValidate(form_name.question_option2,"the option2")==false){return false;}
	if(TextValidate(form_name.question_option3,"the option3")==false){return false;}
	if(TextValidate(form_name.question_option4,"the option4")==false){return false;}*/
	/*if(form_name.action1.value != 'Modify'){
		if(TextValidate(form_name.question_image,"the image")==false){return false;}
	}*/
	if(SelectValidate(form_name.question_rank,"the rank")==false){return false;}
	if(form_name.question_status.checked==true){
		form_name.question_status.value = 1;			
	} else {
		form_name.question_status.value = 0;
	}
	form_name.action = "question.php";
	form_name.submit();
}

</script>
<style type="text/css">
/*input { font-weight:normal;font-size:8pt;}*/
th div.ricoLG_cell { height:2.5em; }  /* the text boxes require a little more height than normal */
</style>
<link href="../wyzeup_css/admin_wyze_up.css" rel="stylesheet" type="text/css">
</head>
<body onload="bodyOnLoad()">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="234" height="20"><img src="../wyzeup_images/wyzeup.JPG" width="191" height="66"></td>
        </tr>
      <tr>
        <td height="20"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="left" class="menu">&nbsp;&nbsp;Hello <?php echo $_SESSION["session_adminname"];?>, Welcome to the Wyze Up Control Panel</td>
          </tr>
        </table></td>
      </tr>
	  <tr>
        <td valign="top">
				<div class="container">
				<ul id="navCircle">
				<!-- CSS Tabs -->
				<li><a <?php if($menuactive=="USERS") echo "class=\"active\"";?> href="users_view.php">Manage Staff</a></li>
				<li><a <?php if($menuactive=="SCHOOLS") echo "class=\"active\"";?> href="school_view_active.php">Manage Schools</a></li>
				<li><a <?php if($menuactive=="SCHOOLSNEW") echo "class=\"active\"";?> href="school_view.php">New Applications</a></li>
				<li><a <?php if($menuactive=="SCENARIOS") echo "class=\"active\"";?> href="scenario_view.php">Manage Scenarios</a></li>
				<li><a <?php if($menuactive=="QUESTIONS") echo "class=\"active\"";?> href="question_view.php">Manage Questions</a></li>
				<li><a <?php if($menuactive=="RENEWALS") echo "class=\"active\"";?> href="renewals_view.php">Manage Renewals</a></li>
				<li><a <?php if($menuactive=="PASSWORD") echo "class=\"active\"";?> href="changepassword_view.php">Change Password</a></li>
				<li><a href="logout.php">Logout</a></li>
				</ul>				
				</div>					
		</td>
      </tr>	 
      <tr>
        <td valign="top">          <table width="95%" border="0" align="center" cellpadding="4" cellspacing="1">
              <tr>
                <td align="left"><span class="h1"><?php if($_GET["action"]!="view"){ echo "Add/Modify"; } else { echo "View"; }?> Question Details </span></td>
               <?php //if($scenario_id){?>
			   		 <td align="left" class="paragraph"><a href="question_view.php">View Questions</a></td>
			  <?php //}else { ?>
				    <!--td align="left" class="paragraph"><a href="question_view.php?scenario_id=<?php echo $_POST["scenario_fk_id"]; ?>">View Questions</a></td-->
			   <?php //} ?>
              </tr>
              <tr>
                <td colspan="2" align="center"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
			    <?php if($_GET["action"]!="view"){?>
                  <tr>
                    <td bgcolor="#C5C5C5"> <form name="frmquestion" method="post" action="" enctype="multipart/form-data">
				    <table width="100%"  border="0" cellspacing="1" cellpadding="4">
				      <tr align="center" bgcolor="#FFFFFF">
				        <td colspan="2" valign="top" class="h1"><span class="paragraph">
				          <?php if($error_messages["quest_count"]){ echo "<span class='paragraphred'>".$error_messages["quest_count"]."</span>";}?>
				        </span></td>
				        </tr>
				      <tr>
                        <td width="32%" align="right" valign="top" bgcolor="#EFEFEF" class="paragraph"><span class="mandatory">*&nbsp;</span> Scenario Name :</td>
                        <td valign="top" bgcolor="#FFFFFF" class="paragraph">						
						<select name="scenario_foreign" class="txtbox" id="scenario_foreign">
                           <option value="" selected>Select Scenario</option>
                            <?php 
									$qry_scen = "SELECT scenario_id,scenario_name FROM ".TABLE_SCENARIO." WHERE scenario_isdeleted = 0 AND scenario_status = 1";
									$res_scen =mysql_query($qry_scen);						  		
									while ($rs_scen = mysql_fetch_array($res_scen)) { 																	
										 if($rs_scen[0] == $question->scenario_fk_id) {
											   echo '<option value='.$rs_scen[0].' selected>'.$rs_scen[1].'</option>';
										 }   else {
											   echo '<option value='.$rs_scen[0].'>'.$rs_scen[1].'</option>';
										 }
								   }
							  ?>
                          </select>
                          </td>
				        </tr>
				      <tr>
                        <td align="right" valign="top" bgcolor="#EFEFEF" class="paragraph"><span class="mandatory">* </span> Question  : </td>
                        <td valign="top" bgcolor="#FFFFFF" class="paragraph"><textarea name="question_name" cols="30" rows="8" class="txtbox" id="question_name"><?php echo stripslashes($question->question_name);?></textarea>
                          <?php if($error_messages["question_name"]){ echo "<span class='paragraphred'>".$error_messages["question_name"]."</span>";}?>                          
                         </td>
				        </tr>
				      <tr>
                        <td align="right" valign="top" bgcolor="#EFEFEF" class="paragraph"> Answer : </td>
                        <td valign="top" bgcolor="#FFFFFF" class="paragraph">
						<input name="question_answer" type="radio" value="Wyze" checked <?php if($question->question_answer == 'Wyze') echo 'checked'; ?>>
						&nbsp;Wyze&nbsp;<input name="question_answer" type="radio" value="Unwyze" <?php if($question->question_answer == 'Unwyze') echo 'checked'; ?>>&nbsp;Unwyze
						</td>
				        </tr>
						 <tr>
						   <td align="right" valign="top" bgcolor="#EFEFEF" class="paragraph">  Image </td>
						   <td valign="top" bgcolor="#FFFFFF" class="paragraph"><input name="question_image" type="file" class="txtbox" id="question_image" value="<?php $_REQUEST['question_image']; ?>">
                               <?php if($error_messages["question_image"]){ echo "<span class='errormessage'>".$error_messages["question_image"]."</span>";}?></td>
						 </tr>
						 <?php /*if($error_messages["question_image"]) {*/ if($_GET['action'] == 'edit'){ if($question->question_image){ ?>
						 <tr>
						   <td align="right" valign="top" bgcolor="#EFEFEF" class="paragraph">&nbsp;</td>
						   <td bgcolor="#FFFFFF" valign="top" class="paragraph"><img src="<?php echo '../scenario_images/'.$question->question_image;?>" border="0"></td>
						 </tr>
						 <?php } } //}?>
						 <tr>
                        <td align="right" valign="top" bgcolor="#EFEFEF" class="paragraph"><span class="mandatory">*</span> Sequence Number : </td>
                        <td valign="top" bgcolor="#FFFFFF" class="paragraph">
						<select name="question_rank" class="txtbox" id="question_rank">
                           <option value="" selected>Select Rank</option>
                            <?php 
									$qry_rank = "select rank_id,rank_value from ".TABLE_RANK." where rank_isdeleted = 0";
									$res_rank =mysql_query($qry_rank);						  		
									while ($rs_rank = mysql_fetch_array($res_rank)) { 																	
										 if($rs_rank[0] == $question->question_rank) {
											   echo '<option value='.$rs_rank[0].' selected>'.$rs_rank[1].'</option>';
										 }   else {
											   echo '<option value='.$rs_rank[0].'>'.$rs_rank[1].'</option>';
										 }
								   }
							  ?>
                          </select>
						<span class="paragraphred"><?php echo $error_messages["question_rank"];?></span></td>
				        </tr>
					     <tr>
                          <td align="right" valign="top" bgcolor="#EFEFEF" class="paragraph">Question  Status :<br>
                            [Check to activate the Question] </td>
                          <td width="68%" valign="top" bgcolor="#FFFFFF" class="paragraphred"><input type="checkbox" name="question_status" value="0" id="question_status" <?php if($question->question_status) { echo "checked"; }?>>
						  <?php echo $error_messages["question_status"];?>
						  
						</td>
                          </tr>
                        <tr>
                          <td bgcolor="#EFEFEF" class="paragraph">&nbsp;</td>
                          <td valign="top" bgcolor="#EFEFEF" class="paragraph">
						   <input name="scenario_fk_id" type="hidden" id="scenario_fk_id" value="<?php echo $question->scenario_fk_id;?>">						   
						   <input name="action1" type="hidden" id="action1" value="<?php echo $submit;?>">						
						  <input name="question_id" type="hidden" id="question_id" value="<?php echo $question->question_id;?>">
						  <input name="submitbtn" type="button" value="<?php echo SUBMIT_BUTTON;?>" onClick="javascript:validate();">
                          <input name="Reset" type="reset" value="Reset">
						  </td>
                          </tr>
                    </table>
				    </form></td>
                  </tr>
				  <?php } else {?>
			        <tr>
                    <td bgcolor="#C5C5C5"> 
				    <table width="100%"  border="0" cellspacing="1" cellpadding="4">
				      <tr>
				        <td width="31%" align="right" valign="top" bgcolor="#EFEFEF" class="paragraph">  Scenario Name :</td>
				        <td width="69%" bgcolor="#FFFFFF" class="paragraph"><?php $qry = "SELECT scenario_name  FROM wyzeup_scenarios  WHERE scenario_id =".$question->scenario_fk_id; $res =mysql_query($qry); $row = mysql_fetch_array($res); echo $row['scenario_name'];?></td>
				        </tr>
				      <tr>
				        <td align="right" valign="top" bgcolor="#EFEFEF" class="paragraph">Question  : </td>
				        <td bgcolor="#FFFFFF" valign="top" class="paragraph">
                          <?php echo $question->question_name;?>
                        </td>
				        </tr>				      
						<tr>
				        <td align="right" valign="top" bgcolor="#EFEFEF" class="paragraph">Answer  : </td>
				        <td bgcolor="#FFFFFF" valign="top" class="paragraph"><?php echo $question->question_answer;?></td>
				        </tr>	
						<?php if($question->question_image){  ?>		
				      <tr>
				        <td align="right" valign="top" bgcolor="#EFEFEF" class="paragraph">Question Image  : </td>
				        <td bgcolor="#FFFFFF" valign="top" class="paragraph"><img src="<?php echo '../scenario_images/'.$question->question_image;?>" border="0"></td>
				        </tr>		
						<?php } ?>			  
				      <tr>
				        <td align="right" valign="top" bgcolor="#EFEFEF" class="paragraph">Question  Status : </td>
				        <td bgcolor="#FFFFFF" valign="top" class="paragraph"><?php if($question->question_status){ echo "Active";} else { echo "Inactive";} ?></td>
				        </tr> 
                     </table>
				     </td>
                  </tr>
				  <?php } ?>
				  
              </table></td>
              </tr>
          </table></td>
      </tr>
      <tr>
        <td height="20" class="background_footer">&nbsp;</td>
      </tr>
      <tr>
        <td height="10" align="right" bgcolor="#7FA2B5" class="footer">
		&copy; Copyright 2007 Wyze Up. All rights reserved. </td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
 