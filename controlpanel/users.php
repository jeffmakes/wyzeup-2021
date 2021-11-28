<?php 
	header ("Pragma: no-cache");
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	session_start();
	require_once('../conf/conf.inc.php');
	require_once('../dao/user_dao.php');
	
	#User Existence validation
	$url = URL_ADMIN_LOGIN_REQUIRED;
	if(!check_admin_exist()){	  
	  html_refresh($url);
	}	
	$menuactive="USERS";
	
	#Object Instantiation for User typeDAO
	$user  			  =  new UserDO();
	$user_dao         =  new UserDAO(); 
	

	//$action		= $_GET["formaction"];
	$submit		= trim($_GET['action']);
	$users_id	= $_GET["users_id"];
	# Users Details
	
	$user->users_id			= trim($_POST['users_id']);	 
	$user->users_fname	 	= trim($_POST["users_fname"]);
	$user->users_lname		= trim($_POST["users_lname"]);
	$user->users_email		= trim($_POST["users_email"]);
	$user->users_username	= trim($_POST["users_username"]);
	$user->users_password	= trim($_POST["users_password"]);
	$user->users_status		= trim($_POST["users_status"]);
	$submit 		        = $_POST['action1'];

	#Add operation check
	if(empty($submit) && empty($_POST['users_id'])) {
		$users_id	   =	trim($_GET['users_id']);	
		$submit		   =	trim($_GET['action']);	
	}
	if (empty($submit)) {
 		  define('SUBMIT_BUTTON', BUTTON_ADD); 
		  $submit = "add";
	}
	if ($submit == BUTTON_ADD) {
		define('SUBMIT_BUTTON', BUTTON_ADD);		
		$error_messages             = $user_dao->User_Create($user);
		 if (!$error_messages) { 
		 	unset($user);
			unset($user_dao);
			html_refresh("users_view.php");
		 } 
 	  } 
	   if ($submit == BUTTON_EDIT) {
			define('SUBMIT_BUTTON', BUTTON_EDIT); 		
 			$error_messages   =  $user_dao->User_Update($user);
 			if (!$error_messages) {			
				html_refresh("users_view.php");
			}	
	  } 
	  if ($submit == "edit" || $submit == "view") {
			define('SUBMIT_BUTTON', BUTTON_EDIT); 
			$submit = SUBMIT_BUTTON;	
			$user	= $user_dao->User_Read($users_id);
 	} 
	  if ($submit == "delete") {
			$user_dao->User_Delete($users_id);
			html_refresh("users_view.php");
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
	var form_name = document.frmuser;	
	if(TextValidate(form_name.users_fname,"the first name")==false){return false;}	
	if(TextValidate(form_name.users_lname,"the last name")==false){return false;}
	if(TextValidate(form_name.users_email,"the email")==false){return false;}
	if(EmailValidate(form_name.users_email,"the email")==false){return false;}
	if(TextValidate(form_name.users_username,"the username")==false){return false;}
	if(TextValidate(form_name.users_password,"the password")==false){return false;}			
	if(TextValidate(form_name.users_cpassword,"the confirm password")==false){return false;}			
	if(form_name.users_password.value != form_name.users_cpassword.value){
			alert(" Please enter the confirm password same as password ");
			document.frmuser.users_cpassword.focus();
			return false;
		}
	
	if(form_name.users_status.checked==true){
		form_name.users_status.value = 1;			
	} else if(form_name.users_status.checked==false) {
		form_name.users_status.value = 0;
	}
	form_name.action = "users.php";
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
				<!--li><a <?php if($menuactive=="HOME") echo "class=\"active\"";?> href="school_view">Home</a></li-->				
				<li><a <?php if($menuactive=="USERS") echo "class=\"active\"";?> href="users_view.php">Manage Staff </a></li>
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
                <td align="left"><span class="h1"><?php if($submit!="view"){ echo "Add/Modify"; } else { echo "View"; }?> Staff Details </span></td>
                <td align="left" class="paragraph"><a href="users_view.php">View Users</a></td>
              </tr>
              <tr>
                <td colspan="2" align="center"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
			    <?php if($_GET["action"]!="view"){?>
                  <tr>
                    <td bgcolor="#C5C5C5"> <form name="frmuser" method="post" action="" enctype="multipart/form-data">
				    <table width="100%"  border="0" cellspacing="1" cellpadding="4">
				      <tr align="left" bgcolor="#FFFFFF">
				        <td colspan="2" valign="top" class="h1">&nbsp;</td>
				        </tr>
				      <tr>
                        <td align="right" valign="top" bgcolor="#EFEFEF" class="paragraph"><span class="mandatory">*&nbsp;</span> First Name :</td>
                        <td valign="top" bgcolor="#FFFFFF" class="paragraph"><input name="users_fname" type="text" class="txtbox" value="<?php echo $user->users_fname;?>">
                        </td>
				        </tr>
				      <tr>
                        <td align="right" valign="top" bgcolor="#EFEFEF" class="paragraph"><span class="mandatory">* </span> Last Name : </td>
                        <td valign="top" bgcolor="#FFFFFF" class="paragraph"><input name="users_lname" type="text" class="txtbox" value="<?php echo $user->users_lname;?>">
      </td
                      >
				        </tr>
				      <tr>
                        <td align="right" valign="top" bgcolor="#EFEFEF" class="paragraph"><span class="mandatory">* </span>E-Mail :</td>
                        <td valign="top" bgcolor="#FFFFFF" class="paragraph"><input name="users_email" type="text" class="txtbox" value="<?php echo $user->users_email;?>">
                          <?php if($error_messages["users_email"]){ echo "<span class='paragraphred'>".$error_messages["users_email"]."</span>";}?> 
                        </td
                      >
				        </tr>
                        <tr>
                          <td align="right" valign="top" bgcolor="#EFEFEF" class="paragraph"><strong><span class="mandatory">*</span></strong> Username  : </td>
                          <td bgcolor="#FFFFFF" class="paragraph">
                            <input name="users_username" type="text" class="txtbox" value="<?php echo $user->users_username;?>">
                            <?php if($error_messages["users_username"]){ echo "<span class='paragraphred'>".$error_messages["users_username"]."</span>";}?>
                          </td>
                        </tr>
                        <tr>
                          <td width="32%" align="right" valign="top" bgcolor="#EFEFEF" class="paragraph"><span class="mandatory">*&nbsp;</span> Password : </td>
                          <td bgcolor="#FFFFFF" class="h1"><span class="paragraph">
                            <input name="users_password" type="password" class="txtbox" value="<?php echo $user->users_password;?>">
                          </span></td>
                        </tr>
					     <tr>
					       <td width="32%" align="right" valign="top" bgcolor="#EFEFEF" class="paragraph"><span class="mandatory">*&nbsp;</span>Confirm Password : </td>
					       <td valign="top" bgcolor="#FFFFFF" class="paragraphred"><span class="h1"><span class="paragraph">
					         <input name="users_cpassword" type="password" class="txtbox" value="<?php echo $user->users_password;?>">
					       </span></span></td>
					       </tr>
					     <tr>
                          <td align="right" valign="top" bgcolor="#EFEFEF" class="paragraph">User Status :<br>
                            [Check to activate the Users] </td>
                          <td width="68%" valign="top" bgcolor="#FFFFFF" class="paragraphred"><input type="checkbox" name="users_status" value="0" id="users_status" <?php if($user->users_status) { echo "checked"; }?>>
						  <?php echo $error_messages["users_status"];?>
						  
						</td>
                          </tr>
                        <tr>
						<td bgcolor="#EFEFEF" class="paragraph">&nbsp;</td>
                          <td valign="top" bgcolor="#EFEFEF" class="paragraph">
						   <input name="action1" type="hidden" id="action1" value="<?php echo $submit;?>">
						  <input name="users_id" type="hidden" id="users_id" value="<?php echo $user->users_id;?>">
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
				        <td align="right" valign="top" bgcolor="#EFEFEF" class="paragraph"> First Name :</td>
				        <td width="69%" bgcolor="#FFFFFF" class="paragraph"><?php echo $user->users_fname;?></td>
				        </tr>
				      <tr>
				        <td align="right" valign="top" bgcolor="#EFEFEF" class="paragraph">Last Name : </td>
				        <td bgcolor="#FFFFFF" valign="top" class="paragraph">
                          <?php echo  $user->users_lname;?>
                        </td>
				        </tr>
				      <tr>
				        <td align="right" valign="top" bgcolor="#EFEFEF" class="paragraph">E-Mail : </td>
				        <td bgcolor="#FFFFFF" valign="top" class="paragraph"><a href="mailto:<?php echo $user->users_email;?>" ><?php echo $user->users_email;?></a></td
                      >
				        </tr>
				      <tr>
				        <td align="right" valign="top" bgcolor="#EFEFEF" class="paragraph"><strong></strong>Username : </td>
				        <td bgcolor="#FFFFFF" valign="top" class="paragraph"><?php echo $user->users_username;?></td>
				        </tr>				     		  
				      <tr>
				        <td align="right" valign="top" bgcolor="#EFEFEF" class="paragraph">User Status</td>
				        <td bgcolor="#FFFFFF" valign="top" class="paragraph"><?php if($user->users_status){ echo "Active";} else { echo "Inactive";} ?></td>
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
 