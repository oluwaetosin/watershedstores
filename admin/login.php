<?php 
require_once('../includes/session.php');
require_once('../includes/functions.php');
require_once('../includes/admin.php');
if($session->is_logged_in()){
	redirect_to('index.php');
	}
if(isset($_POST['submit'])){
	if(Admin::authenticate($_POST['username'],$_POST['password'])){
		$user = Admin::authenticate($_POST['username'],$_POST['password']);
		$session->login($user);
		redirect_to('index.php');
		}else{
			$error = 'Wrong Username/Pasword Combination';
			}
	}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Watershed Stores</title>
<link href="../css/bootstrap.min.css" rel="stylesheet">
<link href="../css/adminLogin.css" rel="stylesheet">
</head>
<body>
<div class="container">

      <form class="form-signin" role="form" method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF'])?>">
        <h2 class="form-signin-heading">Please sign in</h2>
        <?php echo isset($error) ?  "<p class='alert-danger error'>".$error."</p>" : ""; ?>
        <input type="text" class="form-control" name="username" placeholder="Username" required autofocus>
        <input type="password" class="form-control" name="password" placeholder="Password" required>
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Sign in</button>
      </form>

    </div> <!-- /container -->

</body>
<script src="../javascript/bootstrap.min.js"></script>
</html>