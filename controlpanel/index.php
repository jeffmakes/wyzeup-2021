<?php
	session_start();
	require_once("../conf/conf.inc.php");
	$menuactive="LOGIN";
	$username=$_POST["username"];
	$password=$_POST["password"];
	$status=$_POST["status"];
	if($status=="LOGIN"){
		$query="SELECT * FROM ".TABLE_ADMIN." WHERE administrator_username='$username' AND administrator_password='$password'";
		$execute_query=mysql_query($query);
		$row_count=mysql_num_rows($execute_query);
		if($row_count >0){
			$result=mysql_fetch_array($execute_query);
			$_SESSION["session_adminname"]	= $result["administrator_username"];
			$_SESSION["session_adminid"]	= $result["administrator_id"];
			header("Location:school_view.php");
		}else{
			$_SESSION["error"]="The username and password that you have entered do not match.";
		}
	}
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
<script language="javascript" src="../includes/formvalidation.js"></script>
<script language="javascript">
function validate(){
		if(TextValidate(document.frmindex.username,"the User Name")==false){ return false;}
		if(TextValidate(document.frmindex.password,"the Password")==false){ return false;}
}
</script>
<link href="../wyzeup_css/admin_wyze_up.css" rel="stylesheet" type="text/css">
</head>
<body>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="234" height="20"><img src="../wyzeup_images/wyzeup.JPG" width="191" height="66"></td>
        </tr>
      <tr>
        <td height="20"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="left" class="menu">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
	  <tr>
        <td valign="top">
		</td>
      </tr>	  
      <tr>
        <td valign="top">          <table width="95%" border="0" align="center" cellpadding="4" cellspacing="1">
              <tr>
                <td align="right" class="paragraph">&nbsp;</td>
              </tr>
              <tr>
                <td align="center"><table width="40%"  border="0" cellspacing="0" cellpadding="0">
			        <form name="frmindex" method="post" action="" onSubmit="javascript:return validate();">
			  	  <tr>
					  <td class="paragraph" align="center">
					  <?php if($_SESSION["error"]) echo $_SESSION["error"]; $_SESSION["error"]=""; ?>
					  </td>
				  </tr>
                    <tr>
                      <td bgcolor="#C5C5C5"><table width="100%"  border="0" cellspacing="1" cellpadding="4">
                          <tr bgcolor="#C5C5C5">
                            <td colspan="2" valign="top" bgcolor="#EFEFEF" class="h1"><div align="center">Login </div></td>
                          </tr>
                          
                          <tr bgcolor="#FFFFFF">
                            <td width="45%" valign="top" class="paragraph"><div align="right">User Name </div></td>
                            <td width="55%" class="paragraph"><input name="username" type="text" class="txtbox"></td>
                          </tr>
                          <tr bgcolor="#FFFFFF">
                            <td valign="top" class="paragraph"><p align="right">Password</p></td>
                            <td class="paragraph"><input name="password" type="password" class="txtbox"></td>
                          </tr>
						  
                        <tr bgcolor="#EFEFEF">
                            <td colspan="2" valign="top" class="paragraph"><div align="center">
							  <input name="status" type="hidden" class="txtbox" value="LOGIN">
                              <input name="Submit" type="submit" value="Submit">
                              <input name="Reset" type="reset" value="Reset">
                            </div></td>
                            </tr>
                      </table></td>
                    </tr>
			     </form>
                </table>
			    </td>
              </tr>
			  
           <tr>
                <td align="right" class="paragraph">&nbsp;</td>
              </tr>
          </table></td>
      </tr>
      <tr>
        <td height="20" class="background_footer">&nbsp;</td>
      </tr>
      <tr>
        <td height="20" bgcolor="#E2E2E4"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td height="10" align="right" bgcolor="#7FA2B5" class="footer">&copy; Copyright 2007 Wyze Up. All rights reserved. </td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
