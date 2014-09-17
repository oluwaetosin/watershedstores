<?php require_once('includes/session.php'); ?>
<?php require_once('includes/functions.php'); ?>
<?php require_once('includes/constants.php');?>
<?php require_once('includes/database.php'); ?>
<?php require_once('includes/category.php'); ?>
<?php require_once('includes/product.php'); ?>
<?php require_once('includes/pictures.php'); ?>
<?php require_once('includes/cart.php'); ?>
<?php
 if(isset($_POST['update-quantity']) && !empty($_POST['quantity']) && $_POST['quantity'] > 0){
	 $session->cart_id = $_POST['adjust'];
	 $session->adjust_cart($_POST['quantity']);
	 redirect_to(htmlentities($_SERVER['PHP_SELF']));
	 }
?>
<?php  if(isset($_GET['emptycart']) && $_GET['emptycart'] == 'true'){
	
	   $session->empty_cart();
	   redirect_to(htmlentities($_SERVER['PHP_SELF']));
	}?>
<?php  if(isset($_GET['remove']) && !empty($_GET['remove'])){
	     $session->cart_id = $_GET['remove'];
		 $session->unset_by_productId();
	   redirect_to(htmlentities($_SERVER['PHP_SELF']));
	}?>
<?php 
 if(isset($_GET['name']) && isset($_GET['id']) && !empty($_GET['name']) && !empty($_GET['id'])){
	 $id = $database->escape_value($_GET['id']);
	  $item = Product::find_by_id($id);
	  if(!$item){redirect_to('index.php');}
	  if($item->productName != $_GET['name']){
		  redirect_to('index.php');
		  }
	  $picture_set = Pictures::find_by_sql('SELECT * FROM pictures WHERE product_id = '.$item->product_id);
	  $mainPic = array_pop($picture_set);
	  if(empty($session->cart)){
		  $_SESSION['cart_array'] = array(array('productName'=>$item->productName,'productId'=>$item->product_id,'quantity' => 1));
		  $session->check_cart();
		  }
		else {
			$session->cart_id = $item->product_id;
			$session->cartProductName = $item->productName;
			$session->build_cart();
			}
		redirect_to('cart.php');
     }
		
		  if(!empty($session->cart)){
/*			  die(json_encode($session->cart));
*/			 $cart_string = "";
			 foreach($session->cart as $cart){
					 $foundProduct = Product::find_product_by_id($cart['productId']);
					 $cart_string = $cart_string.'<tr><td scope="col" width="19%" valign="middle"><a href="viewProduct.php?name='.$foundProduct->productName.
						'&id='.$foundProduct->product_id.'"><img src="images/boutique/'.$foundProduct->pictureName.'" width="50"></a><td td scope="col" width="19%" valign="middle">'.$foundProduct->productName.'</td></td><td td scope="col" width="19%" valign="middle">#'.$foundProduct->price.'</td><td scope="col"  valign="middle" width="19%"><form method="post" action="'.$_SERVER['PHP_SELF'].'" id="update-quantity"><input  type="text" name="quantity" value="'.$cart['quantity'].'"><input type="hidden" name="adjust" value="'.$foundProduct->product_id.'"><button type="submit" name="update-quantity"><img src="images/update.png" alt="update"></button></form></td><td scope="col"  valign="middle" >#'.
					$foundProduct->productPrice($cart['quantity']).
					 '</td><td scope="col"  valign="middle" width="19%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.htmlentities($_SERVER['PHP_SELF']).'?remove='.$cart['productId'].'"><img src="images/delete.png" alt="remove"></a></td></tr>';
				$session->cart_total_price += $foundProduct->productPrice($cart['quantity']);	
				 }
		 }
		 if(empty($session->cart)){$cart_string = '<h2>Cart Empty<h2>';}
?>
<?php  $categorySet = Category::find_all(); 
       $categoryOptions = "";
       for($i=0; $i < count($categorySet); $i++){
		   $categoryOptions .= '<li><a href="categoryPage.php?category='.$categorySet[$i]->category.'">'.$categorySet[$i]->category.'</a></li>';
		   }	         
?>
<?php
$css = 'css/cart.css';
$title = 'Welcome to Watershed Stores | My Cart' ;
?>
<?php require_once 'template/header.php'; ?>
   <div id='cart'>
   
   </div>
 </div>
</section>
<?php require_once 'template/footer.php'; ?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
<script src="javascript/cart.js"></script>
</body>
</html>