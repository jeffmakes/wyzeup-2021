<?php 
/**
* Header inclusion for generation XML file 
*/	
/*header("Pragma: no-cache");
header("Expires: " . gmdate("D, d M Y H:i:s", time() + (-1*60)) . " GMT");
header("Content-type: text/xml"); */
 
session_start();
require_once('conf/conf.inc.php');
//fetching values
$sql = "SELECT * FROM wyzeup_demo WHERE id = ".$_GET["id"];
$res = mysql_query($sql);
if(mysql_num_rows($res)){
	$result = mysql_fetch_array($res);
 	//echo "<?xml version='1.0'<title>".htmlentities($result["title"])."</title><nextcontid>".$nextid."</nextcontid><content>".htmlentities($result["content"])."</content><image>".$result["image"]."</image><loaderimage>".$result["loaderimage"]."</loaderimage>";
	echo $result["title"]."@##@".$result["content"]."@##@".$result["image"]."@##@".$result["loaderimage"]."@##@".$result["id"];
}
?>