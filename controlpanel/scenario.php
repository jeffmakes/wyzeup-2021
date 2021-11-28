<?php 
	ob_start();
	session_start();
	require_once('../conf/conf.inc.php');
	require_once('../dao/scenario_dao.php');
	
	#User Existence validation
	$url = URL_ADMIN_LOGIN_REQUIRED;
	if(!check_admin_exist()){	  
	  html_refresh($url);
	}	
	$menuactive="SCENARIOS";
	
	#Object Instantiation for Scenario typeDAO
	$scenario  			  =  new ScenarioDO();
	$scenario_dao         =  new ScenarioDAO(); 
	
	//$action		= $_GET["formaction"];
	$submit			= trim($_GET['action']);
	$scenario_id	= $_GET["scenario_id"];
	# Scenarios Details
	$scenario->scenario_id		= trim($_POST['scenario_id']);	 
	$scenario->scenario_name 	= trim($_POST["scenario_name"]);
	$scenario->scenario_desc	= trim($_POST["scenario_desc"]);
	$scenario->scenario_image	= trim($_FILES["scenario_image"]["name"]);
	$scenario->scenario_status	= $_POST["scenario_status"];
	$submit 		        	= $_POST['action1'];

	#Add operation check
	if(empty($submit) && empty($_POST['scenario_id'])) {
		$scenario_id	=	trim($_GET['scenario_id']);	
		$submit		    =	trim($_GET['action']);	
	}
	if (empty($submit)) {
 		  define('SUBMIT_BUTTON', BUTTON_ADD); 
		  $submit = "add";
	}
	if ($submit == BUTTON_ADD) {
		define('SUBMIT_BUTTON', BUTTON_ADD);		
		$error_messages             = $scenario_dao->Scenario_Create($scenario);
		 if (!$error_messages) { 
		 	unset($scenario);
			unset($scenario_dao);
			html_refresh("scenario_view.php");
		 } 
 	  } 
	   if ($submit == BUTTON_EDIT) {
			define('SUBMIT_BUTTON', BUTTON_EDIT); 		
 			$error_messages   =  $scenario_dao->Scenario_Update($scenario);
 			if (!$error_messages) {			
				html_refresh("scenario_view.php");
			}	
	  } 
	  if ($submit == "edit" || $submit == "view") {
			define('SUBMIT_BUTTON', BUTTON_EDIT); 
			$submit = SUBMIT_BUTTON;	
			$scenario	= $scenario_dao->Scenario_Read($scenario_id);
 	} 
	  if ($submit == "delete") {
			$scenario_dao->Scenario_Delete($scenario_id);
			html_refresh("scenario_view.php");
	  }	
	  if($submit == "add"){
		$submit = SUBMIT_BUTTON;
	  }	
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
	var form_name = document.frmscenario;	
	if(TextValidate(form_name.scenario_name,"the scenario name")==false){return false;}	
	if(TextValidate(form_name.scenario_desc,"the scenario description")==false){return false;}
//	if(TextValidate(form_name.scenario_image,"the scenario image")==false){return false;}
//alert(form_name.scenario_status.checked);
	if(form_name.scenario_status.checked==true){
		form_name.scenario_status.value = 1;			
	} else if(form_name.scenario_status.checked==false) {
		form_name.scenario_status.value = 0;
	}//alert(form_name.scenario_status.value);
	form_name.action = "scenario.php";
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
        <td valign="top">
		 <table width="95%" border="0" align="center" cellpadding="4" cellspacing="1">
              <tr>
                <td align="left"><span class="h1"><?php if($_GET["action"]!="view"){ echo "Add/Modify"; } else { echo "View"; }?> Scenario Details </span></td>
                <td align="left" class="paragraph"><a href="scenario_view.php">View Scenarios</a></td>
              </tr>
              <tr>
                <td colspan="2" align="center"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
			    <?php if($_GET["action"]!="view"){?>
                  <tr>
                    <td bgcolor="#C5C5C5"> <form name="frmscenario" method="post" action="" enctype="multipart/form-data">
				    <table width="100%"  border="0" cellspacing="1" cellpadding="4">
				      <tr align="left" bgcolor="#FFFFFF">
				        <td colspan="2" valign="top" class="h1">&nbsp;</td>
				        </tr>
				      <tr>
                        <td width="32%" align="right" valign="top" bgcolor="#EFEFEF" class="paragraph"><span class="mandatory">*&nbsp;</span> Scenario Name :</td>
                        <td valign="top" bgcolor="#FFFFFF" class="paragraph"><input name="scenario_name" type="text" class="txtbox" id="scenario_name" value="<?php echo $scenario->scenario_name;?>">
                          <?php if($error_messages["scenario_name"]){ echo "<span class='errormessage'>".$error_messages["scenario_name"]."</span>";}?>
                        </td>
				        </tr>
				      <tr>
                        <td align="right" valign="top" bgcolor="#EFEFEF" class="paragraph"><span class="mandatory">* </span> Scenario Explanation : </td>
                        <td valign="top" bgcolor="#FFFFFF" class="paragraph"><textarea name="scenario_desc" cols="30" rows="5" class="txtbox" id="scenario_desc"><?php echo $scenario->scenario_desc;?></textarea></td>
				        </tr>
						<?php if($scenario->scenario_image){ ?>
						<?php } ?>
					     <tr>
                          <td align="right" valign="top" bgcolor="#EFEFEF" class="paragraph">Scenario Status :<br>
                            [Check to activate the Scenario] </td>
                          <td width="68%" valign="top" bgcolor="#FFFFFF" class="paragraphred"><input type="checkbox" name="scenario_status"  id="scenario_status" value="0" <?php if($scenario->scenario_status) { echo "checked"; }?>>
						  <?php echo $error_messages["scenario_status"];?>
						  
						</td>
                          </tr>
                        <tr>
                          <td bgcolor="#EFEFEF" class="paragraph">&nbsp;</td>
                          <td valign="top" bgcolor="#EFEFEF" class="paragraph">
						   <input name="action1" type="hidden" id="action1" value="<?php echo $submit;?>">						
						  <input name="scenario_id" type="hidden" id="scenario_id" value="<?php echo $scenario->scenario_id;?>">
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
				        <td width="69%" bgcolor="#FFFFFF" class="paragraph"><?php echo $scenario->scenario_name;?></td>
				        </tr>
				      <tr>
				        <td align="right" valign="top" bgcolor="#EFEFEF" class="paragraph">Scenario Description : </td>
				        <td bgcolor="#FFFFFF" valign="top" class="paragraph">
                          <?php echo  nl2br($scenario->scenario_desc);?>
                        </td>
				        </tr>					  
				      <tr>
				        <td align="right" valign="top" bgcolor="#EFEFEF" class="paragraph">Scenario Status : </td>
				        <td bgcolor="#FFFFFF" valign="top" class="paragraph"><?php if($scenario->scenario_status){ echo "Active";} else { echo "Inactive";} ?></td>
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
 