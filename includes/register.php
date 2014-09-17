<?php
    require_once('session.php');
    require_once('functions.php');
	require_once('config.php');
	require_once('database.php');
	require_once('user.php');
	require_once("PHPMailer/class.phpmailer.php");
    require_once("PHPMailer/class.smtp.php");
    class Register {
		public $id = 0;
		public $username = "";
		public $email = "";
		public $phone_number ="";
		public $fullname = "";
		public $pwd = "";
		public $date ="";
		public $time = "";
		public $activated = "";
		public $code = "";
		public $errors = array();
		public function verify_username($name =""){
			global $database;
			 $name = preg_replace('#[^a-z0-9]#i','',$name);
			 $sql           = "SELECT username FROM users WHERE username ='".$name ."'";
	         $result         = $database->query($sql);
			 if($database->num_rows($result) == 0){ return true;}else{$this->errors[] = 'Username not Available'; return false;}
			 $database->free_result($result);
			 $database->close_connection();
		}
	   
	    
	   public function register_user($username,$email,$email2,$phone_number,$phone_number2,$fullname,$pwd,$pwd2){
			global $database;
			$input_fields = array($username,$email,$email2,$phone_number,$phone_number2,$fullname,$pwd,$pwd2);
			$reg_fields = array($this->username = $username,$this->email = $email,$this->phone_number = $phone_number,$this->fullname = $fullname,$this->pwd = $pwd);
			foreach($reg_fields   as $key => $data){
				$key = trim($data);
				}
			$this->username			 = strtolower(preg_replace('#[^a-z0-9]#i','',$username));
		    $this->fullname 		 = $database->escape_value($this->fullname);
			$this->email 			 = $database->escape_value($this->email);
			$this->phone_number 	 = $database->escape_value($this->phone_number);
			foreach($input_fields as $input){
				if(empty($input)){$this->errors[] = 'Fill all required fields';}
				}
				
			if(empty($this->errors)){
					if(strlen($this->username )< 4){$this->errors[] = 'Username Should not Be less than 4 characters ';}
					elseif(is_numeric($this->username[0])){$this->errors = 'Username Should Not start with a Numeral';}
					elseif(strlen($this->fullname) < 4){$this->errors[] = 'Fullname Should Not Be less than 4 characters '.strlen($this->fullname);}
					elseif($pwd != $pwd2){$this->errors[] = 'Password does not Match';}
					elseif($phone_number != $phone_number2){$this->errors[] = 'Phone Numbers does not match';}
					elseif($email != $email2){$this->errors[] = 'Email does not match';}
					elseif(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$",$email)){
						$this->errors[] = 'Invalid Email';}
                   elseif(strlen($phone_number)< 14 || $phone_number[0] != '+'){$this->errors[] = "Invalid Phone Number ";}
				   elseif($pwd != $pwd2){$this->errors[] = 'Password does not Match';}
				   else{$sql1 = "SELECT * FROM users WHERE username='".$this->username."'";
						$sql2 = "SELECT * FROM users WHERE email='".$this->email."'";
						$sql3 = "SELECT * FROM users WHERE phone_number='".$this->phone_number."'";
						$result1 = $database->query($sql1);
						if($database->num_rows($result1) != 0){$this->errors[] = 'Username Taken';mysqli_free_result($result1);}
						$result2 = $database->query($sql2);
						if($database->num_rows($result2) != 0){$this->errors[] = 'Email is already registered';mysqli_free_result(
																$result2);}
						$result3 = $database->query($sql3);
						if($database->num_rows($result3) != 0){$this->errors[] = 'Phone Number is already registered';
																mysqli_free_result($result3);}
		                
						}  
		     }
			 			 
			if(empty($this->errors)){
				$this->pwd = md5($this->pwd);
				$b= random();		
		        $sql4 = "INSERT INTO users(username,email,phone_number,full_name,pwd,date,time,code) 
				          VALUES('".$this->username."','".$this->email."','".$this->phone_number."','".$this->fullname."','".$this->pwd."',CURDATE(),CURTIME(),'$b')";
				$result4 = $database->query($sql4);
				if($database->affected_rows() == 1){
						$to = $this->email;
						 $to_name = $this->username;
						 $hash = md5($this->email);
						 $subject = "Signup | Verification" . strftime("%T", time());
						 $message = '<!doctype html><html><head><meta charset="utf-8"><title>Thank you for Signing up</title></head><body><h1 style="text-align:center; color:#0033CC;">Asyougo</h1><div style="text-align:center"><p>Your account has been created on asyougo.com<br /> Username:'.$this->username.'<br/> Password:'.$pwd.'</p><p><a href="http://www.asyugo.com/verify.php?email='.$email.'&hash='.$hash.'">CLICK THIS LINK TO ACTIVATE YOUR ACCOUNT</a></p></div></body></html>';
						 $message = wordwrap($message,70);
						 $from_name = "asyugo.com";
						 $from = "service@asyugo.com";  
						$mail           = new PHPMailer();
						$mail->isSMTP();
						$mail->Host     =  "mail.asyugo.com";
						$mail->Port     =  25;
						$mail->SMTPAuth = true;
						$mail->isHTML(true);
						$mail->Username  = "service@asyugo.com";
						$mail->Password   = "Watershedglobal2013";

						$mail->FromName = $from_name;
						$mail->From     = $from;
						$mail->AddAddress($to,$to_name);
						$mail->Subject  = $subject;
						$mail->Body     = $message;
						$result         = $mail->Send();
						if($result){send_sms($b,$phone);
						success("Registeration Successful. Check your Mail to activate Your Account");
						}
						else{
							$this->errors[] = "Error Sending Email. Please Contact our Admin";
						}
					}
				}
				return empty($this->errors) ? true : false;  
 		}
		}
	$register = new Register;
?>