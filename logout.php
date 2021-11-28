<?php
 session_start();
 require_once('conf/conf.inc.php');
 session_unregister_school();
 header('Location:login.php?status=logout');
?>