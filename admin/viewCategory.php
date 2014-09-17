<?php require_once('../includes/session.php') ?>
<?php  if(!$session->is_logged_in()){redirect_to('login.php');} ?>
<?php require_once('../includes/constants.php') ?>
<?php require_once('../includes/functions.php'); ?>
<?php require_once('../includes/category.php'); ?>
<?php require_once('../includes/database.php'); ?>
<?php

if(isset($_GET['name']) && isset($_GET['id']) && !empty($_GET['name']) && !empty($_GET['id'])){
$foundCategory = Category::find_by_id(preg_replace('#[^0-9]#','',$_GET['id']));
if($foundCategory && $foundCategory->category == $_GET['name']){    
if(isset($_GET['submit'])){
	     $errors = array();
	     if(empty($_GET['category'])){
			 $errors[] = 'Fill All Fields';
			 }
		 if(empty($errors)){
			 $foundCategory->category = $_GET['category'];
			 if($foundCategory->save()){
				 $session->message($foundCategory->category." Successfully Updated");
				 redirect_to('manageCategory.php');
				 ;}
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
          <h1 class="page-header">Manage Store</h1>
          <?php if(!empty($errors)){echo "<p class='alert-danger'>$errors[0]</p>";} ?>
              <form role="form" method="get" action="<?php echo htmlentities($_SERVER['PHP_SELF']) ?>">
              
              <div class="form-group">
              	<label for="category">Category Name</label>
                <input type="text" class="form-control" name="category" 
                placeholder="Category Name" value="<?php echo $foundCategory->category ?>" id="category" required>
                
                <input type="hidden" name="name" value="<?php  echo $foundCategory->category ?>">
                <input type="hidden" name="id" value="<?php  echo $foundCategory->category_id ?>" >
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
