<?php require_once('../includes/session.php') ?>
<?php require_once('../includes/constants.php') ?>
<?php require_once('../includes/functions.php'); ?>
<?php  require_once('../includes/category.php'); ?>
<?php  if(!$session->is_logged_in()){redirect_to('login.php');} ?>
<?php
$categories =  Category::find_all();
 $list= "";
foreach($categories as $cat){
	$list  .= "<tr><td>".$cat->category.
			 "</td><td><a href='deleteCategory.php?id=".$cat->category_id."&name=".$cat->category."'>Delete Category</a></td>".
			 "<td><a href='viewCategory.php?id=".$cat->category_id."&name=".$cat->category."'>View Category</a></td></tr>";
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
          <h1 class="page-header">Manage Store Categories</h1>
           <?php echo $session->message; ?>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Category</th>
                  <th>Delete</th>
                  <th>View</th>
                </tr>
              </thead>
              <tbody>
              <?php echo $list; ?>
              </tbody>
            </table>
            
          </div>

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
