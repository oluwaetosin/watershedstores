<?php require_once('../includes/session.php') ?>
<?php  if(!$session->is_logged_in()){redirect_to('login.php');} ?>
<?php require_once('../includes/constants.php') ?>
<?php require_once('../includes/functions.php'); ?>
<?php  require_once('../includes/product.php'); ?>
<?php  require_once('../includes/pictures.php'); ?>
<?php
if(isset($_GET['id']) && isset($_GET['name'])){
	$product = Product::find_by_id(preg_replace('#[^0-9]#','',$_GET['id']));
	if($product){
		if($product->productName == $_GET['name']){
			$product->delete() ? $session->message($product->productName.
			 " Succesfully Deleted") : $session->message('Unable to Delete '.$product->productName);
			 $picture->product_id = $product->product_id;
			 $picture->delete_by_product_id($id);
			redirect_to('manageProduct.php');
			}
	 else{
			$session->message('Product Not Found');
			redirect_to('manageProduct.php');
		 }
		}
	}
else{
	redirect_to(SITE_ROOT.admin.DS.'index.php');
	}
?>