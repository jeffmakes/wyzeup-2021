<?php 
	header ("Pragma: no-cache");
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	session_start();
	require_once('../conf/conf.inc.php');
	#User Existence validation
	$url = URL_ADMIN_LOGIN_REQUIRED;
	if(!check_admin_exist()){	  
	  html_refresh($url);
	}	
	$menuactive="QUESTIONS";
	$scenario_id = $_GET['scenario_id'];
	$question_id = $_GET["question_id"];	
	if($_GET["question_id"]!="0" && $_GET["action"]=="delete"){ # Delete Operation
		 mysql_query("UPDATE wyzeup_questions SET question_isdeleted = 1 WHERE question_id=".$_GET["question_id"]);
	//	 header("Location:question_view.php");
	}
 
	//if(!$_GET['scenario_id']){ 
		///$sql = "SELECT question_id,scenario_name,question_name,question_option1,question_option2,question_option3,question_option4,question_answer,question_rank,IF(question_status,'Active','InActive') as question_status,CONCAT('<a href=question.php?action=edit&question_id=',question_id,'&scenario_id=',scenario_id,'>Edit</a> | <a href=question.php?action=view&question_id=',question_id,'&scenario_id=',scenario_id,'>View</a>  | <a href=# onClick=Delete(question_id=',question_id,',scenario_id=',scenario_id,')>Delete</a>') as action FROM wyzeup_questions INNER JOIN wyzeup_scenarios ON scenario_id =scenario_fk_id AND question_isdeleted = 0 AND scenario_status = 1";
		$sql = "SELECT question_id,scenario_name,question_name,question_answer,question_rank,IF(question_status,'Active','InActive') as question_status,CONCAT('<a href=question.php?action=edit&question_id=',question_id,'&scenario_id=',scenario_id,'>Edit</a> | <a href=question.php?action=view&question_id=',question_id,'&scenario_id=',scenario_id,'>View</a>  | <a href=# onClick=Delete(question_id=',question_id,',scenario_id=',scenario_id,')>Delete</a>') as action FROM wyzeup_questions INNER JOIN wyzeup_scenarios ON scenario_id =scenario_fk_id AND question_isdeleted = 0 AND scenario_status = 1";
	//}else{
		//$sql = "SELECT question_id,scenario_name,question_name,question_option1,question_option2,question_option3,question_option4,question_answer,question_rank,IF(question_status,'Active','InActive') as question_status,CONCAT('<a href=question.php?action=edit&question_id=',question_id,'&scenario_id=',scenario_id,'>Edit</a> | <a href=question.php?action=view&question_id=',question_id,'&scenario_id=',scenario_id,'>View</a>  | <a href=# onClick=Delete(question_id=',question_id,',scenario_id=',scenario_id,')>Delete</a>') as action FROM wyzeup_questions INNER JOIN wyzeup_scenarios ON scenario_id =scenario_fk_id AND question_isdeleted = 0 AND scenario_fk_id=".$_GET['scenario_id'];
	//}
	$_SESSION['ex3']=stripslashes($sql);
?> 
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
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
function Delete(id,qid) {
	if(confirm("Do you want to delete the Question?")) {	
		document.form1.action="question.php?action=delete&question_id="+id+"&scenario_id="+qid;
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
        <td height="20"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
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
                <td align="left" class="h1">List of Questions</td>
				 <?php //if($scenario_id){ ?>
                <td align="left" class="paragraph"><a href="question.php">Click here to add a Question</a></td>
				<?php //}?>
              </tr>
              <tr>
                <td colspan="2" align="center"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td> 
					 <form name="form1" method="post" action="">
                   <table id="ex3_header" class="ricoLiveGrid" cellspacing="0" cellpadding="0" width="100%">
                     <colgroup width="100%">
                     <col style='width:50px;'>
                     <col style='width:150px;'>
					 <col style='width:150px;'>					 
					 <col style='width:60px;'>
					 <col style='width:140px;'>
					 <col style='width:70px;'>
                     <col style='width:150px;'>
                     </colgroup>
                     <tr>
                       <th width="30">ID</th>
                       <th width="63">Scenario Name </th>
                       <th width="160">Question  Name</th>					   		   
					   <th width="45">Answer</th>
					   <th width="45">Sequence Number </th>
					   <th width="40">Status</th>
                       <th width="48">Action</th>
                     </tr>
                     <tr class='dataInput'>
                       <th><input type='text' onkeyup='keyfilter(this,0);' class="txtbox" size="5"></th>
                       <th><input type='text' onkeyup='keyfilter(this,1);' class="txtbox" size="15"></th>
                       <th><input type='text' onkeyup='keyfilter(this,2);' class="txtbox" size="15"></th>					  
					   <th>&nbsp;</th>
					   <th>&nbsp;</th>
					   <th>&nbsp;</th>
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
