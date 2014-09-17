<?php require_once('../includes/session.php') ?>
<?php  if(!$session->is_logged_in()){redirect_to('login.php');} ?>
<?php require_once('../includes/constants.php') ?>
<?php require_once('../includes/functions.php'); ?>
<?php require_once('../includes/picupload.php'); ?>
<?php require_once('../includes/product.php'); ?>
<?php require_once('../includes/category.php'); ?>
<?php require_once('../includes/database.php'); ?>
<?php require_once('../includes/pictures.php'); ?>

<?php  $categorySet = Category::find_all(); 
       $categoryOptions = "";
       for($i=0; $i < count($categorySet); $i++){
		   $categoryOptions .= '<option value="'.$categorySet[$i]->category_id.'">'.$categorySet[$i]->category.'</option>';
		   }
	         
?>
<?php
$errors = array();
if(isset($_POST['submit'])){
	$pic = new PicUpload($_FILES['pic']);
	if($pic->validateFileSize()){
		if($pic->validateFileType()){
			 $pic->moveFile();
			;}
			else{$errors[] = 'Invalid File Format';}
		}else{
			$errors[] = 'File Too large';
			}
	$product = new Product;
	$product->productName = $_POST['productName'];
	$product->price       = $_POST['price'];
	$product->details     = $_POST['details'];
	$product->category_category_id = $_POST['category'];
	$product->dateAdded = format_time();
	$product->productNameCount()> 0 ?  $errors[] = 'Product Name Already Exist' : NULL;
	 empty($errors) ? $product->save() : NULL;
	$picture->product_id = $product->product_id;
	$picture->name = $pic->name;
	$picture->save();
	 	}
   
 ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Admin Home</title>
<link href="../css/bootstrap.min.css" rel="stylesheet">
<link href="../css/dashboard.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid">
       <?php require_once('template/nav.php'); ?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Add New Product</h1>
          <?php if(!empty($errors)){echo "<p class='alert-danger'>$errors[0]</p>";} ?>
              <form role="form" method="post" enctype="multipart/form-data" action="<?php echo htmlentities($_SERVER['PHP_SELF']) ?>">
              <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MM ?>">
              <div class="form-group">
              	<label for="productName">Product Name</label>
                <input type="text" class="form-control" name="productName" placeholder="Product Name" id="productName" required>
              </div>
              <div class="form-group">
              	<label for="price">Price</label>
                <input type="text" class="form-control" name="price" placeholder="Price" id="price" required>
              </div>
              <div class="form-group">
                <label for="details">details</label>  
              	<textarea class="form-control" name="details" id="details" required></textarea>
              </div>
              <div class="form-group">
              	<label for="pic">Upload Picture</label>
                <input type="file" name="pic" id='pic' required>
               </div>
               <div class="form-group">
               <label for="category" id="category">Category</label>
              	<select name="category" class="form-control">
                <option value="">---- Select Category --</option>
                 <?php echo  $categoryOptions; ?>
                </select>
               </div>
              <button type="submit" class="btn-primary" name="submit">Submit</button>
              </form>
          </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="../javascript/bootstrap.min.js"></script>
    <script src="../../assets/js/docs.min.js"></script>
  </body>
</html>
