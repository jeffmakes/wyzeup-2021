<?php
session_start();
require_once('../conf/conf.inc.php');
 session_unregister_user();
 header('Location:index.php?status=logout');
?>