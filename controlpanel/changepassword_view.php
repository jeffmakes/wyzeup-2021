<?php
	session_start();
	require_once("../conf/conf.inc.php");
	$menuactive="PASSWORD";
	$administrator_username	= $_POST["administrator_username"];
	$administrator_name		= $_POST["administrator_name"];
	$old_password			= $_POST["old_password"];
	$new_password			= $_POST["new_password"];
	$status					= $_POST["status"];
	$query					= "SELECT * from wyzeup_administrators where administrator_id=1";
	$rs=mysql_query($query);
	$row=mysql_fetch_array($rs);
	if($status=="CHANGE"){
		//$query="SELECT * FROM lpc_administrators WHERE administrator_username='$administrator_username' AND administrator_password='$old_password'";
		//echo $query;
		//$execute_query=mysql_query($query);
		//$row_count=mysql_num_rows($execute_query);
		if($row["administrator_password"]==$old_password){
			$query="UPDATE wyzeup_administrators SET administrator_password='$new_password', administrator_name='$administrator_name' where administrator_id='1'";
			//echo $query;
			mysql_query($query);
			$query = "SELECT * from wyzeup_administrators where administrator_id=1";
			$rs=mysql_query($query);
			$row=mysql_fetch_array($rs);		
			//header("Location:categories_view.php");
			$error="The password has been changed successfully";
		}else{
			$error="The old password that you have typed is invalid. <br> You need to enter the correct password to change to the new one.";
		}
	}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Wyze Up Change Password</title>

<script language="JavaScript" type="text/JavaScript">
<!--

  

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script> 
<link href="../lpc_css/ricoLiveGrid.css" type="text/css" rel="stylesheet" />
<script src="../includes/prototype.js" type="text/javascript"></script>
<script src="../includes/ricoCommon.js" type="text/javascript"></script>
<script src="../includes/ricoLiveGrid.js" type="text/javascript"></script>
<script language="JavaScript" src="../includes/formvalidation.js"></script>
<script type="text/javascript">
var customerGrid, ex3, detailGrid;

function bodyOnLoad() {
//do nothing
}

function keyfilter(txtbox,idx) {
  ex3.columns[idx].setFilter('LIKE',txtbox.value+'%',Rico.TableColumn.USERFILTER,function() {txtbox.value='';});
}


function validate()
{
	var form_name=document.password;
	if(TextValidate(form_name.old_password,"Old Password")==false){return false;}
	if(TextValidate(form_name.new_password,"New Password")==false){return false;}
	if(TextValidate(form_name.confirm_password,"Confirm Password")==false){return false;}
	if(Comparetextboxes(form_name.new_password,form_name.confirm_password)==false){return false;}
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
                <td align="center" class="h1"><div align="left">Change Password </div></td>
                <td align="center" class="paragraph"></td>
              </tr>
              <tr>
                <td colspan="2" align="center"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
			    <tr>
					  <td class="paragraph" align="center">
					  <?php echo $error; ?>
					  </td>
				  </tr>
                  <tr>
                   <td bgcolor="#C5C5C5"><form name="password" method="post" action="" onSubmit="javascript:return validate();">
				    <table width="100%"  border="0" cellspacing="1" cellpadding="4">
				     <tr>
                          <td bgcolor="#EFEFEF" width="23%" class="paragraph"><div align="right"><strong>User Name : </strong></div></td>
                          <td bgcolor="#FFFFFF" width="77%" class="paragraph">
						  <input type="text" name="administrator_username" value="<?php echo $row["administrator_username"]; ?>" readonly="readonly">
						  <input type="hidden" name="admin_id" value="1" readonly="readonly">
                        </tr>
				     <tr>
                          <td bgcolor="#EFEFEF" width="23%" class="paragraph"><div align="right"><strong>Administrator Name : </strong></div></td>
                          <td bgcolor="#FFFFFF" width="77%" class="paragraph">
						  <input type="text" name="administrator_name" value="<?php echo $row["administrator_name"]; ?>">
                        </tr>					  
                        <tr>
                          <td bgcolor="#EFEFEF" width="23%" class="paragraph"><div align="right"><strong>Old Password : </strong></div></td>
                          <td bgcolor="#FFFFFF" width="77%" class="paragraph">
						  <input name="old_password" type="password" class="txtbox" value=""></td>
                        </tr>
					    <tr>
                          <td bgcolor="#EFEFEF" width="23%" class="paragraph"><div align="right"><strong>New Password : </strong></div></td>
                          <td bgcolor="#FFFFFF" width="77%" class="paragraph">
						  <input name="new_password" type="password" class="txtbox" value=""></td>
                        </tr>
					    <tr>
                          <td bgcolor="#EFEFEF" width="23%" class="paragraph"><div align="right"><strong>Confirm Password : </strong></div></td>
                          <td bgcolor="#FFFFFF" width="77%" class="paragraph">
						  <input name="confirm_password" type="password" class="txtbox" value=""></td>
                        </tr>
                        <tr>
							<td bgcolor="#EFEFEF" class="paragraph"></td>
                          <td valign="top" bgcolor="#EFEFEF" class="paragraph">
						  <input name="status" type="hidden" class="txtbox" value="CHANGE">
						  <input name="Submit" type="submit" value="Update">
                          <input name="Reset" type="reset" value="Reset"></td>
                          </tr>
                    </table>
				    </form></td>
                  </tr>
		   
              </table></td>
              </tr>
          </table></td>
      </tr>
      <tr>
        <td height="20" class="background_footer">&nbsp;</td>
      </tr>
      <tr>
        <td height="10" align="right" bgcolor="#7FA2B5" class="footer">
		&copy; Copyright 2007 Wyze Up. All rights reserved.</td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
