<?php require_once('../includes/session.php') ?>
<?php  if(!$session->is_logged_in()){redirect_to('login.php');} ?>
<?php require_once('../includes/constants.php') ?>
<?php require_once('../includes/functions.php'); ?>
<?php require_once('../includes/product.php'); ?>
<?php require_once('../includes/category.php'); ?>
<?php require_once('../includes/database.php'); ?>
<?php require_once('../includes/picUpload.php'); ?>
<?php require_once('../includes/pictures.php'); ?>
<?php

if((isset($_GET['name']) && isset($_GET['id']) && !empty($_GET['name']) && !empty($_GET['id'])) || 
(isset($_POST['name']) && isset($_POST['id']) && !empty($_POST['name']) && !empty($_POST['id']))){
if(isset($_GET['id'])){
	$foundProduct = Product::find_by_id(preg_replace('#[^0-9]#','',$_GET['id']));
	$name = $_GET['name'];
	}
if(isset($_POST['id'])){
	$foundProduct = Product::find_by_id(preg_replace('#[^0-9]#','',$_POST['id']));
	$name = $_POST['name'];
	}

if($foundProduct && $foundProduct->productName == $name){ 
     
	  $categorySet = Category::find_all(); 
       $categoryOptions = "";
	   $productCategory = "";
       for($i=0; $i < count($categorySet); $i++){
		   $categoryOptions .= '<option value="'.$categorySet[$i]->category_id.'">'.$categorySet[$i]->category.'</option>';
		   }   
	   for($i=0; $i < count($categorySet); $i++){
		    if($categorySet[$i]->caregory_id == $foundProduct->category_category_id){
				 $productCategory .= '<option value="'.$categorySet[$i]->category_id.'">'.$categorySet[$i]->category.'</option>';
				 break;
				}
		   }
if(isset($_POST['submit'])){
	     $errors = array();
	     $requiredFields = array('productName','price','details','category');
		 foreach($requiredFields as $field){
			 if(empty($field)){
				 $errors[] = 'Fill all Required Fields';
				 }
			 }
		 if(empty($errors)){
			$foundProduct->productName = $_POST['productName'];
			$foundProduct->details     = $_POST['details'];
			$foundProduct->price       = $_POST['price'];
			$foundProduct->category_category_id = $_POST['category'];
			$foundProduct->dateAdded = format_time();
			
			if(isset($_FILES['pic']) && !empty($_FILES['pic']['tmp_name'])){
				$pic = new PicUpload($_FILES['pic']);
	            if($pic->validateFileSize()){
		        if($pic->validateFileType()){
			       $pic->moveFile();
				   $picture->product_id = $foundProduct->product_id;
	               $picture->name = $pic->name;
	               $picture->save()
			     ;}
			   else{$errors[] = 'Invalid File Format';}
		     }else{
			$errors[] = 'File Too large';
			}
				}
			if(empty($errors)){
				 if($foundProduct->save()){
				 $session->message($foundProduct->ProductName." Successfully Updated");
				 redirect_to('manageProduct.php');
				 ;}
			   }
			 }
	    /*$newCategory = new Category;
		if(isset($_POST['category']) && !empty($_POST['category'])){
		
		$newCategory->category = ucfirst($_POST['category']);
		$newCategory->categoryNameCount() > 0 ?  $errors[] = 'Category Name Already Exist' : NULL;
		empty($errors) ? $newCategory->save() : NULL;
		empty($errors) ? redirect_to('manageCategory.php') : NULL;
		}else $errors[] = 'Category Name is Required';*/
	 	}
}else{
	$session->message('category not found');
	redirect_to('manageCategory.php');
	}
}
else{
	$session->message('category not found');
	redirect_to('manageCategory.php');
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
          <h1 class="page-header">Add Category</h1>
          <?php if(!empty($errors)){echo "<p class='alert-danger'>$errors[0]</p>";} ?>
              <form role="form" method="POST" enctype="multipart/form-data" action="<?php echo htmlentities($_SERVER['PHP_SELF']) ?>">
              <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MM ?>">
               <input type="hidden" name="name" value="<?php  echo $foundProduct->productName ?>">
                <input type="hidden" name="id" value="<?php  echo $foundProduct->product_id ?>" >
              <div class="form-group">
              	<label for="productName">Product Name</label>
                <input type="text" class="form-control" name="productName" placeholder="Product Name" value="<?php echo $foundProduct->productName ?>" id="productName" required>
              </div>
              <div class="form-group">
              	<label for="price">Price</label>
                <input type="text" class="form-control" name="price" placeholder="Price" id="price" value="<?php echo $foundProduct->price ?>" required>
              </div>
              <div class="form-group">
                <label for="details">details</label>  
              	<textarea class="form-control" name="details" id="details" required><?php echo $foundProduct->details ?></textarea>
              </div>
              <div class="form-group">
              	<label for="pic">Add Picture</label>
                <input type="file" name="pic" id='pic'>
               </div>
               <div class="form-group">
               <label for="category" id="category">Category</label>
              	<select name="category" class="form-control">
               <?php echo $productCategory; ?>
               <?php echo  $categoryOptions; ?>
                </select>
               </div>
              <button type="submit" class="btn-primary" name="submit">Update Product</button>
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
