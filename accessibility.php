<?php 
	session_start();
	require_once('conf/conf.inc.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title>Wyze Up</title>
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
		<img src="wyzeup_images/accessibility-statement.gif" alt="Accessibility Statements" title="Accessibility Statements" width="518" height="32"/>


           		<p>Wyze Up  is always looking to improve it's web sites and make them easier to use. We have designed our site in accordance with guidelines laid down by the Web Accessibility Initiative (WAI) and the RNIB.</p>
					
				
					<p>The guidelines include:</p>

					<div class="content_access">		
						<ul class="txtlink-sub2">
								<li>Using meaningful ALT text for all images to provide descriptive text.</li>
								<li>Using descriptive hyperlink text where necessary.</li>
								<li>Avoiding the use of frames, which are difficult for special browsers to interpret.</li>
								<li>Provide navigational short cuts for users of text only browsers and page readers.</li>
								<li>Using an easy-to-see web colour scheme.</li>
								<li>Using an easy to read font type, size and colour. </li>
						</ul><br />
					</div>


					<h2>Navigation</h2>
					<p>Making web sites easy to use goes further than just colours and fonts. We work hard to make sure our content is easy to read and easy to navigate, taking into consideration customers who use speech readers.<br /><br />
					Our main navigation options have been assigned keyboard access keys for users who don't use pointing devices (such as a mouse).</p>
				
					<h2>Changing the Way You View Our Site</h2>
					<p>If you want to alter the size of the text displayed on this site you can change the option in your Internet browser.</p>
				
					<h2>To Enlarge Text</h2>

					<div class="content_access">		
						<ul class="txtlink-sub2">
								<li>On the browser Tools menu select  'Internet Options' </li>
								<li>On the General tab, select 'Accessibility' </li>
								<li>Tick the 'Ignore font sizes specified on web pages' check box </li>
								<li>Click on 'OK' </li>
								<li>Click 'text size' </li>
								<li>Choose the size of text</li>
								<li>The text size can be changed in Internet Explorer through the View > Text Size menu. And in Mozilla/Netscape, through the View > Text Zoom menu.</li>
								<li>To increase the text size of this site, simply hold the CTRL key (PC) or CMD key (MAC) and use your mouse scroll up or down. </li>
								<li>If your browser or browsing device does not support style sheets at all, the content of each page is still readable.</li>
						</ul><br />
					</div>


					<h2>Keyboard Access Keys</h2>
					<p>Most modern browsers support jumping to specific page links by typing keys defined on the web site. On Windows, press ALT + an access key; on Macintosh, press Control + an access key.</p>

					
					<h2>Access Keys Used on this Site</h2>

					<div class="content_access">		
						<ul class="txtlink-sub2">
								<li>S - Skips Navigation </li>
								<li>0 - Accessibility Statement </li>
								<li>1 - Home Page</li>
								<li>2 - About Us</li>
								<li>3 - How it works</li>
								<li>4 - PSHCE curriculum</li>
								<li>5 - Apply</li>
								<li>6 - Contact</li>
						</ul>
					</div>



					<h2>Known Browser Support</h2>
					<p>Wyze Up have designed and built its website to operate on a wide range of browser technologies. Below is a list of browsers the site has been tested in.</p>
					
					<h2>PC Operating Systems</h2>
						<div class="content_access">		
							<ul class="txtlink-sub2">
								<li>Internet Explorer 6, 5.5, and 5</li>
								<li>Mozilla Firebird 0.7</li>
								<li>Mozilla Firefox 0.8</li>
								<li>Netscape Navigator 7.0</li>
								<li>Opera 7.5 </li>
								<li>Lynx</li>
							</ul><br />
						</div>


					<h2>Mac Operating Systems:</h2>
						<div class="content_access">		
							<ul class="txtlink-sub2">
								<li>Safari 1.0.1</li>
								<li>Internet Explorer 5.2</li>
								<li>Mozilla Firebird 0.7</li>
							</ul><br />
						</div>

					<p>There may be some inaccuracies with page rendering in isolated cases, if this occurs, please contact us with the page you are having problems with.</p>

					<h2>Accessibility Software</h2>
						<div class="content_access">		
							<ul class="txtlink-sub2">
									<li>JAWS, a screen reader for Windows. A time-limited, downloadable demo is available. </li>
									<li>Home Page Reader, a screen reader for Windows. A downloadable demo is available.</li>
									<li>Lynx, a free text-only web browser for blind users with refreshable Braille displays. </li>
									<li>Links, a free text-only web browser for visual users with low bandwidth.</li>
									<li>Opera, a visual browser with many accessibility-related features, including text zooming, user style sheets, image toggle. A free downloadable version is available. Compatible with Windows, Macintosh, www, and several other operating systems.</li>
							</ul><br />
						</div>


					<h2>Web Standards and Browser Compatibility</h2>
						<div class="content_access">		
							<ul class="txtlink-sub2">
									<li>This site uses cascading style sheets for visual layout and is built to W3C standards. The XHTML and CSS is valid and the site, according to our judgment of the guidelines, complies with the WAI Level 3 accessibility guidelines.</li>
									<li>This site has been tested in all modern browsers on Windows, MacOS and Linux. Pages on this site benefit from structured semantic markup. This means that if your browser or browsing device does not support style sheets, the content of each page is still readable and is presented in a logical order. You can choose to switch off style sheets in many modern browsers if you so wish. </li>
							</ul><br />
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
