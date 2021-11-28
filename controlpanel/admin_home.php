<?php 
	session_start();
	require_once("../conf/conf.inc.php");
	require_once("../conf/conf.mysql.php");	
	error_reporting(E_ALL ^ E_NOTICE);
	$homepage 		= "school_view";
	$menuactive		= "HOME";
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
        <td valign="top">          
		<table width="80%" border="0" align="center" cellpadding="4" cellspacing="1">
              <tbody>
                <tr>
                  <td colspan="2" align="left" class="h1">Welcome to WYZE UP CMS! Publish Content on your website.</td>
                </tr>
                <tr>
                  <td width="329" align="left" valign="top" class="h5">&nbsp;</td>
                  <td width="374" align="right" class="h5">&nbsp;</td>
                </tr>
                <tr>
                  <td width="40%" align="left" valign="top" class="h5"><table cellspacing="0" cellpadding="0" width="90%" 
                                align="center" border="0">
                    <tbody>
                      <tr>
                        <td align="middle" colspan="2">
						<img height="112" alt="Content Management"  src="../wyzeup_images/wom_content_management.jpg" width="237" /></td>
                      </tr>
                      <tr>
                        <td align="middle" width="47">&nbsp;</td>
                        <td align="left" width="220">
						<table cellspacing="2" cellpadding="4" width="100%" border="0">
                            <tbody>
                              <tr>
                                <td><img height="11" src="../wyzeup_images/admin_arrow.jpg" width="11" /></td>
                                <td class="paragraph"><a href="users_view.php">Manage Users</a></td>
                              </tr>
                              <tr>
                                <td><img height="11" src="../wyzeup_images/admin_arrow.jpg" width="11" /></td>
                                <td class="paragraph"><a href="school_view.php">Manage Schools</a> </td>
                              </tr>
                              <tr>
                                <td><img height="11" src="../wyzeup_images/admin_arrow.jpg" width="11" /></td>
                                <td class="paragraph"><a href="scenario_view.php">Manage Scenarios</a></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td class="paragraph"><table cellspacing="2" cellpadding="4" width="100%" border="0">
                                  <tbody>
                                    <tr>
                                      <td><img height="11" src="../wyzeup_images/admin_arrow.jpg" width="11" /></td>
                                      <td class="paragraph"><a href="question_view.php">Manage Questions </a></td>
                                    </tr>
                                  </tbody>
                                </table></td>
                              </tr>
                            </tbody>
                        </table></td>
                      </tr>
                    </tbody>
                  </table></td>
                  <td class="h5"><table cellspacing="0" cellpadding="0" width="90%" 
                                align="center" border="0">
                    <tbody>
                      <tr>
                        <td align="middle"><a href="changepassword_view.php"><img height="88" alt="Administrator Details" src="../wyzeup_images/wom_amend_admin_details.jpg" width="281" border="0" /></a></td>
                      </tr>
                      <tr>
                        <td align="middle">&nbsp;</td>
                        </tr>
                      <tr>
                        <td align="middle"><a href="logout.php">
						<img height="112" alt="Logout" src="../wyzeup_images/wom_logout.jpg" width="173" border="0" /></a></td>
                      </tr>
                    </tbody>
                  </table>
                  </td>
                </tr>
              </tbody>
          </table></td>
      </tr>
      <tr>
        <td height="20" class="background_footer">&nbsp;</td>
      </tr>
      <tr>
        <td height="20" bgcolor="#E2E2E4"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td valign="middle" class="footer">&nbsp;</td>
              <td width="50%" align="right" valign="middle" class="footer">&copy; Copyright 2006 Wyze Up Ltd. All rights reserved</td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
