<?php require_once('../includes/session.php') ?>
<?php  if(!$session->is_logged_in()){redirect_to('login.php');} ?>
<?php require_once('../includes/constants.php') ?>
<?php require_once('../includes/functions.php'); ?>
<?php require_once('../includes/category.php'); ?>
<?php require_once('../includes/database.php'); ?>
<?php
$errors = array();
if(isset($_POST['submit'])){
	    $newCategory = new Category;
		if(isset($_POST['category']) && !empty($_POST['category'])){
		
		$newCategory->category = ucfirst($_POST['category']);
		$newCategory->categoryNameCount() > 0 ?  $errors[] = 'Category Name Already Exist' : NULL;
		empty($errors) ? $newCategory->save() : NULL;
		empty($errors) ? redirect_to('manageCategory.php') : NULL;
		}else $errors[] = 'Category Name is Required';
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
              <form role="form" method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']) ?>">
              
              <div class="form-group">
              	<label for="category">Category Name</label>
                <input type="text" class="form-control" name="category" placeholder="Category Name" id="category" required>
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
