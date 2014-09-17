<?php require_once('../includes/session.php') ?>
<?php require_once('../includes/constants.php') ?>
<?php require_once('../includes/functions.php') ?>
<?php require_once('../includes/database.php') ?>
<?php require_once('../includes/category.php') ?>
<?php require_once('../includes/product.php') ?>
<?php
    // collect distinct category_category_id into an array from the products table 
	$categorySet = $database->query('SELECT  DISTINCT category_category_id FROM products');
	$distinctCategory = array();
	while($row =  $database->fetch_array($categorySet)){
		array_push($distinctCategory,$row['category_category_id']);
		}
	$database->free_result($categorySet);
	$products = array();
	foreach($distinctCategory as  $cat){
		$products[] = Product::find_by_category_category_id($cat);
		}
	die(json_encode($products));
	
?>