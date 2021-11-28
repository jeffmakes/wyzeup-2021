<?php
	session_start();
	require_once('conf/conf.inc.php');
 	header ("Pragma: no-cache");
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	# Is the OS Windows or Mac or Linux
		if (strtoupper(substr(PHP_OS,0,3)=='WIN')) {
		  $eol="\r\n";
		} elseif (strtoupper(substr(PHP_OS,0,3)=='MAC')) {
		  $eol="\r";
		} else {
		  $eol="\n";
		}
	// To avoid Spam Mail
	


	if(isset($_GET['formaction']) && $_GET['formaction'] == 'sent'){
	/*foreach ($_POST as $j =>$value) {
		   if (stristr(strtolower($value),"content-type") || stristr(strtolower($value),"cc") || stristr(strtolower($value),"bcc")) {
				   header("HTTP/1.0 403 Forbidden");
				   echo "YOU HAVE BEEN BANNED FROM ACCESSING THIS SERVER FOR TRIGGERING OUR SPAMMER TRAP";
				   exit;
			}
		}
		
		if($_SERVER['REQUEST_METHOD'] !=  "POST"){
			   header("HTTP/1.0 403 Forbidden");
			   echo "YOU HAVE BEEN BANNED FROM ACCESSING THIS SERVER FOR TRIGGERING OUR SPAMMER TRAP";
			   exit;
		}
	
		$badStrings = array("Content-Type:",
							 "MIME-Version:",
							 "Content-Transfer-Encoding:",
							 "bcc:",
							 "cc:");
		
		// Loop through each POST'ed value and test if it contains
		// one of the $badStrings:
		foreach($_POST as $k => $v){
		   foreach($badStrings as $v2){
			   if(strpos($v, $v2) !== false){
					   header("HTTP/1.0 403 Forbidden");
					   echo "YOU HAVE BEEN BANNED FROM ACCESSING THIS SERVER FOR TRIGGERING OUR SPAMMER TRAP";
					   exit;
				 }
		   }
		}// End of for loop
	*/
				$subject   = "Wyze Up - Mail from Contact Us Page";
				$to        = "ollie@selesti.com";
				//$to        = "testteam_tester@yahoo.co.uk";				
				//$to        = "amudhabalan@gmail.com";
				//$to        = "ollie@selesti.co.uk";
				# Making the headers: 
				$name       = $_POST['txtname'];
				$email      = $_POST['txtemail'];
				$telephone  = $_POST['txtphone'];
				$message    = nl2br($_POST['txtmessage']);
				$headers = "MIME-Version: 1.0".$eol; 						
				$headers .= "Content-type: text/html; charset=iso-8859-1".$eol; 
				$headers .= "X-Priority : 1".$eol; 
				$headers .= "X-MsMail-Priority : High".$eol; 
				$headers .= "From:Wyzeup <info@wyzeup.co.uk>".$eol;
				//$headers .= "From:admin@wyzeup.co.uk".$eol; 
				$headers .= "X-Mailer: PHP v".phpversion().$eol;  
				
				$body = '
				<html><head>
					<meta http-quiv="Content-type: text/html; charset=iso-8859-1\r\n">
					<style type="text/css">
								.paragraph {
								font-family: Verdana, Arial, Helvetica, sans-serif;
								font-size: 75%;
								color: #000000;
								line-height: 19px;
								text-decoration: none;
								}
								</style>
					</head>
					<body>
					<table width="90%" border="0" cellspacing="1" cellpadding="4" bgcolor="#009899" align="center">
					  <tr bgcolor="#009899" class="paragraph">
						<td colspan="3" align=center><font color="#FFFFFF"><strong><strong>Wyze Up - Mail Details from Contact Us Page </strong></strong></font></td>
					  </tr>
					  <tr bgcolor="#FFFFFF">
						<td align="right" class="paragraph" valign="top" width="15%">Name</td>						
						<td align="left" class="paragraph" width="65%">'.$name.'</td>
					  </tr>
					  <tr bgcolor="#FFFFFF">
						<td align="right" class="paragraph" valign="top">E-mail</td>						
						<td align="left" class="paragraph">'.$email.'</td>
					  </tr>
					  <tr bgcolor="#FFFFFF">
						<td align="right" class="paragraph" valign="top">Telephone</td>						
						<td align="left" class="paragraph">'.$telephone.'</td>
					  </tr>
					   <tr bgcolor="#FFFFFF">
						<td align="right" class="paragraph" valign="top">Comments</td>						
						<td align="left" class="paragraph">'.wordwrap($message,100).'</td>
					  </tr>
					  </table></body></html>				
					';
				$mail_sent =  mail($to,$subject,$body,$headers);
				header("location:contact_us.php?formaction=send");
		}
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd"><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title>Wyze Up - Contact us</title>
<script language="javascript" src="includes/formvalidation.js" type="text/jscript"></script>
<script language="javascript" type="text/javascript">
function Validate()
{
	if (TextValidate(document.frmcontact.txtname,"Name")==false) return false;
	if (TextValidate(document.frmcontact.txtemail,"Email ID")==false) return false;
	if (EmailValidate(document.frmcontact.txtemail,"Email ID")==false) return false;
	if (TextAreaValidate(document.frmcontact.txtmessage,"Message")==false) return false;
	document.frmcontact.method= "post";
	document.frmcontact.action = "contact_us.php?formaction=sent";
	document.frmcontact.submit();
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
			  	 <img src="wyzeup_images/contact-us.gif" title="Contact us" alt="Contact Us" width="518" height="32">
				 <?php 	
					  			if(isset($_GET['formaction']) && $_GET['formaction'] == 'send') 
					  			{ 
									echo "<div id='contentapply'><div id='formlayerapplication'>";
									echo "Thank you for contacting Wyze Up. We will be in touch with you soon by email or phone.";
									echo "</div></div>";
								}	
								else
								{
					  ?>
			  	  <p><a name="skipnav"></a>Please use the form below to send us your enquiry.</p>
			  	  <div id="contentcontactbox">
					<div id="formlayerapplication">
					 
								<form  name="frmcontact" method="post" action=""><div id="form-top"><span class="style2">*</span>are required fields</div><br>

										<label>Name <span class="style2">*</span></label>
										<input name="txtname" type="text" id="txtname" onClick="javascript:if(this.value=='Name'){this.value='' };" size="30" maxlength="60" />
										<br />
										<label>Email <span class="style2">*</span></label>
										<input name="txtemail" type="text" id="txtemail" onClick="javascript:if(this.value=='Email'){this.value='' };" size="30" maxlength="60" />
										<br />
										<label>Phone number</label>
										<input name="txtphone" type="text" id="txtphone" onClick="javascript:if(this.value=='Phone Number'){this.value='' };" size="30" maxlength="60" />
										<br />
										<label>Enter your message here <span class="style2">*</span></label>
										<textarea name="txtmessage" cols="20" rows="7" id="txtmessage" onClick="javascript:if(this.value=='Enter your message here'){this.value='' };"></textarea>
										<br/><br />
								  
								<a href="#"><img src="wyzeup_images/send-on.jpg" title="Send" width="71" height="25" border="0" onClick="javascript:Validate();" alt="Send"></a><br><br><br>
 </form>
						  <?	}?>	
			   </div>					  
		  </div>					  			  
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
