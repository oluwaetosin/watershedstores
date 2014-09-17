<?php require_once('includes/functions.php'); ?>
<?php require_once('includes/constants.php');?>
<?php require_once('includes/category.php'); ?>

<?php  $categorySet = Category::find_all(); 
       $categoryOptions = "";
       for($i=0; $i < count($categorySet); $i++){
		   $categoryOptions .= '<li><a href="categoryPage.php?category='.urlencode($categorySet[$i]->category).'">'.$categorySet[$i]->category.'</a></li>';
		   }
	         
?>
<?php 
$title = 'Watershed Stores |'.$_GET['category'];
$css = 'css/categoryPage.css'; ?>
<?php require_once 'template/header.php'; ?>
  <div class="slide" id="slide">
     <img src="images/CansofFishPackagingwithShrinkMachine.png" width="600" height="300">
     <img src="images/belt.png" height="300" width="300">
  </div>
 </div>
 <div class="image-holder">
 
 </div>
</section>
<?php require_once 'template/footer.php'; ?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
<script type="text/javascript" src="http://malsup.github.com/chili-1.7.pack.js"></script>
<script type="text/javascript" src="http://malsup.github.com/jquery.cycle.all.js"></script>
<script type="text/javascript" src="http://malsup.github.com/jquery.easing.1.3.js"></script>
<script src="javascript/categoryPage.js"></script>
</body>
</html>