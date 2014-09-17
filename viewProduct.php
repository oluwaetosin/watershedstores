<?php require_once('includes/functions.php'); ?>
<?php require_once('includes/constants.php');?>
<?php require_once('includes/database.php'); ?>
<?php require_once('includes/category.php'); ?>
<?php require_once('includes/product.php'); ?>
<?php require_once('includes/pictures.php'); ?>
<?php $css = 'css/viewProduct.css'; 
 ?>
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
	 }
else{
	redirect_to('index.php');
	}
?>
<?php  $categorySet = Category::find_all(); 
       $categoryOptions = "";
       for($i=0; $i < count($categorySet); $i++){
		   $categoryOptions .= '<li><a href="categoryPage.php?category='.$categorySet[$i]->category.'">'.$categorySet[$i]->category.'</a></li>';
		   }	         
  $title = 'Watershed Stores | '.$item->productName ;
?>
<?php require_once 'template/header.php'; ?>
  <div class="image-holder">
    <div class="image">
    <img src="images/boutique/<?php echo $mainPic->name ?>" />
    <div id='add-to-cart'><a href="cart.php?name=<?php echo $item->productName ?>&id=<?php echo $item->product_id ?>">Add to Cart</a>
    </div>
    </div>
    <div class='details'>
    	<div >
        <?php echo '<h1>'.$item->productName.'</h1>'; ?>
        </div>
        <p>
        <?php echo $item->details ?>
        </p>
        <p class="price">
        <?php echo $item->price ?>
        </p>
    </div>
 </div>
 </div>
</section>
<?php require_once 'template/footer.php'; ?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
<script src="javascript/viewProduct.js"></script>
</body>
</html>