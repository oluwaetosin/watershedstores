<?php
    require_once('functions.php');
	require_once('config.php');
	require_once('database.php');
	require_once('session.php');
	class Login{
		    public  static $id;
			public  static $username;
			public  static $password;
			private $logged_in = false;
			public  static $errors = array();
			
			public  static function login_user($username = "" , $password = ""){
				    global $database;
				    self::$username = strtolower(trim($username));
	                self::$password = ($password);
					if(empty(self::$username)){self::$errors[] = 'Username Required';}
					if(empty(self::$password)){self::$errors[] = 'Password Required';}
					if(empty(self::$errors)){
						self::$username = preg_replace('#[^a-z0-9]#i','',self::$username);
						self::$password = md5(self::$password);
						$sql1	  = "SELECT * FROM users WHERE username='".self::$username."'";
						$sql2 	  = "SELECT * FROM users WHERE username='".self::$username."' && pwd='".self::$password."' LIMIT 1";
						$result1  =  $database->query($sql1);
						$database->num_rows($result1) != 1 ? self::$errors[] = self::$username .' Not Yet Registered' : '';
						if($database->num_rows($result1) == 1){
							$database->free_result($result1);
							$result2 = $database->query($sql2);
							if($database->num_rows($result2) != 1){self::$errors[] = 'Wrong Password/ Username Combination';}else{
								$user_record = $database->fecth_array($result2);
								$database->free_result($result2);
								if($user_record['activated'] != 2){self::$errors[] = 'Account Not Yet Activated';}
								}
							}	
						}
					if(empty(self::$errors)){
						self::$id = $user_record['id'];
						$_SESSION['user_id'] = self::$id;
						}
					return !empty(self::$errors) ? false : true;
				}
		}


?>