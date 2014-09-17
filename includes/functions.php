<?php
	function redirect_to($url=""){
			if(!empty($url)){
				header("location:".$url);
				exit;
				}
		}
	function output($message=""){
		if(!empty($message)){
			return "<p class='message'>{$message}</p>";
			}else{
				return "";
				}
		}
	function login_validate($username="",$password=""){
			$error        = array();
			$username     = trim($username);
			$password     = trim($password);
			if(empty ($username)){$error[]="Username Not Filled";}
			if(empty($password)){$error[]="Password Not Filled";}
			return !empty($error)? array_shift($error) : true;
		}
	function  signup_validate($sgusername="",$sgfullname="",$sgpwd="",$sgpwd2= "",$sgemail = "",$sgphone = ""){
		$sgusername    = trim($sgusername);
		$sgfullname    = trim($sgfullname);
		$sgpwd         = trim($sgpwd);
		$sgpwd2        = trim($sgpwd2);
		$sgemail       = trim($sgemail);
		$sgphone       = trim($sgphone);
		$errors = array();
		if(empty($sgusername))  {$errors[] = "Please Username Required";}
		if(empty($sgfullname))  {$errors[] = "Please Full Name Required";}
		if(empty($sgpwd))       {$errors[] = "Please Password Required";}
		if(empty($sgpwd2))      {$errors[] = "Please Enter Password Again";}
		if(empty($sgemail))     {$errors[] = "Please Email Required";}
		if(empty($sgphone))     {$errors[] = "Please Phone Number Required ";}
		if($sgpwd !== $sgpwd2)  {$errors[] = "Password Not the same";}
		if(strlen($sgphone) < 11)   {$errors[] = "Invalid phone number";}
		if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$",$sgemail )){  
							    $errors[]  = "Invalid Email";
		}
		return !empty($errors)? array_shift($errors) : false;
		}
		function random(){
		   		$a = md5(rand());
				$b = substr($a,-5); 
				return $b;
		   }
		 function fail($message){
	      die(json_encode(array("status"=>"fail","message"=>$message)));
	     }
        function success($message){
	      die(json_encode(array("status"=>"success","message"=>$message)));
	    }
		
		function send_sms($message,$phone_numb){
		$username = "user=asyugo";
		$password = "&password=asyug0&";
		$sender = "sender=asyugo&";
		$sms = "SMSText=".$message;
		$gsm = "&GSM=".$phone_numb;
		$url = "http://api.infobip.com/api/v3/sendsms/plain?";
		$url .= $username.$password.$sender.$sms.$gsm;
		//$url = urlencode($url);
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT,10);
		curl_setopt($curl, CURLOPT_USERAGENT , "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
		curl_setopt($curl, CURLOPT_URL, $url);
		$return = curl_exec($curl);
		curl_close($curl);
		return $return; 
	 
	} 

function gen_search($search=""){
	$sql = "(SELECT id,description,key_word as name,tab_num FROM search WHERE permission = 0 && key_word like '%$search%' or permission = 0 && description like '%$search%' or permission = 0 && address like '%$search%') UNION (SELECT id,description,name,tab_num FROM service WHERE  name like '%$search%' or description like '%$search%' or address like '%$search%' or searchtag like '%$search%' ORDER BY searchtag,name,address)";
	return $sql;	
}
function keyword(){
	   
	    $a =  mt_rand(1,555555);
		$b =  mt_rand(1,555555);
		$c =  mt_rand(1,555555);
		$d =  mt_rand(1,555555);
		$e =  mt_rand(1,555555);
		$f =  mt_rand(1,555555);
		return substr(md5($a.$b.$c.$d.$e.$f),5,6);
	}
function format_time(){
	return strftime('%Y-%m-%d %H:%M:%S',time());
	}		 

?>