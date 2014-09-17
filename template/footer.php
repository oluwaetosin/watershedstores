<footer>
<?php
    $categorySet = Category::find_all(); 
	$footerNav = '';
   for($i=0; $i < count($categorySet); $i++){
		   $footerNav .= '<li><a href="categoryPage.php?category='.$categorySet[$i]->category.'">'.$categorySet[$i]->category.'</a></li>';
		   }	 	

?>
<div class="wrapper">
<div class="left">
<ul>
 <?php 
 echo $footerNav;
 ?>
 </ul>
 </div>
 <div class="mid">
 &nbsp;
 </div>
 <div class="right">
 <ul>
 <li><a href="cart.php">My Cart</a></li>
  <li><a href='#'>Contact Us</a></li>
 </ul>
 </div>
</div>
<div class="clear">
</div>
</footer>