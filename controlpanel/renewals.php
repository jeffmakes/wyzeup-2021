<?php 
	ob_start();
	header ("Pragma: no-cache");
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	session_start();
	require_once('../conf/conf.inc.php');
	require_once('../dao/school_dao.php');
	
	#User Existence validation
	$url = URL_ADMIN_LOGIN_REQUIRED;
	if(!check_admin_exist()){	  
	  html_refresh($url);
	}
	$menuactive="RENEWALS";
	
	#Changing the Dateformat to store in db
	if($_POST["school_startdate"]){
	  	$date1=explode("-",trim($_POST["school_startdate"]));
		$startdate=$date1[2]."-".$date1[1]."-".$date1[0];
	}
	if($_POST["school_enddate"]){
	  	$date2=explode("-",trim($_POST["school_enddate"]));		$enddate=$date2[2]."-".$date2[1]."-".$date2[0];
	}

	#Object Instantiation for Scenario typeDAO
	$school			  =  new SchoolDO();
	$school_dao       =  new SchoolDAO(); 

	$submit			= trim($_GET['action']);
	$school_id		= $_GET["school_id"];
	
	#To Get the Real Expiry Date
				//$previousdate1 = mktime(0, 0, 0, date("n"), date("j")+9, date("Y")+1);		
				//$expirydate = date("Y-m-d", $previousdate1);
	if($_POST["school_startdate"]){
		$previousdate1 = explode('-',$_POST["school_enddate"]);
		$previousdate2 = mktime(0, 0, 0, date($previousdate1[1]), date($previousdate1[0]+9), date($previousdate1[2]));
		$expirydate = date("Y-m-d", $previousdate2);
	}

#To display default country
	if(empty($school->school_country)){
		$school->school_country    =  "GB";
	}
	//$submit 		        				= $_POST['action1'];
	
		#School Details
		$school->school_id						= trim($_POST['school_id']);	 
		$school->school_name 					= trim($_POST["school_name"]);
		$school->school_password				= trim($_POST["school_password"]);
		//$school_password						= trim($_POST["school_password"]);
		//$school->password           			=  $school_password;
		$school->school_password    			=  trim($_POST["school_password"]);//pw_encode($school_password);
		$school->school_contactname				= trim($_POST["school_contactname"]);
		$school->school_contactperson_position	= trim($_POST["school_contactperson_position"]);	
		$school->school_startdate 				= $startdate;
		$school->school_enddate 				= $enddate;
		$school->school_expirydate 				= $expirydate;
		$school->school_address1 				= trim($_POST["school_address1"]);
		$school->school_address2 				= trim($_POST["school_address2"]);
		$school->school_address3 				= trim($_POST["school_address3"]);
		$school->school_city	 				= trim($_POST["school_city"]);
		$school->school_country 				= trim($_POST["school_country"]);
		$school->school_zipcode 				= trim($_POST["school_zipcode"]);	
		$school->school_email 					= trim($_POST["school_email"]);	
		//$school->schoolpassword					= trim($_POST["school_confirm_password"]);	
		//$school->school_confirm_password   		=  pw_encode($school->schoolpassword);
		$school->school_invoice_to				= trim($_POST["school_invoice_to"]);			
		$school->school_proforma_invoice		= trim($_POST["school_proforma_invoice"]);						
		$school->school_phone 					= trim($_POST["school_phone"]);			
		$school->school_status					=  1;//trim($_POST["school_status"]);
	
	
	
	##code for approve

if ($_GET["action"] == "approve") {
	$error_messages   =  $school_dao->School_Update($school);
	$res_set = 	mysql_query("UPDATE wyzeup_renewals SET renewal_isapproved = 2 , renewal_enddate = '".$school->school_enddate."' WHERE renewal_school_id=".$_REQUEST["school_id"]);
	//printf("Records deleted: %d\n", mysql_affected_rows());
	if(mysql_affected_rows() > 0){
		$select_qry = "SELECT * , DATE_FORMAT(school_enddate,'%d-%m-%Y') as school_enddate FROM wyzeup_schools WHERE   school_id = ".$_REQUEST["school_id"]." AND school_status = 1 AND school_isdeleted = 0";
		$result_renew = mysql_query($select_qry);
		$renew_row = mysql_fetch_array($result_renew);
		
		// Is the OS Windows or Mac or Linux
			if (strtoupper(substr(PHP_OS,0,3)=='WIN')) {
				$eol="\r\n";
			} elseif (strtoupper(substr(PHP_OS,0,3)=='MAC')) {
				$eol="\r";
			} else {
				$eol="\n";
			}
			##Sending Email to the Schools  
			$date	  = date("d-m-Y H:i");			
			$message  = "<html><head></head><body><table cellpadding='3' cellspacing='1' border='0' align='center' bgcolor='#1AAEBC' width='600px'>";
			$message  = $message . "<tr><td bgcolor='#FFFFFF' colspan='2' align='center'><font size='2' color='#660033' face=verdana><strong>Wyzeup  - School Renewal</strong></font></td></tr>";
			$message  = $message . "<tr><td bgcolor='#FFFFFF' colspan='2'><font face='verdana, arial' size='2' color='#660033'>Dear ".$renew_row['school_contactname'].",</font></td></tr>";
			$message  = $message . "<tr><td bgcolor='#FFFFFF' colspan='2'><font face='verdana, arial' size='2' color='#660033'>Thank you for your membership over the past year.  Your subscription has been renewed for another year.</font></td></tr>";
			$message  = $message . "<tr><td bgcolor='#FFFFFF' colspan='2'><font face='verdana, arial' size='2' color='#660033'>Your subscription will be due for renewal on ".$renew_row['school_enddate'] ." </font></td></tr>";
	//		$message  = $message . "<tr><td bgcolor='#FFFFFF' colspan='2'><font face='verdana, arial' size='2' color='#660033'>Click <a href='http://wyzeup.co.uk/contact_us.php' target='_blank'>here</a> to contact Wyze Up for Renewal.</font></td></tr>";
			
			
			//$message  = $message . "<tr><td bgcolor='#FFFFFF' colspan='2' align='center'><font size='2' color='#660033' face=verdana><strong>Please Click <a href='http://www.wyzeup.co.uk/renewalschools.php?schoolid=".$result_set_row["school_contactname"]."-".$result_set_row["school_id"]."'>here</a> to renew your membership</strong></font></td></tr>";
			$message  = $message . "</table></body></html>";
			$message  = $message . "<p align='left'><font size='2' color='#660033' face='verdana, arial'><strong>Thanks,<br>Wyze Up Team.<br><a href ='http://www.wyzeupp.co.uk'>www.wyzeup.co.uk</a></strong></font></p>";
			$to		  = $renew_row["school_email"];
			$subject  = "Wyzeup  - School Renewal";	
			
			$headers  =  "MIME-Version: 1.0".$eol; 						
			$headers .= "Content-type: text/html; charset=iso-8859-1".$eol; 
			$headers .= "X-Priority : 1".$eol; 
			$headers .= "X-MsMail-Priority : High".$eol; 
			$headers .= "From:Wyzeup <admin@wyzeup.co.uk>".$eol;
			$headers .= "X-Mailer: PHP v".phpversion().$eol;  
			$mailsent 	= mail($to,$subject, wordwrap($message,72), $headers);
	
	}
	header("Location:renewals_view.php");
} 
if ($_GET['action'] == "edit") {
	$school	= $school_dao->School_Read($school_id);	
} 

	
	
/*	#Add operation check
	if(empty($submit) && empty($_POST['school_id'])) {
		$school_id		=	trim($_GET['school_id']);	
		$submit		    =	trim($_GET['action']);	
	}
	if (empty($submit)) {
 		  define('SUBMIT_BUTTON', BUTTON_ADD); 
		  $submit = "add";
	}
	if ($submit == BUTTON_ADD) {
		define('SUBMIT_BUTTON', BUTTON_ADD);		
		$error_messages             = $school_dao->School_Create($school);
		/* if (!$error_messages) { 
		 	unset($school);
			unset($school_dao);*/
			//html_refresh("school_view_active.php");
			//header("location:school_view_active.php");
		// } 
 	/*  } 
	   if ($submit == BUTTON_EDIT) {
			define('SUBMIT_BUTTON', BUTTON_EDIT); 		
 			$error_messages   =  $school_dao->School_Update($school);
 			//if (!$error_messages) {			
				//html_refresh("school_view_active.php");
				header("location:school_view_active.php");
			//}	
	  } 
	  if ($submit == "edit" || $submit == "view") {
			define('SUBMIT_BUTTON', BUTTON_EDIT); 
			$submit = SUBMIT_BUTTON;	
			$school	= $school_dao->School_Read($school_id);
 	} 
	  if ($submit == "delete") {
			$school_dao->School_Delete($school_id);
			//html_refresh("school_view_active.php");
			header("location:school_view_active.php");
	  }	
	  if($submit == "add"){
		$submit = SUBMIT_BUTTON;
	  }	
	*/
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
	var form_name = document.frmrenewal;	
	if(TextValidate(form_name.school_name,"the school name")==false){return false;}	
	if(TextValidate(form_name.school_contactname,"the contact person")==false){return false;}
	if(TextValidate(form_name.school_startdate,"the startdate")==false){return false;}
	if(DateFormatValidate(form_name.school_startdate,"the startdate")==false){return false;}
	if(TextValidate(form_name.school_enddate,"the enddate")==false){return false;}
	if(DateFormatValidate(form_name.school_enddate,"the enddate")==false){return false;}
	if(Comparedate(form_name.school_startdate,form_name.school_enddate)==false){return false;}
	if(TextValidate(form_name.school_address1,"the address1")==false){return false;}
	if(TextValidate(form_name.school_city,"the city")==false){return false;}
	if(TextValidate(form_name.school_country,"the country")==false){return false;}
	if(TextValidate(form_name.school_zipcode,"the zipcode")==false){return false;}
	if(TextValidate(form_name.school_email,"the email")==false){return false;}
	if(EmailValidate(form_name.school_email,"the email")==false){return false;}
	if(TextValidate(form_name.school_phone,"the phone")==false){return false;}
	/*if(form_name.school_status.checked==true){
		form_name.school_status.value = 1;			
	} else {
		form_name.school_status.value = 0;
	}*/
	form_name.action = "renewals.php?action=approve";
	form_name.submit();
}

</script>
<style type="text/css">
/*input { font-weight:normal;font-size:8pt;}*/
th div.ricoLG_cell { height:2.5em; }  /* the text boxes require a little more height than normal */
</style>
<link href="../wyzeup_css/admin_wyze_up.css" rel="stylesheet" type="text/css">
</head>
<body onLoad="bodyOnLoad()">
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
                <td align="left"><span class="h1"><?php if($_GET["action"]!="view"){ echo "Modify"; } else { echo "View"; }?> Renewal School Details </span></td>
                <td align="left" class="paragraph"><a href="school_view_active.php">View Schools</a></td>
              </tr>
              <tr>
                <td colspan="2" align="center"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
			    <?php if($_GET["action"]!="view"){ ?>
                  <tr>
                    <td bgcolor="#C5C5C5"> <form name="frmrenewal" method="post" action="" enctype="multipart/form-data">
				    <table width="100%"  border="0" cellspacing="1" cellpadding="4">
				      <tr align="left" bgcolor="#FFFFFF">
				        <td colspan="2" valign="top" class="h1">&nbsp;</td>
				        </tr>
				      <tr>
                        <td width="32%" align="right" valign="top" bgcolor="#EFEFEF" class="paragraph"><span class="mandatory">*&nbsp;</span> School Name :</td>
                        <td valign="top" bgcolor="#FFFFFF" class="paragraph"><input name="school_name" type="text" class="txtbox" id="school_name" value="<?php echo $school->school_name;?>">
                          <?php if (isset($error_messages['school_name'])) { echo '<span class="paragraphred">'.$error_messages['school_name'].'</span>';}?>
                          
                        </td>
				        </tr>				      
				      <tr>
                        <td align="right" valign="top" bgcolor="#EFEFEF" class="paragraph"><span class="mandatory">*</span> Contact Person : </td>
                        <td valign="top" bgcolor="#FFFFFF" class="paragraph"><input name="school_contactname" type="text" class="txtbox" id="school_contactname" value="<?php echo $school->school_contactname;?>">
                          <?php if (isset($error_messages['school_contactname'])) { echo '<span class="paragraphred">'.$error_messages['school_contactname'].'</span>';}?></td>
				        </tr>
						
					     <tr>
					       <td align="right" valign="top" bgcolor="#EFEFEF" class="paragraph"><span class="mandatory">*</span> Position : </td>
					       <td valign="top" bgcolor="#FFFFFF" class="paragraph"><input name="school_contactperson_position" type="text" class="txtbox" id="school_contactperson_position" value="<?php echo $school->school_contactperson_position;?>">
					         <?php if (isset($error_messages['school_contactperson_position'])) { echo '<span class="paragraphred">'.$error_messages['school_contactperson_position'].'</span>';}?></td>
					       </tr>
					     <tr>
					       <td align="right" valign="top" bgcolor="#EFEFEF" class="paragraph"><span class="mandatory">*</span> Start Date : </td>
					       <td valign="top" bgcolor="#FFFFFF" class="paragraph">					       
						     <input name="school_startdate" type="text" class="txtbox" id="school_startdate" value="<?php 	  if($_GET['action'] == 'edit'){	$date1=explode("-",trim($school->school_startdate)); $startdate=$date1[0]."-".$date1[1]."-".$date1[2]; if($school->school_startdate){  echo $startdate; } }else { $date1=explode("-",trim($school->school_startdate)); $startdate=$date1[2]."-".$date1[1]."-".$date1[0]; if($school->school_startdate){  echo $startdate; } }?>" readonly="">
							 <script language="javascript" src="../includes/popcalendar.js"></script>
                                  <SCRIPT language=javascript>
							<!--
								if (!document.layers) {
									document.write("<img src='../wyzeup_images/calicon.gif' width='39' height='21' border='0' align='absmiddle' alt='Select Date' onclick='popUpCalendar(this, frmrenewal.school_startdate, \"dd-mm-yyyy\");document.frmrenewal.school_startdate.disabled=false' style='cursor: hand;'>")
								}
							//-->
			              </SCRIPT>                             
							 <?php if (isset($error_messages['school_startdate'])) { echo '<span class="paragraphred">'.$error_messages['school_startdate'].'</span>';}?>
</td>
					       </tr>
						<?php //if($_GET['action'] == ) { ?> 
					     <tr>
					       <td align="right" valign="top" bgcolor="#EFEFEF" class="paragraph"><span class="mandatory">*</span> End Date : </td>
					       <td valign="top" bgcolor="#FFFFFF" class="paragraph">
					         <input name="school_enddate" type="text" class="txtbox" id="school_enddate" value="<?php  if($_GET['action'] == 'edit'){$date2=explode("-",trim($school->school_enddate));		$enddate=$date2[0]."-".$date2[1]."-".$date2[2]; if($school->school_enddate){ echo $enddate; } }else { $date2=explode("-",trim($school->school_enddate));		$enddate=$date2[2]."-".$date2[1]."-".$date2[0]; if($school->school_enddate){ echo $enddate; } }?>" readonly="">
                             <script language="javascript" src="../includes/popcalendar.js"></script>
                                  <SCRIPT language=javascript>
							<!--
								if (!document.layers) {
									document.write("<img src='../wyzeup_images/calicon.gif' width='39' height='21' border='0' align='absmiddle' alt='Select Date' onclick='popUpCalendar(this, frmrenewal.school_enddate, \"dd-mm-yyyy\");document.frmrenewal.school_enddate.disabled=false' style='cursor: hand;'>")
								}
							//-->
			              </SCRIPT>
							 <?php if (isset($error_messages['school_enddate'])) { echo '<span class="paragraphred">'.$error_messages['school_enddate'].'</span>';}?>
                             <?php if (isset($error_messages['school_compdate'])) { echo '<span class="paragraphred">'.$error_messages['school_compdate'].'</span>';}?></td>
					       </tr>
						   <?php //} ?>
					     <tr>
					       <td align="right" valign="top" bgcolor="#EFEFEF" class="paragraph"><span class="mandatory">*</span> Address 1 : </td>
					       <td valign="top" bgcolor="#FFFFFF" class="paragraph">
					         <input name="school_address1" type="text" class="txtbox" id="school_address1" value="<?php echo $school->school_address1;?>">
                             <?php if (isset($error_messages['school_address1'])) { echo '<span class="paragraphred">'.$error_messages['school_address1'].'</span>';}?>
</td>
					       </tr>
					     <tr>
                           <td align="right" valign="top" bgcolor="#EFEFEF" class="paragraph"> Address 2 : </td>
                           <td valign="top" bgcolor="#FFFFFF" class="paragraph">
                             <input name="school_address2" type="text" class="txtbox" id="school_address2" value="<?php echo $school->school_address2;?>">
                             <?php if (isset($error_messages['school_address2'])) { echo '<span class="paragraphred">'.$error_messages['school_address2'].'</span>';}?>
</td>
					       </tr>
					     <tr>
                           <td align="right" valign="top" bgcolor="#EFEFEF" class="paragraph"><span class="mandatory">*</span> City : </td>
                           <td valign="top" bgcolor="#FFFFFF" class="paragraph">
                             <input name="school_city" type="text" class="txtbox" id="school_city" value="<?php echo $school->school_city;?>">
                             <?php if (isset($error_messages['school_city'])) { echo '<span class="paragraphred">'.$error_messages['school_city'].'</span>';}?>
</td>
					       </tr>
					     <tr>
                           <td align="right" valign="top" bgcolor="#EFEFEF" class="paragraph"><span class="mandatory">*</span> Country : </td>
                           <td valign="top" bgcolor="#FFFFFF" class="paragraph">
                             <?php   echo generate_list_from_array('school_country', $arrcountries,$school->school_country,$first_option='Please Choose...',$school->school_country,'txtbox');?>
                             <?php if (isset($error_messages['school_country'])) { echo '<span class="paragraphred">'.$error_messages['school_country'].'</span>';}?>
</td>
					       </tr>
					     <tr>
                           <td align="right" valign="top" bgcolor="#EFEFEF" class="paragraph"><span class="mandatory">*</span> Zipcode : </td>
                           <td valign="top" bgcolor="#FFFFFF" class="paragraph">
                             <input name="school_zipcode" type="text" class="txtbox" id="school_zipcode" value="<?php echo $school->school_zipcode;?>">
                             <?php if (isset($error_messages['school_zipcode'])) { echo '<span class="paragraphred">'.$error_messages['school_zipcode'].'</span>';}?>
</td>
					       </tr>
					     <tr>
					       <td align="right" valign="top" bgcolor="#EFEFEF" class="paragraph"><span class="mandatory">*</span> E-Mail : </td>
					       <td valign="top" bgcolor="#FFFFFF" class="paragraph">
					         <input name="school_email" type="text" class="txtbox" id="school_email" value="<?php echo $school->school_email;?>">
							 <?php if($error_messages["school_email"]){ echo "<span class='paragraphred'>".$error_messages["school_email"]."</span>";}?>
					       </td>
					       </tr>
						   <?php //if($_GET['action'] != 'edit') {?>
						   <tr>
					       <td align="right" valign="top" bgcolor="#EFEFEF" class="paragraph"><span class="mandatory">*</span> Password : </td>
					       <td valign="top" bgcolor="#FFFFFF" class="paragraph">
					         <input name="school_password" type="text" class="txtbox" id="school_password" value="<?php echo $school->school_password;?>">
							 <?php if($error_messages["school_password"]){ echo "<span class='paragraphred'>".$error_messages["school_password"]."</span>";}?>
					       </td>
					       </tr>
						   <?php //} else {  ?>
							   <!--input name="school_password" type="hidden" id="school_password" value="<?php echo $school->school_password;?>"-->
						   <?php //} ?>
					     <tr>
					       <td align="right" valign="top" bgcolor="#EFEFEF" class="paragraph"><span class="mandatory">*</span> Invoice To :</td>
					       <td valign="top" bgcolor="#FFFFFF" class="paragraph">
					         <input name="school_invoice_to" type="text" class="txtbox" id="school_invoice_to" value="<?php echo $school->school_invoice_to;?>">
                             <?php if($error_messages["school_invoice_to"]){ echo "<span class='paragraphred'>".$error_messages["school_invoice_to"]."</span>";}?>
</td>
					       </tr>
					     <tr>
					       <td align="right" valign="top" bgcolor="#EFEFEF" class="paragraph"><span class="mandatory">*</span> Proforma Required : </td>
					       <td valign="top" bgcolor="#FFFFFF" class="paragraph">
					         <input name="school_proforma_invoice" type="text" class="txtbox" id="school_proforma_invoice" value="<?php echo $school->school_proforma_invoice;?>">
                             <?php if($error_messages["school_proforma_invoice"]){ echo "<span class='paragraphred'>".$error_messages["school_proforma_invoice"]."</span>";}?>
</td>
					       </tr>
					     <tr>
					       <td align="right" valign="top" bgcolor="#EFEFEF" class="paragraph"><span class="mandatory">*</span> Phone : </td>
					       <td valign="top" bgcolor="#FFFFFF" class="paragraph">
					         <input name="school_phone" type="text" class="txtbox" id="school_phone" value="<?php echo $school->school_phone;?>">
                             <?php if (isset($error_messages['school_phone'])) { echo '<span class="paragraphred">'.$error_messages['school_phone'].'</span>';}?>
</td>
					       </tr>					  
                        <tr>
                          <td bgcolor="#EFEFEF" class="paragraph">&nbsp;</td>
                          <td valign="top" bgcolor="#EFEFEF" class="paragraph">
						   <input name="action1" type="hidden" id="action1" value="<?php echo $submit;?>">						
						  <input name="school_id" type="hidden" id="school_id" value="<?php echo $school->school_id;?>">
						  <input name="school_status" type="hidden" id="school_status" value="<?php echo $school->school_status;?>">						  
						  <input name="submitbtn" type="button" value="Approve Renewal" onClick="javascript:validate();">
                          <input name="Reset" type="reset" value="Reset">
						  </td>
                          </tr>
                    </table>
				    </form></td>
                  </tr>
				  <?php } else {?>	  
			        <tr>
                    <td bgcolor="#C5C5C5">&nbsp;				    </td>
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
 