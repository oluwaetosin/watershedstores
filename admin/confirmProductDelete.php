<?php require_once('../includes/session.php'); ?>
<?php require_once('../includes/functions.php'); ?>
<?php   require_once('../includes/constants.php'); ?>
<?php  if(!$session->is_logged_in()){redirect_to('login.php');} ?>
<?php
if(isset($_GET['id']) && isset($_GET['name'])){
	
	}
else{
	redirect_to(SITE_ROOT.admin.DS.'index.php');
	}
?>