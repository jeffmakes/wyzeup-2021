<?php 
	ob_start();
	header ("Pragma: no-cache");
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	session_start();
	require_once('conf/conf.inc.php');
	require_once('dao/school_dao.php');
	
	#User Existence validation
	if(isset($_SESSION['session_schoolemail'])==''){
		header("Location:index.php?err=login");
	}
	
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
	//echo $school->school_startdate;
	#Changing the Dateformat to store in db
	if($_POST["school_startdate"]){
  		$date1=explode("-",trim($_POST["school_startdate"]));
		$startdate=$date1[2]."-".$date1[1]."-".$date1[0];
	}
	if($_POST["school_enddate"]){
 	 	$date2=explode("-",trim($_POST["school_enddate"]));
		$enddate=$date2[2]."-".$date2[1]."-".$date2[0];
	}
	if($_POST["school_expirydate"]){
 	 	$date3=explode("-",trim($_POST["school_expirydate"]));
		$expirydate=$date3[2]."-".$date3[1]."-".$date3[0];
	}
	
	#School  Details
	$school->school_id			= trim($_POST['school_id']);	 
	$school->school_name 		= trim($_POST["school_name"]);
	/*if(!$school->school_password){
		$school->school_password	= random_string(8);
	}*/
	$school->school_contactname				= trim($_POST["school_contactname"]);
	$school->school_contactperson_position	= trim($_POST["school_contactperson_position"]);	
	$school->school_startdate 				= $startdate;
	$school->school_enddate 				= $enddate;
	$school->school_expirydate 				= $expirydate;
	$school->school_address1 				= trim($_POST["school_address1"]);
	$school->school_address2 				= trim($_POST["school_address2"]);
	$school->school_city	 				= trim($_POST["school_city"]);
	$school->school_country 				= trim($_POST["school_country"]);
	$school->school_zipcode 				= trim($_POST["school_zipcode"]);	
	$school->school_email 					= trim($_POST["school_email"]);		
	$school->school_invoice_to				= trim($_POST["school_invoice_to"]);			
	$school->school_proforma_invoice		= trim($_POST["school_proforma_invoice"]);				
	$school->school_phone 					= trim($_POST["school_phone"]);	
	$school->school_status 					= trim($_POST["school_status"]);	
			
	$submit 		        				= $_POST['action1'];
	
	#Add operation check
	if(empty($submit) && empty($_POST['school_id'])) {
		$school_id		=	trim($_SESSION["session_schoolid"]);	
		$submit		    =	trim($_GET['action']);	
	}
	if (empty($submit)) {
 		  define('SUBMIT_BUTTON', BUTTON_ADD); 
		  $submit = "add";
	}
	# To update the school details
	if ($submit == BUTTON_EDIT) {
			define('SUBMIT_BUTTON', BUTTON_EDIT); 		
 			$error_messages   =  $school_dao->School_Update($school);
 			if (!$error_messages) {			
				html_refresh("myaccount.php?formaction=send");
			}	
	  } 
	  #To read the values DB
	if ($submit == "edit" || $submit == "view") {
			define('SUBMIT_BUTTON', BUTTON_EDIT); 
			$submit = SUBMIT_BUTTON;	
			$school	= $school_dao->School_Read($school_id);
 	} 
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
function Popup_Scenario()
{	
	 var popWin = window.open("scenario.php","WYZEUP",'width=750,height=490,toolbar=0,left=200,top=100');
}
function validate() {
	var form_name = document.frmmember;	
	form_name.action = "myaccount.php";
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
		  <img src="wyzeup_images/my-account-large.gif" title="My Account" alt="My Account" width="518" height="32" /><br>
<br>
		 <?php 	
				if(isset($_GET['formaction']) && $_GET['formaction'] == 'send') 
				{ 
					echo "<div id='contentapply'><div id='formlayermyaccount'>";
					echo "Your information has been updated Successfully.<br><br> Go to <a href=myaccount.php?action=view>My Account</a>";
					echo "</div></div>";
				}	else  {
		?>

		<div id="contentmyaccountbox">
		 <div id="formlayermyaccount">
			<form action="" name="frmmember" method="post">
				    <div align="right"><span align="right"><a href="change_password.php">Change Password</a></span></div>
					<label for="sname">School Name <span class="errormesage">*</span></label>					
					<input type="text" id="school_name" name="school_name" value="<?php echo $school->school_name;?>" />&nbsp;<?php if (isset($error_messages['school_name'])) { echo '<span class="errormesage">'.$error_messages['school_name'].'</span>';}?><br>
					<label for="contactperson" >Contact Person <span class="errormesage">*</span></label>
					<input type="text" id="school_contactname" name="school_contactname" value="<?php echo $school->school_contactname;?>" />&nbsp;<?php if (isset($error_messages['school_contactname'])) { echo '<span class="errormesage">'.$error_messages['school_contactname'].'</span>';}?><br />		
					<label for="position" >Position <span class="errormesage">*</span></label>
					<input type="text" id="school_contactperson_position" name="school_contactperson_position" value="<?php echo $school->school_contactperson_position;?>" />&nbsp;<?php if (isset($error_messages['school_contactperson_position'])) { echo '<span class="errormesage">'.$error_messages['school_contactperson_position'].'</span>';}?><br />		
					<!--
					<label for="startdate">Start Date <span class="errormesage">*</span> [dd-mm-yyyy]</label>
					<input type="text" id="school_startdate" name="school_startdate" value="<?php echo $school->school_startdate;?>" />&nbsp;<?php if (isset($error_messages['school_startdate'])) { echo '<span class="errormesage">'.$error_messages['school_startdate'].'</span>';}?><br>
					<label for="enddate" >End Date <span class="errormesage">*</span>  [dd-mm-yyyy]</label>
					<input type="text" id="school_enddate" name="school_enddate" value="<?php echo $school->school_enddate;?>"/>&nbsp;<?php if (isset($error_messages['school_enddate'])) { echo '<span class="errormesage">'.$error_messages['school_enddate'].'</span>';}?><?php if (isset($error_messages['school_compdate'])) { echo '<span class="errormesage">'.$error_messages['school_compdate'].'</span>';}?><br>		
					-->
					<label for="address1">Address1 <span class="errormesage">*</span></label>
					<input type="text" id="school_address1" name="school_address1" value="<?php echo $school->school_address1;?>" />&nbsp;<?php if (isset($error_messages['school_address1'])) { echo '<span class="errormesage">'.$error_messages['school_address1'].'</span>';}?><br>
					<label for="addtess2" >Address2 </label>
					<input type="text" id="school_address2" name="school_address2" value="<?php echo $school->school_address2;?>" />&nbsp;<?php if (isset($error_messages['school_address2'])) { echo '<span class="errormesage">'.$error_messages['school_address2'].'</span>';}?><br/>			
					<!--label for="addtess2" >Address3</label>
					<input type="text" id="school_address3" name="school_address3" value="<?php //echo $_REQUEST[''];?>" /><br/-->			
					<label for="city">City <span class="errormesage">*</span></label>
					<input type="text" id="school_city" name="school_city" value="<?php echo $school->school_city;?>" />&nbsp;<?php if (isset($error_messages['school_city'])) { echo '<span class="errormesage">'.$error_messages['school_city'].'</span>';}?><br>
					<label for="country" >Country <span class="errormesage">*</span></label>
					<?php   echo generate_list_from_array('school_country', $arrcountries,$school->school_country,$first_option='Please Choose...',$school->school_country,'txtbox');?>&nbsp;<?php if (isset($error_messages['school_country'])) { echo '<span class="errormesage">'.$error_messages['school_country'].'</span>';}?>
					<!--input type="text" id="school_country" name="school_country" />	<br/-->		
					<label for="zipcode">Postcode <span class="errormesage">*</span></label>
					<input type="text" id="school_zipcode" name="school_zipcode" value="<?php echo $school->school_zipcode;?>" />&nbsp;<?php if (isset($error_messages['school_zipcode'])) { echo '<span class="errormesage">'.$error_messages['school_zipcode'].'</span>';}?><br>
					<label for="email" >E-Mail <span class="errormesage">*</span></label>
					<input type="text" id="school_email" name="school_email" value="<?php echo $school->school_email;?>" />&nbsp;<?php if (isset($error_messages['school_email'])) { echo '<span class="errormesage">'.$error_messages['school_email'].'</span>';}?><br/>		
					<label for="invoice" >Invoice To <span class="errormesage">*</span></label>
					<input type="text" id="school_invoice_to" name="school_invoice_to" value="<?php echo $school->school_invoice_to;?>" />&nbsp;<?php if (isset($error_messages['school_invoice_to'])) { echo '<span class="errormesage">'.$error_messages['school_invoice_to'].'</span>';}?><br/>		
					<label for="proformainvoice" >Proforma Invoice Required <span class="errormesage">*</span></label>
					<input type="text" id="school_proforma_invoice" name="school_proforma_invoice" value="<?php echo $school->school_proforma_invoice;?>" />&nbsp;<?php if (isset($error_messages['school_proforma_invoice'])) { echo '<span class="errormesage">'.$error_messages['school_proforma_invoice'].'</span>';}?><br/>							
					<label for="phone">Phone <span class="errormesage">*</span></label>
					<input type="text" id="school_phone" name="school_phone" value="<?php echo $school->school_phone;?>" />&nbsp;<?php if (isset($error_messages['school_phone'])) { echo '<span class="errormesage">'.$error_messages['school_phone'].'</span>';}?><br><br/>
					<input name="action1" type="hidden" id="action1" value="<?php echo $submit;?>">
					<input name="school_id" type="hidden" id="school_id" value="<?php echo $school_id;?>">
					<input type="hidden" id="school_startdate" name="school_startdate" value="<?php echo $school->school_startdate;?>" />
					<input type="hidden" id="school_enddate" name="school_enddate" value="<?php echo $school->school_enddate;?>"/>
					<input type="hidden" id="school_expirydate" name="school_expirydate" value="<?php echo $school->school_expirydate;?>"/>
					<input type="hidden" id="school_status" name="school_status" value="<?php echo $school->school_status;?>"/>
					<a href="#"  onClick="validate()"><img src="wyzeup_images/but-update.jpg" width="71" height="25" vspace="5" border="0" alt="Update" title="Update"></a>
			  </form><br>
<br>
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
