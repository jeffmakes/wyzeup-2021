<?php 
	ob_start();
	session_start();
	require_once('../conf/conf.inc.php');
	#User Existence validation
	$url = URL_ADMIN_LOGIN_REQUIRED;
	if(!check_admin_exist()){	  
	  html_refresh($url);
	}		
	$menuactive="SCHOOLS";
	if($_GET["school_id"]!="0" && $_GET["action"]=="delete"){ # Delete Operation
		 mysql_query("UPDATE safe_school SET school_isdeleted=1 WHERE school_id=".$_GET["school_id"]);
		 header("Location:school_view.php");
	}
	
	//$sql = "SELECT school_id,school_name, school_contactname, DATE_FORMAT(school_startdate,'%Y-%m-%d') as school_startdate,DATE_FORMAT(school_enddate,'%Y-%m-%d') as school_enddate,DATEDIFF(school_startdate,school_enddate) as days,school_email,school_phone,IF(school_status,'Active','InActive') as school_status,CONCAT('<a href=school.php?action=edit&school_id=',school_id,'>Edit</a> | <a href=school.php?action=view&school_id=',school_id,'>View</a>  | <a href=# onClick=Delete(school_id=',school_id,')>Delete</a>') as action FROM wyzeup_schools WHERE school_isdeleted = 0 AND school_status = 1";
	//$sql ="SELECT school_id, school_name, school_contactname, DATE_FORMAT(school_startdate, '%Y-%m-%d' ) AS school_startdate, DATE_FORMAT(school_enddate, '%Y-%m-%d' ) AS school_enddate, DATEDIFF(school_startdate, school_enddate) AS days, school_email, school_phone,IF (school_status, 'Active', 'InActive') AS school_status CONCAT('<a href=school.php?action=edit&school_id=',school_id,'>Edit</a> | <a href=school.php?action=view&school_id=',school_id,'>View</a>  | <a href=# onClick=Delete(school_id=',school_id,')>Delete</a>') as action FROM wyzeup_schools WHERE school_isdeleted =0 AND school_status =1";

	/*$sql = "SELECT school_id,school_name, school_contactname, school_startdate,school_enddate,school_email,school_phone,IF(school_status,'Active','InActive') as school_status,
	CONCAT('<a href=school.php?action=edit&school_id=',school_id,'>Edit</a> | <a href=school.php?action=view&school_id=',school_id,'>View</a> 
	 | <a href=# onClick=Delete(school_id=',school_id,')>Delete</a>') as action FROM wyzeup_schools WHERE school_isdeleted = 0 AND school_status = 1";
*/

	$sql="SELECT 
		  CASE 
		  	  WHEN school_enddate < CURDATE()
					THEN CONCAT('<font color=#FF0000><strong>',school_id,'</strong></font>')
		 	  WHEN DATEDIFF(school_enddate,CURDATE()) BETWEEN 0 and 30  
			   		THEN CONCAT('<font color=#FF9900><strong>',school_id,'</strong></font>')
				    ELSE CONCAT(school_id) 
		END,
		CASE 
			  WHEN school_enddate < CURDATE() 
					THEN CONCAT('<font color=#FF0000><strong>',school_name,'</strong></font>')
		 	  WHEN DATEDIFF(school_enddate,CURDATE()) BETWEEN 0 and 30  
			 		THEN CONCAT('<font color=#FF9900><strong>',school_name,'</strong></font>')
		  		    ELSE CONCAT(school_name) 
		END,
		CASE 
			  WHEN school_enddate < CURDATE() 
					THEN CONCAT('<font color=#FF0000><strong>',school_contactname,'</strong></font>')
		 	  WHEN DATEDIFF(school_enddate,CURDATE()) BETWEEN 0 and 30  
			 		THEN CONCAT('<font color=#FF9900><strong>',school_contactname,'</strong></font>')
		  		    ELSE CONCAT(school_contactname) 
		END,		
		CASE 
			  WHEN school_enddate < CURDATE() 
			  		THEN CONCAT('<font color=#FF0000><strong>',DATE_FORMAT(school_enddate,'%d-%m-%Y'),'</strong></font>')
		 	  WHEN DATEDIFF(school_enddate,CURDATE()) BETWEEN 0 and 30  
			  		THEN CONCAT('<font color=#FF9900><strong>',DATE_FORMAT(school_enddate,'%d-%m-%Y'),'</strong></font>') 
		 		    ELSE CONCAT(DATE_FORMAT(school_enddate,'%d-%m-%Y')) 
		END,		
		CASE 
			  WHEN school_enddate < CURDATE() 
			  		THEN CONCAT('<font color=#FF0000><strong>',school_email,'</strong></font>')
		 	  WHEN DATEDIFF(school_enddate,CURDATE()) BETWEEN 0 and 30  
			  		THEN CONCAT('<font color=#FF9900><strong>',school_email,'</strong></font>')
				  	ELSE CONCAT(school_email)
		END,
		
		CONCAT('<a href=school.php?action=edit&school_id=',school_id,'>Edit</a> | 
			 <a href=school.php?action=view&school_id=',school_id,'>View</a>| <a href=# onClick=Delete(',school_id,')>Delete</a>') as action 
		  FROM wyzeup_schools  WHERE school_isdeleted = 0 AND school_status = 1";



	$_SESSION['ex3']=$sql;
?> 
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Wyze Up </title>

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
<script type="text/javascript">
var customerGrid, ex3, detailGrid;
function bodyOnLoad() {
  var opts = {  headingRow    : 0,
                frozenColumns : 0,
                prefetchBuffer: true
             };
  // -1 on the next line tells LiveGrid to determine the number of rows based on window size
  ex3=new Rico.LiveGrid ('ex3', 10, 10, 'products_xmlquery.php',opts);
}

function keyfilter(txtbox,idx) {
  ex3.columns[idx].setFilter('LIKE',txtbox.value+'%',Rico.TableColumn.USERFILTER,function() {txtbox.value='';});
}
function Delete(id) {
	if(confirm("Do you want to delete the School?")) {	
		document.form1.action="school.php?action=delete&school_id="+id;
		document.form1.submit();
	}
}
</script>
<style type="text/css">
/*input { font-weight:normal;font-size:8pt;}*/
th div.ricoLG_cell { height:2.0em; }  /* the text boxes require a little more height than normal */
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
				 <td width="25%" height="20"><h1 class="h1"> List of Schools - Active </h1></td>
				 <td width="33%" class="paragraph">&nbsp;</td>
				 <td width="42%" class="paragraph"><a href="school.php">Click here to add School</a><!--a href="school_view.php">View New Applications</a--></td>
              </tr>
              <tr>
                <td colspan="3" align="center"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td> 
					 <form name="form1" method="post" action="">
                   <table id="ex3_header" class="ricoLiveGrid" cellspacing="0" cellpadding="0" width="100%">
                     <colgroup width="100%">
                     <col style='width:50px;'>
                     <col style='width:150px;'>
					 <col style='width:150px;'>					
					 <col style='width:200px;'>
					 <col style='width:150px;'>                     
					 <col style='width:150px;'>
                     </colgroup>
                     <tr>
                      <th width="55">ID</th>
                       <th width="150">School Name</th>
					    <th width="150">Contact Name </th>                      
                        <th width="109">Renewal/Expiration Date </th>						
                        <th width="156">E-Mail</th>
                        <th width="134">Action</th>
                     </tr>
                     <tr class='dataInput'>
                       <th><input type='text' onkeyup='keyfilter(this,0);' class="txtbox" size="5"></th>
                       <th><input type='text' onkeyup='keyfilter(this,1);' class="txtbox" size="15"></th>
					   <th>&nbsp;</th>                     
                       <th><input type='text' onkeyup='keyfilter(this,3);' class="txtbox" size="15"></th>
					   <th><input type='text' onkeyup='keyfilter(this,4);' class="txtbox" size="15"></th>
                       <th>&nbsp;</th>
                     </tr>
                   </table>
                </form>
					</td>
                  </tr>
              </table></td>
              </tr>
          </table>
	   </td>
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
