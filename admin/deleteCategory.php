<?php require_once('../includes/session.php') ?>
<?php  if(!$session->is_logged_in()){redirect_to('login.php');} ?>
<?php require_once('../includes/functions.php'); ?>
<?php  require_once('../includes/category.php'); ?>
<?php
if(isset($_GET['id']) && isset($_GET['name'])){
	$categories = Category::find_by_id(preg_replace('#[^0-9]#','',$_GET['id']));
	if($categories){
		if($categories->category == $_GET['name']){
			$categories->delete() ? $session->message($categories->category.
			 " Succesfully Deleted") : $session->message('Unable to Delete '.$categories->category);
			redirect_to('manageCategory.php');
			}
	 else{
			$session->message('Category Not Found');
			redirect_to('manageCategory.php');
		 }
		}
	}
else{
	redirect_to(SITE_ROOT.admin.DS.'index.php');
	}
?>