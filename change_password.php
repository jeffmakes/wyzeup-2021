<?php 
	ob_start();
	header ("Pragma: no-cache");
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	session_start();
	require_once('conf/conf.inc.php');
	require_once('dao/school_dao.php');
	
	#User Existence validation
	/*if(isset($_SESSION['session_schoolemail'])==''){
		header("Location:index.php?err=login");
	}*/
	
 	$school_id = $_SESSION["session_schoolid"];
	#Object Instantiation for Scenario typeDAO
	$school			  =  new SchoolDO();
	$school_dao       =  new SchoolDAO(); 

	$submit	   = trim($_GET['action']);
	$school_id = $_SESSION["session_schoolid"];
	
	#To display default country
	if($_GET['formaction']	==	''){
		$school->school_country    =  "GB";
	}
	
	$password          = trim($_POST['txtpassword']); 

	$new_password      = trim($_POST['txtnewpassword']); 

	$confirm_password  = trim($_POST['txtconfirmpassword']); 

	
	if($_GET['action'] == 'send') {

		#Validations
		$password          = trim($_POST['txtpassword']); 

		$new_password      = trim($_POST['txtnewpassword']); 
	
		$confirm_password  = trim($_POST['txtconfirmpassword']); 
		
		if($password == "" || !isset($password)) {
			$error_messages['txtpassword'] = 'Please enter the old password';
	    }
	    if($new_password == "" || !isset($new_password)) {
			$error_messages['txtnewpassword'] = 'Please enter the new password';
		}
		if($confirm_password == "" || !isset($confirm_password)) {
			$error_messages['txtconfirmpassword'] = 'Please enter the confirm new password';
		}
		#Check for the match of password and confirm password
		if($new_password && $confirm_password && ($new_password != $confirm_password)) {
			$error_messages['password_mismatch'] = 'The new password and the new confirm password do not match.';
		}
		

			$school_id      =  $_SESSION["session_schoolid"];

			$school_password   =  get_name(TABLE_SCHOOL, $school_id, 'school_password', 'school_id');

			//$password          =  pw_check($password,$school_password);
		if($password != ''){
			if($password != $school_password) {
	
				$error_messages['password'] = 'The old password that you entered is invalid.';

			}
		}

		

		if(!$error_messages)	{			

			 $update_query  = 'UPDATE '.TABLE_SCHOOL.' SET

								school_password         =  "'.$new_password.'"

							WHERE 

								school_id 			= '.$school_id;

			db_execute_query($update_query);

			$url = 'change_password.php?status=1';

			html_refresh($url);	   

		}

	}

	#Display message after sending the email

	if($_GET['status'] && !$error_messages)  $error_messages['display']='Your password was successfully updated.'; 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title>Wyze Up</title>
<script language="javascript" src="includes/formvalidation.js" type="text/javascript"></script>
<script language="javascript"type="text/javascript">
function handleKeyPressMember(evt) {
  var nbr;
  var nbr = (window.event)?event.keyCode:evt.which;
  if(nbr==13) {
	  return ValidateMember();
  } else  {
  	return true;
  }
}
function clear_membertext(value) {
    var val = value;
	if((val == 1))
		{ document.frmmember.memberusername.value = ""; }
	if((val == 2))
		{ document.frmmember.memberpassword.value = ""; }
}

function validate() {
	var form_name = document.frmmember;	
	form_name.action = "change_password.php?action=send";
	form_name.submit();
}	

</script>
<style type="text/css">
<!--
.style2 {color: #FF0000}
-->
</style>
<link href="wyzeup_css/wyzeup.css" rel="stylesheet" type="text/css">
<script language="javascript" src="includes/formvalidation.js" type="text/javascript"></script>
<script language="javascript"type="text/javascript">
function ValidateMe(){
	if(TextValidate(document.frmlogin.txtusername," the Username")==false){ return false;}
	if(TextValidate(document.frmlogin.txtpassword," the Password")==false){ return false;}
	document.frmlogin.action="loginprocess.php";
	document.frmlogin.submit();
}
function logout(){
	document.frmlogout.action="logout.php";
	document.frmlogout.submit();
}
function clear_text(value) {
    var val = value;
	if((val == 1))
		{ document.frmlogin.txtusername.value = ""; }
	if((val == 2))
		{ document.frmlogin.txtpassword.value = ""; }
}
function Popup_Access()
{	
	 alert('Please login to access the console');
}

function Popup_Scenario()
{	
	 var popWin = window.open("scenario.php","WYZEUP",'width=750,height=490,toolbar=0,left=200,top=100');
}
function Popup_demo()
{	
	 var popWin = window.open("scenario_demo.php","WYZEUPDEMO",'width=750,height=490,toolbar=0,left=200,top=100');
}
/*function retain_text(value) {
    var val = value;
	if((val == 1))
		{ document.frmlogin.txtusername.value = "Login"; }
	if((val == 2))
		{ document.frmlogin.txtpassword.value = "password"; }
}*/

function handleKeyPressUser(evt) {
  var nbr;
  var nbr = (window.event)?event.keyCode:evt.which;
  if(nbr==13) {
	  return ValidateMe();
  } else  {
  	return true;
  }
}
</script>
</head>
<!-- START body //-->
<body>
<!-- START div-main //-->
	<div id="main">
	<!-- START div-header //-->
	<div id="header">
		<!-- START div-headerleft //-->
		<div id="headerleft"><a href="index.php" title="Wyze Up"><img src="wyzeup_images/wyzeup-logo.jpg" width="187" height="74" alt="Wyze Up" title="Wyze Up" border="0" /></a><a href="#skipnav" accesskey="s"><img src="wyzeup_images/spacer.gif" border="0"></a></div>
		<!-- END div-headerleft //-->

		<!-- START div-headerright //-->
		<div id="headerright">
			<!-- START menu include //-->		
			<div id="menu">
			<?php
				if(!isset($_SESSION['session_schoolemail'])){ 
					$filename =  "online_application.php"; 
				}else {
					$filename =  "myaccount.php?action=view"; 
				} 
			?>
			<ul>
			<li id="m1"><a href="index.php" title="Home">Home</a></li>
			<li id="m2"><a href="about_us.php" title="About us">About us</a></li>
			<li id="m3"><a href="how_it_works.php" title="How it works">How it works</a></li>
			<li id="m4"><a href="pshce_curriculam.php" title="PSHCE curriculum">PSHCE curriculum</a></li>
			<li id="m5"><a href="<?php echo $filename;?>" title="Apply">Apply</a></li>
			<li id="m6"><a href="contact_us.php" title="Technical Support Contact">Technical Support Contact</a></li>										
			</ul>
			</div>
			<!-- END menu include //-->			
		</div>
		<!-- END div-headerright //-->		
	</div>
	<!-- END div-header //-->


	<!-- START div-theme //-->
	<div id="theme">
	 <?php if(!$_SESSION['session_schoolname']){?>
		<!-- START div-themeleft//-->
		<div id="themeleft">
			<div id="themeleftloginbox">
			  <div id="formlayerinner">
					<form action="" name="frmlogin" method="post">
					<label>email address:</label>
					<input name="txtusername" type="text" id="txtusername" onClick="javascript:clear_text(1);" value="email address" />
					<br>
					<label>password:</label>
					<input name="txtpassword" type="password" id="txtpassword" onKeyPress="javascript:return handleKeyPressUser(event);"  onClick="javascript:clear_text(2);" value="password" />
					</form>
				  <a href="#" onClick="ValidateMe();" onKeyPress="ValidateMe();"><img src="wyzeup_images/button-login-on.jpg" alt="Login" width="71" height="24" vspace="5" border="0" title="Login" /></a><br>
				</div>				
			</div>
		</div>
	<?php }else{?>
		<div id="themeleft">
			<div id="themeleftloginbox">
			  <div id="formlayerinner">
			 	 <form action="" name="frmlogout" method="post">
			  		<p><?php echo 'You have logged in as <br /><b>'.$_SESSION["session_schoolname"].'</b>'; ?></p>
					 <a href="#" onClick="logout()"><img src="wyzeup_images/logout-on.jpg" alt="Logout" width="71" height="25" vspace="5" border="0" title="Logout"></a>
				</form>
				</div>				
			</div>
		</div>
		<?php } ?>		
		<!-- END div-themeleft //-->
		
		<!-- START div-themeright//-->
		<div id="themeright">
		<img src="wyzeup_images/theme-img-bg.jpg" width="474" height="189" title="Wyze up Theme" alt="Wyze up Theme" /></div>
		<!-- END div-themeright //-->			
  </div>
	<!-- END div-theme //-->

<div id="content">

	<!-- START div-contentleft//-->
	<div id="contentleft">
	<div id="sp"></div>
	  

	  <div id="contentbox2">
		 <?php if(isset($_SESSION['session_schoolemail'])){  ?>
			<a href="javascript:Popup_Scenario();"><img src="wyzeup_images/but-console.jpg" border="0" title="Wyze up Console" alt="Wyze up Console"></a> 
		<?php }else { ?>
			<a href="login.php"><img src="wyzeup_images/but-console.jpg" border="0" title="Wyze up Console" alt="Wyze up Console"></a> 
		<?php } ?>
			<a href="javascript:Popup_demo();"><img src="wyzeup_images/but-free.jpg" border="0" title="Wyze up Console"></a>	</div>			
	</div>
	<!-- END div-contentleft //-->

	<!-- START div-contentright//-->
	<div id="contentrightmain">
		
	  <div id="contentright">
		<div id="contentrightbox">		
		  <img src="wyzeup_images/change-pass.gif" title="Change Password" alt="Change Password" width="525" height="45">
		  <?php if($_GET['status'] ==1){ 
		  
		
				//if(isset($_GET['formaction']) && $_GET['formaction'] == 'send') 
				//{ 
					echo "<div id='contentapply' align='center'><div id='formlayermyaccount'>";
					echo $error_messages['display'];
					//echo "Your information has been updated Successfully.";
					echo "</div></div>";
					echo "<div id='contentapply' align='center'><div id='formlayermyaccount'>";
					echo "Go to <a href='myaccount.php?action=view'>My Account</a>";
					echo "</div></div>";
				}	else  {
				echo "<div id='contentapply'><div id='formlayermyaccount' align='center'><font color='red'>";
				echo $error_messages['password'];
				echo "</font></div></div>";
		?>

		<div id="contentchangepassbox">
		 <div id="formlayerpassword">
			<form action="" name="frmmember" method="post">
				    <div align="center"></div>
					<label for="sname">Enter your current Password <span class="errormesage">*</span></label>
					<input type="password" id="txtpassword" name="txtpassword" value="<?php echo $_REQUEST['txtpassword'];?>" />
					&nbsp;<?php if (isset($error_messages['txtpassword'])) { echo '<span class="errormesage">'.$error_messages['txtpassword'].'</span>';}?><br>
					<label for="contactperson" >Choose a New Password <span class="errormesage">*</span></label>
					<input type="password" id="txtnewpassword" name="txtnewpassword" value="<?php echo $_REQUEST['txtnewpassword'];?>" />
					&nbsp;<?php if (isset($error_messages['txtnewpassword'])) { echo '<span class="errormesage">'.$error_messages['txtnewpassword'].'</span>';}?><br />		
					<label for="position" >Confirm your New Password <span class="errormesage">*</span></label>
					<input type="password" id="txtconfirmpassword" name="txtconfirmpassword" value="<?php echo $_REQUEST['txtconfirmpassword'];?>" />
					&nbsp;<?php if (isset($error_messages['txtconfirmpassword'])) { echo '<span class="errormesage">'.$error_messages['txtconfirmpassword'].'</span>';}?>
					<?php if (isset($error_messages['password_mismatch'])) { echo '<span class="errormesage">'.$error_messages['password_mismatch'].'</span>';}?>
					<br />		
					<label for="phone"></label>
					<input name="action1" type="hidden" id="action1" value="<?php echo $submit;?>">
					<input name="school_id" type="hidden" id="school_id" value="<?php echo $school_id;?>">
					<a href="#"  onClick="validate()"><img src="wyzeup_images/but-update.jpg" width="71" height="25" vspace="5" border="0" alt="Update" title="Update"></a>
			  </form><br><br>
    		</div>
		  </div><?php } ?>
		</div>
	  </div>
	</div>
	<!-- END div-contentright//-->
	</div>	
<?php
	$today = date("F j Y");
	$curdate = explode(" ",$today); 
	$currentFile = $_SERVER["SCRIPT_NAME"];
	$file = basename($currentFile);	
?>
<div id="footer">
  <div id="footerboxleft"> <a href="index.php" title="Home" accesskey="1">Home</a> | <a href="about_us.php" title="About Us" accesskey="2">About us</a> | <a href="how_it_works.php"  title="How it works" accesskey="3">How it works</a> | <a href="pshce_curriculam.php"  title="PSHCE curriculum" accesskey="4">PSHCE curriculum</a> | <a href="contact_us.php"  title="Contact Us" accesskey="5">Contact</a> | <a href="sitemap.php" title="Site map" accesskey="6">Site map</a> | <a href="minimum-operating-specification.php" title="Minimum Operating Specification" accesskey="7">Minimum Operating Specification</a> | <a href="accessibility.php"  title="Accessibility" accesskey="0">Accessibility</a> <br>
  &copy; Copyright <?php echo $curdate[2]; ?> - Wyze Up - <a href="http://www.selesti.com/" target="_blank">Site by Selesti</a> <br/>
  <a href="http://validator.w3.org/check?uri=http://www.wyzeup.co.uk/<?php echo $file; ?>" title="XHTML">XHTML</a>, <a href="http://jigsaw.w3.org/css-validator/validator?uri=http://www.wyzeup.co.uk/wyzeup_css/wyzeup.css" title="CSS">CSS</a>, <a href="http://webxact.watchfire.com/" title="508">508</a>&nbsp;&nbsp; </div>
</div>
</div>
<!-- END div-main //-->
</body>
<!-- END body //-->
</html>
