<?php
session_start();
require_once('../conf/conf.inc.php');

#User Existence validation
$url = URL_ADMIN_LOGIN_REQUIRED;
if(!check_admin_exist()){	  
  html_refresh($url);
}	
if (!isset ($_SESSION)) session_start();
/*****************************************************************
 Page        : product_xmlquery.php
 Description : Process xmlhttprequest and format result appropriately for LiveGrid  
 Date        : 4 June 2006
 Authors     : Matt Brown (dowdybrown@yahoo.com)
 Copyright (C) 2006 Matt Brown

northwindxmlquery.php is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public
License as published by the Free Software Foundation; either
version 2.1 of the License, or (at your option) any later version.

northwindxmlquery.php is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
General Public License for more details.

You should have received a copy of the GNU General Public
License along with this library; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
******************************************************************/

header("Cache-Control: no-cache");
header("Pragma: no-cache");
header("Expires: " . gmdate("D, d M Y H:i:s", time() + (-1*60)) . " GMT");
header("Content-type: text/xml");
print '<?xml version="1.0" encoding="iso-8859-1" ?'.">\n"; 

require "dbclass.php";

// For char or varchar fields that allow nulls, then you should query the field this way:
//     ifnull(myNullableTextField,'')
// This allows filtering to work correctly on blank LiveGrid cells.

$id=$_GET["id"];
$offset=intval($_GET["offset"]);
if (empty($offset)) $offset=0;
$rowcnt=intval($_GET["page_size"]);
if (empty($rowcnt)) $rowcnt=1;
if ($rowcnt>200) $rowcnt=200;
set_error_handler("myErrorHandler");

print "\n<ajax-response><response type='object' id='".$id."_updater'>";
$oDB=new dbClass();
$oDB->DisplayErrors=false;
$oDB->ErrMsgFmt="MULTILINE";

//$_SESSION[$id]="select * from nworders";
//print session_id();
//print implode("<p>",$_SESSION);
if ($id=="") {
  print "\n<rows update_ui='false' /><error>";
  print "\nNo ID provided!";
  print "\n</error>";
} else if (!isset ($_SESSION[$id])) {
  print "\n<rows update_ui='false' /><error>";
  print "\nYour connection with the server was idle for too long and timed out. Please refresh this page and try again.";
  print "\n</error>";
} else if ($oDB->MySqlLogon(DB_NAME,DB_USERNAME,DB_PASSWORD)) {  // NEED TO SET USERID AND PASSWORD HERE
  Query2xml($oDB,$_SESSION[$id],$id,$offset,$rowcnt);
  if ($oDB->LastErrorMsg) {
    print "\n<error>";
    print "\n" . htmlspecialchars($oDB->LastErrorMsg);
    print "\n</error>";
  }
  $oDB->dbClose();
}
print "\n</response></ajax-response>";

// error handler function
function myErrorHandler($errno, $errstr, $errfile, $errline)
{
  print "\n<error>";
  print "\n".htmlspecialchars($errstr);
  print "\n</error>";
}

function Query2xml (&$oDB,$sqltext,$id,$offset,$numrows)
{

  $oDB->ParseSqlSelect($sqltext,$arSelList,$FromClause,$WhereClause,$arGroupBy,$HavingClause,$arOrderBy);
  foreach($_GET as $variable => $value) {
    switch (substr($variable,0,1)) {
      case "s":
        $i=substr($variable,1);
        //$newsort=$arSelList[$i] . " " . $value;
        $newsort=($i+1) . " " . $value;
        $oDB->SetParseField($arOrderBy, $newsort);
        break;
      case "f":
        $i=substr($variable,1);
        $newfilter=$arSelList[$i] . " " . stripslashes($value);
        $oDB->AddCondition($WhereClause, $newfilter);
        break;
    }
  }
  $sqltext=$oDB->UnparseSqlSelect($arSelList,$FromClause,$WhereClause,$arGroupBy,$HavingClause,$arOrderBy);

  //print "<sql>".htmlspecialchars($sqltext)."</sql>";
  $rsMain=$oDB->RunQuery($sqltext);
  if (!$rsMain) return false;

  print "\n<rows update_ui='true' offset='".$offset."'>";

  $colcnt = mysql_num_fields($rsMain);
  $totcnt = mysql_num_rows($rsMain);
  //print "totcnt=".$totcnt." colcnt=".$colcnt." offset=".$offset." numrows=".$numrows;
  if ($offset < $totcnt)
  {
    $rowcnt=0;
    mysql_data_seek($rsMain,$offset);
    while(($row = mysql_fetch_row($rsMain)) && $rowcnt < $numrows)
    {
      $rowcnt++;
      print "\n<tr>";
      for ($i=0; $i < $colcnt; $i++)
      {
        if (mysql_field_type($rsMain,$i)=="Date")
        {
          print XmlStringCell(strftime("%m/%d/%Y",$row[$i]));
        } else {
          print XmlStringCell($row[$i]);
        } 
      }
      print "</tr>";
    } 
  }
  else
  {
    $rowcnt=$offset;
  }

  print "\n"."</rows>";
  print "\n"."<rowcount>".$totcnt."</rowcount>";
  $oDB->rsClose($rsMain);
  return $rowcnt;
} 

function XmlStringCell($value)
{
  //$result=(isset($value)) ? str_replace("<","&lt;",str_replace("&","&amp;",$value)) : "";
  $result=(isset($value)) ? htmlspecialchars($value) : "";
  //$result=(isset($value)) ? $value : "";
  return "<td>".stripslashes($result)."</td>";
} 
?>
