<?php 
	header ("Pragma: no-cache");
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	session_start();
	require_once('../conf/conf.inc.php');
	require_once('../dao/question_dao.php');
	
	#User Existence validation
	$url = URL_ADMIN_LOGIN_REQUIRED;
	if(!check_admin_exist()){	  
	  html_refresh($url);
	}	
	$menuactive="SCENARIOS";
	$submit			= trim($_GET['action']);
	//$scenario_id	= $_GET["scenario_id"];
	$scenario_id	= 1;
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
<script language="JavaScript" src="../includes/formvalidation.js"></script>
<script language="JavaScript" src="../includes/rank.js"></script>
<script type="text/javascript">
function Validate()
{     
	if(SelectValidate(document.frmrank.scenario_fk_id,"the Scenario Name")==false){ return false;}
    var length  = document.frmrank.question_list.length;
	document.frmrank.questionid.value ="";
	document.frmrank.question_list="";
	for(var i=0;i<length;i++){
		 if(document.frmrank.questionid.value) {
	   		 document.frmrank.questionid.value = document.frmrank.questionid.value+","+ document.frmrank.question_list.options[i].value;
		 } else {
		 	document.frmrank.questionid.value = document.frmrank.question_list.options[i].value;
		 }
    }		 
	document.frmrank.action="rank_question.php?action=rank";
	document.frmrank.submit();
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
				<li><a <?php if($menuactive=="HOME") echo "class=\"active\"";?> href="school_view">Home</a></li>				
				<li><a <?php if($menuactive=="USERS") echo "class=\"active\"";?> href="users_view.php">Manage Staff</a></li>
				<li><a <?php if($menuactive=="SCHOOLS") echo "class=\"active\"";?> href="school_view.php">Manage Schools</a></li>
				<li><a <?php if($menuactive=="SCENARIOS") echo "class=\"active\"";?> href="scenario_view.php">Manage Scenarios</a></li>
				<li><a <?php if($menuactive=="QUESTIONS") echo "class=\"active\"";?> href="question_view.php">Manage Questions</a></li>
				<li><a <?php if($menuactive=="PASSWORD") echo "class=\"active\"";?> href="changepassword_view.php">Change Password</a></li>
				<li><a href="logout.php">Logout</a></li>
				</ul>				
				</div>					
		</td>
      </tr>	 
      <tr>
        <td valign="top">          <table width="95%" border="0" align="center" cellpadding="4" cellspacing="1">
              <tr>
                <td align="left"><span class="h1">Rank Questions </span></td>
                <td align="left" class="paragraph"><a href="question_view.php?scenario_id=<?php echo $scenario_id; ?>">View Questions</a></td>
              </tr>
              <tr>
                <td colspan="2" align="center"><form name="frmrank" method="post" action="">
                  <table bgcolor="#FFFFFF" width="100%" border="0" cellspacing="1" cellpadding="4">
                    <tr>
                      <td align="right" valign="top" class="paragraph">&nbsp;</td>
                      <td align="center" valign="top" class="paragraph">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="right" valign="middle">&nbsp;</td>
                    </tr>
                    <tr>
                      <td align="right" valign="top" class="paragraph">Scenario Name </td>
                      <td align="center" valign="top" class="paragraph">:</td>
                      <td align="left" valign="top"><span class="paragraph">
                        <select name="scenario_fk_id" class="txtbox" id="scenario_fk_id"  onChange="javascript:Menu_List(document.frmrank.scenario_fk_id.value,'question')">
                          <option value="0" selected>Select Scenario</option>
                          <?php 
						  	$qry = " select scenario_id,scenario_name from safe_scenarios where scenario_isdeleted = 0";
							$res=mysql_query($qry);						  		
							while ($rs = mysql_fetch_array($res)) { 																	
							 if($rs[0] == $scenario_id) {
								   echo '<option value='.$rs[0].' selected>'.$rs[1].'</option>';
							 }   else {
								   echo '<option value='.$rs[0].'>'.$rs[1].'</option>';
							 }
						 }
							  ?>
                        </select>
                      </span></td>
                      <td align="right" valign="middle">&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="15%" align="right" valign="top" class="paragraph">Rank Questions </td>
                      <td width="3%" align="center" valign="top" class="paragraph">: </td>
                      <td width="27%" align="left" valign="top"><select name="question_list" id="question_list" size="10" class="txtbox">					   
                          <?php 
						  	$qry = " select question_id,question_name from safe_questions where scenario_fk_id =$scenario_id AND question_isdeleted = 0";
							$res=mysql_query($qry);						  		
							while ($rs = mysql_fetch_array($res)) { 																	
							 if($rs[0] == $question_id) {
								   echo '<option value='.$rs[0].' selected>'.$rs[1].'</option>';
							 }   else {
								   echo '<option value='.$rs[0].'>'.$rs[1].'</option>';
							 }
						 }
							  ?>
                        </select>
                      </td>
                      <td width="55%" align="right" valign="middle"><table width="100%"  border="0">
                          <tr>
                            <td width="20%"><input type="button" name="movetop_btn" value="Top" class="submitbu" onClick="javascript :moveTopList(this.form.question_list);">
                            </td>
                            <td width="80%" class="paragraph">Click Top to move it to the first rank.</td>
                          </tr>
                          <tr>
                            <td><input type="button" name="moveup_btn"  class="submitbu" value="+" onClick="javascript : moveUpList(this.form.question_list);">
                            </td>
                            <td class="paragraph">Click + to move it one rank up. </td>
                          </tr>
                          <tr>
                            <td><input type="button" name="movedown_btn"  class="submitbu" value="-" onClick="javascript :moveDownList(this.form.question_list);">
                            </td>
                            <td class="paragraph">Click - to move it one rank down </td>
                          </tr>
                          <tr>
                            <td><input type="button" name="movebottom_btn"  class="submitbu" value="Bottom" onClick="javascript : moveBottomList(this.form.question_list);">
                            </td>
                            <td class="paragraph">Click Bottom to move it last rank.</td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td align="right">&nbsp;</td>
                      <td align="center">&nbsp;</td>
                      <td colspan="2"><input name="action1" type="hidden" id="action1" value="">
                          <input type="hidden" name="questionid" value=" ">
                          <input name="renkbtn" type="button" class="submitbu" id="rankbtn" onClick="javascript:Validate()" value="Rank">
                          <input name="Submit" type="button" class="submitbu" value="Back" onClick="javascript:history.go(-1);">
                      </td>
                    </tr>
                  </table>
                </form></td>
              </tr>
          </table></td>
      </tr>
      <tr>
        <td height="20" class="background_footer">&nbsp;</td>
      </tr>
      <tr>
        <td height="10" align="right" bgcolor="#7FA2B5" class="footer">
		&copy; Copyright 2006 Wyze Up player. All rights reserved. </td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
 