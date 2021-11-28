<?php 
	ob_start();
	header ("Pragma: no-cache");
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	session_start();
	require_once('conf/conf.inc.php');
	require_once('dao/school_dao.php');
	
	#Object Instantiation for Scenario typeDAO
	$school			  =  new SchoolDO();
	$school_dao       =  new SchoolDAO(); 
	
	#Changing the Dateformat to store in db
/*	if($_POST["school_startdate"]){
  		$date1=explode("-",trim($_POST["school_startdate"]));
		$startdate=$date1[2]."-".$date1[1]."-".$date1[0];
	}
	if($_POST["school_enddate"]){
 	 	$date2=explode("-",trim($_POST["school_enddate"]));
		$enddate=$date2[2]."-".$date2[1]."-".$date2[0];
	}*/

	//$action		= $_GET["formaction"];
	$submit			= trim($_GET['formaction']);
	$school_id		= $_GET["school_id"];

	#To display default country
	if($_GET['formaction']	==	''){
		$school->school_country    =  "GB";
	}
	
	$startdate = date("Y-m-d");
	#To Get the Expiry Date
				$today = mktime();		
				$date = date("j-n-Y", $today);		
				$previousdate = mktime(0, 0, 0, date("n"), date("j")-1, date("Y")+1);		
				//$nextyear = mktime(0, 0, 0, date("n"), date("j"), date("Y")+1);
				$enddate = date("Y-m-d", $previousdate);
	#To Get the Real Expiry Date
				$previousdate1 = mktime(0, 0, 0, date("n"), date("j")+9, date("Y")+1);		
				$expirydate = date("Y-m-d", $previousdate1);				
				

	#School  Details
	$school->school_id			= trim($_POST['school_id']);	 
	$school->school_name 		= trim($_POST["school_name"]);
	//if(!$school->school_password){
		//$school_password			= trim($_POST["school_password"]);
		//$school->password           =  $school_password;
		$school->school_password    =  trim($_POST["school_password"]);//pw_encode($school_password);
	//}
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
	//$school->school_password				= trim($_POST["school_password"]);			
	$school->school_confirm_password		= trim($_POST["school_confirm_password"]);			
	$school->school_invoice_to				= trim($_POST["school_invoice_to"]);			
	$school->school_proforma_invoice		= trim($_POST["school_proforma_invoice"]);			
	$school->school_phone 					= trim($_POST["school_phone"]);	
	$school->school_status					=  0;		
	$school->frontend						='front';		
	
	$select_query = "SELECT count( * ) as row_count FROM  ".TABLE_INVOICE;
	$query_result = db_execute_query($select_query);
	$data         = db_return_array($query_result); 
	$count = $data["row_count"];
	if($count == 0) $row_count =1; else $row_count = $count;
	$school->invoice_number = "S".(INVOICE_NUMBER+$row_count);
	$vat_amount   			= TRANSACTION_AMOUNT * VAT;
	$school->invoice_amount	= TRANSACTION_AMOUNT + $vat_amount;

	
	$submit 		        				= $_POST['action1'];

	#Add operation check
	if(empty($submit) && empty($_POST['school_id'])) {
		$school_id		=	trim($_GET['school_id']);	
		$submit		    =	trim($_GET['formaction']);	
	}
	if (empty($submit)) {
 		  define('SUBMIT_BUTTON', BUTTON_ADD); 
		  $submit = "add";
	}
	if ($submit == BUTTON_ADD) {
		define('SUBMIT_BUTTON', BUTTON_ADD);		
		$return_value             = $school_dao->School_Create_Public($school);
		if(is_array($return_value) && !is_int($return_value))
			{ $error_messages = $return_value;}
		 if (!$error_messages) { 
		 	unset($school);
			unset($school_dao);
			html_refresh("online_application.php?schoolid=".$return_value."&formaction=send");
		 } 
 	  } 
  if($submit == "add"){
		$submit = SUBMIT_BUTTON;
	  }	
	  
	  /*
	  $return_value  = $user_dao->User_Create($user);
		 if(is_array($return_value) && !is_int($return_value))
			$error_messages =  $return_value;
		if (!$error_messages){
			$url="register_checkout.php?id=".$return_value."&action=checkout";
			html_refresh($url);
		}*/
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title>Wyze Up - Apply for License</title>
<script language="javascript" src="includes/formvalidation.js" type="text/jscript"></script>
<script language="javascript" type="text/javascript">
function validate() {
	var form_name = document.frmschool;	
	if(TextValidate(form_name.school_name,"the school name")==false){return false;}	
	if(TextValidate(form_name.school_contactname,"the contact person")==false){return false;}
	//if(TextValidate(form_name.school_startdate,"the startdate")==false){return false;}
	/*if(DateFormatValidate(form_name.school_startdate,"the startdate")==false){return false;}*/
	//if(TextValidate(form_name.school_enddate,"the enddate")==false){return false;}
	//if(DateFormatValidate(form_name.school_enddate,"the enddate")==false){return false;}
	//if(Comparedate(form_name.school_startdate,form_name.school_enddate)==false){return false;}
	if(TextValidate(form_name.school_contactperson_position,"the position")==false){return false;}
	if(TextValidate(form_name.school_address1,"the address1")==false){return false;}
	if(TextValidate(form_name.school_city,"the city")==false){return false;}
	if(SelectValidate(form_name.school_country,"the country")==false){return false;}
	if(TextValidate(form_name.school_zipcode,"the zipcode")==false){return false;}
	if(TextValidate(form_name.school_email,"the email")==false){return false;}
	if(EmailValidate(form_name.school_email,"the email")==false){return false;}
	if(TextValidate(form_name.school_phone,"the phone")==false){return false;}
	form_name.action = "online_application.php";
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
		<div id="headerleft"><a href="Templates/index.php" title="Wyze Up"><img src="wyzeup_images/wyzeup-logo.jpg" width="187" height="74" alt="Wyze Up" title="Wyze Up" border="0" /></a><a href="#skipnav" accesskey="s"><img src="wyzeup_images/spacer.gif" border="0"></a></div>
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
			<a href="Templates/login.php"><img src="wyzeup_images/but-console.jpg" border="0" title="Wyze up Console" alt="Wyze up Console"></a> 
		<?php } ?>
			<a href="javascript:Popup_demo();"><img src="wyzeup_images/but-free.jpg" border="0" title="Wyze up Console"></a>	</div>			
	</div>
	<!-- END div-contentleft //-->

	<!-- START div-contentright//-->
	<div id="contentrightmain">
		
	  <div id="contentright">
		<div id="contentrightbox">
		<img src="wyzeup_images/apply-for-licence.gif" title="Apply for Licence" alt="Apply for licence" />
		<?php 	
				if(isset($_GET['formaction']) && $_GET['formaction'] == 'send') 
				{ 
					echo "<div id='contentapply'><div id='formlayerapplication'>";
					echo "Thank you for sending information to us.<br>Your invoice will be emailed to you for settlement before you can access the Wyze up console.";
					//echo "<br><br><i>If you would like to use Wyze-up, please issue a license to the following school. If you wish to pay via pro-forma invoice <a href='pdf/pdftable.php?school_id=". $_GET['schoolid']."' target='_blank'>click here</a>. If you wish to pay using your E-learning credits <a href='#'>click here</a>.</i>";
					echo "</div></div>";
				}	
				else
				{  $school->school_country    =  "GB";
		?>
			  <p><a name="skipnav"></a>Wyze-up is available to schools on an annual, unlimited user licensed basis for just &pound;19.95 per year.</p>
		  <p>To get your Wyze-up licence, simply fill in your details below.  Payment can be made via automatically generated proforma invoice in order to raise a school/educational authority payment.</p>
		  <p>Please use the form below  to send us your information.</p>
			  <div id="contentapplicationbox">
			<div id="formlayerapplication">		 
				<form action="" name="frmschool" method="post">
					<div id="form-top1"><span class="errormesage">*&nbsp;</span>are required fields</div>
							
					<label for="sname">School Name <span class="errormesage">*</span></label>
					<input type="text" id="school_name" name="school_name" value="<?php echo $_REQUEST['school_name'];?>" />&nbsp;<?php if (isset($error_messages['school_name'])) { echo '<span class="errormesage">'.$error_messages['school_name'].'</span>';}?><br>
					<label for="contactperson" >Contact Person <span class="errormesage">*</span></label>
					<input type="text" id="school_contactname" name="school_contactname" value="<?php echo $_REQUEST['school_contactname'];?>" />&nbsp;<?php if (isset($error_messages['school_contactname'])) { echo '<span class="errormesage">'.$error_messages['school_contactname'].'</span>';}?><br />		
					<label for="position" >Position <span class="errormesage">*</span></label>
					<input type="text" id="school_contactperson_position" name="school_contactperson_position" value="<?php echo $_REQUEST['school_contactperson_position'];?>" />&nbsp;<?php if (isset($error_messages['school_contactperson_position'])) { echo '<span class="errormesage">'.$error_messages['school_contactperson_position'].'</span>';}?><br />		
					<!--
					<label for="startdate">Start Date <span class="errormesage">*</span> [dd-mm-yyyy]</label>
					<input type="text" id="school_startdate" name="school_startdate" value="<?php echo $_REQUEST['school_startdate'];?>" />&nbsp;<?php if (isset($error_messages['school_startdate'])) { echo '<span class="errormesage">'.$error_messages['school_startdate'].'</span>';}?><br>
					<label for="enddate" >End Date <span class="errormesage">*</span>  [dd-mm-yyyy]</label>
					<input type="text" id="school_enddate" name="school_enddate" value="<?php echo $_REQUEST['school_enddate'];?>"/>&nbsp;<?php if (isset($error_messages['school_enddate'])) { echo '<span class="errormesage">'.$error_messages['school_enddate'].'</span>';}?><?php if (isset($error_messages['school_compdate'])) { echo '<span class="errormesage">'.$error_messages['school_compdate'].'</span>';}?><br>		
					-->
					<label for="address1">Address1 <span class="errormesage">*</span></label>
					<input type="text" id="school_address1" name="school_address1" value="<?php echo $_REQUEST['school_address1'];?>" />&nbsp;<?php if (isset($error_messages['school_address1'])) { echo '<span class="errormesage">'.$error_messages['school_address1'].'</span>';}?><br>
					<label for="addtess2" >Address2 </label>
					<input type="text" id="school_address2" name="school_address2" value="<?php echo $_REQUEST['school_address2'];?>" />&nbsp;<?php if (isset($error_messages['school_address2'])) { echo '<span class="errormesage">'.$error_messages['school_address2'].'</span>';}?><br/>			
					<label for="city">City <span class="errormesage">*</span></label>
					<input type="text" id="school_city" name="school_city" value="<?php echo $_REQUEST['school_city'];?>" />&nbsp;<?php if (isset($error_messages['school_city'])) { echo '<span class="errormesage">'.$error_messages['school_city'].'</span>';}?><br>
					<label for="country" >Country <span class="errormesage">*</span></label>
					<?php   echo generate_list_from_array('school_country', $arrcountries,$school->school_country,$first_option='Please Choose...',$school->school_country,'txtbox');?>&nbsp;<?php if (isset($error_messages['school_country'])) { echo '<span class="errormesage">'.$error_messages['school_country'].'</span>';}?>
					<label for="zipcode">Postcode <span class="errormesage">*</span></label>
					<input type="text" id="school_zipcode" name="school_zipcode" value="<?php echo $_REQUEST['school_zipcode'];?>" />&nbsp;<?php if (isset($error_messages['school_zipcode'])) { echo '<span class="errormesage">'.$error_messages['school_zipcode'].'</span>';}?><br>
					<label for="email" >E-Mail <span class="errormesage">*</span></label>
					<input type="text" id="school_email" name="school_email" value="<?php echo $_REQUEST['school_email'];?>" />&nbsp;<?php if (isset($error_messages['school_email'])) { echo '<span class="errormesage">'.$error_messages['school_email'].'</span>';}?><?php if (isset($error_messages['school_email_id'])) { echo '<span class="errormesage">'.$error_messages['school_email_id'].'</span>';}?><br/>		
					<label for="passwrd" >Password <span class="errormesage">*</span></label>
					<input type="password" id="school_password" name="school_password" value="<?php echo $_REQUEST['school_password'];?>" />
					&nbsp;<?php if (isset($error_messages['school_password'])) { echo '<span class="errormesage">'.$error_messages['school_password'].'</span>';}?><br/>		
					<label for="cpasswrd" >Confirm Password <span class="errormesage">*</span></label>
					<input type="password" id="school_confirm_password" name="school_confirm_password" value="<?php echo $_REQUEST['school_confirm_password'];?>" />
					&nbsp;<?php if (isset($error_messages['school_confirm_password'])) { echo '<span class="errormesage">'.$error_messages['school_confirm_password'].'</span>';}?>
					<?php if (isset($error_messages['school_password_mismatch'])) { echo '<span class="errormesage">'.$error_messages['school_password_mismatch'].'</span>';}?>
					<br/>		
					<label for="invoice" >Invoice To <span class="errormesage">*</span></label>
					<input type="text" id="school_invoice_to" name="school_invoice_to" value="<?php echo $_REQUEST['school_invoice_to'];?>" />&nbsp;<?php if (isset($error_messages['school_invoice_to'])) { echo '<span class="errormesage">'.$error_messages['school_invoice_to'].'</span>';}?><br/>		
					<label for="proformainvoice" >Proforma Invoice Required <span class="errormesage">*</span></label>
					<input type="text" id="school_proforma_invoice" name="school_proforma_invoice" value="<?php echo $_REQUEST['school_proforma_invoice'];?>" />&nbsp;<?php if (isset($error_messages['school_proforma_invoice'])) { echo '<span class="errormesage">'.$error_messages['school_proforma_invoice'].'</span>';}?><br/>		
					<label for="phone">Phone <span class="errormesage">*</span></label>
					<input type="text" id="school_phone" name="school_phone" value="<?php echo $_REQUEST['school_phone'];?>" />&nbsp;<?php if (isset($error_messages['school_phone'])) { echo '<span class="errormesage">'.$error_messages['school_phone'].'</span>';}?><br><br/>
		 			<input name="action1" type="hidden" id="action1" value="<?php echo $submit;?>">
					<input name="school_id" type="hidden" id="school_id" value="<?php echo $school->school_id;?>">
					<a href="#" onClick="validate();"><img src="wyzeup_images/send-on.jpg" title="Send" width="71" height="25" border="0"  alt="Send"></a><br><br>
				</form>		
			 </div>
		</div><? 		}		?>	
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
