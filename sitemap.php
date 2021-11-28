<?php 
	session_start();
	require_once('conf/conf.inc.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title>Wyze Up - Site map</title>
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
		
		<img src="wyzeup_images/site-map.gif" title="Site map" width="518" height="32">
			<ul class="sitetxt"> 
				<li><a name="skipnav"></a><a href="index.php">Home</a> </li>
				<li><a href="about_us.php">About Us</a></li>
				<li><a href="how_it_works.php">How it Works</a></li>
				<li class="txtlink"><a href="pshce_curriculam.php">Pshce Curriculum </a> </li>
				<li class="txtlink"><a href="online_application.php">Apply</a></li>
				<li class="txtlink"><a href="accessibility.php">Accessibility</a></li>
				<li class="txtlink"><a href="contact_us.php">Contact Us</a></li>
			</ul>	    
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
