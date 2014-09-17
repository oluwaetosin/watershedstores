<?php require_once('admin.php'); ?>
<?php
class Session{
	public $id;
	public $cart_id;
	public $cart_total_price = 0;
	public $cartProductName;
	public $password;
	private $logged_in = false;
	private $found_cart_item = false;
	public $message;
	public $cart = array();
	 function __construct(){
		 session_start();
		 $this->check_login();
		 $this->check_message();
		 $this->check_cart();
		 }
	public function is_logged_in(){
	  return $this->logged_in;
	}
	private function check_login(){
		 global $admin;
		if(isset($_SESSION['user_id']) && isset($_SESSION['pwd'])){
			$this->id = preg_replace('#[^0-9]#','',$_SESSION['user_id']);
			$this->password = $_SESSION['pwd'];
			$sql = 'SELECT * FROM admin WHERE id = '.$this->id;
			$sql .= " AND password = '".$this->password;
			$sql .= "' LIMIT 1";
			$result = Admin::find_by_sql($sql);
			if(!empty($result)){
			$this->logged_in = true;
			}
			}else{
				 $this->logged_in = false;
				 unset($this->id);
			     unset($this->password);	 
				}
		}
	public function check_cart(){
		if(isset($_SESSION['cart_array'])){
			$this->cart = ($_SESSION['cart_array']);
			}
		}
	public function build_cart(){
		if(!empty($this->cart)){
			$this->find_cart_by_product_id();
			$this->add_to_cart();
			}
		}
	public function find_cart_by_product_id(){
		$i=0;
		//check to find if product already exist;
		foreach($this->cart as $cart){
			//if productId of current array == the new cart_id increase the quantity by 1 and set
			if($cart['productId'] == $this->cart_id){
				$this->cart[$i]['quantity'] += 1;
				$this->found_cart_item = true;
				$_SESSION['cart_array'] = $this->cart;
				}
			$i++;
			}
		}
	public function adjust_cart($quantity){
		$quantity = preg_replace('#[^0-9]#','',$quantity);
		$i=0;
		//check to find if product already exist;
		foreach($this->cart as $cart){
			//if productId of current array == the new cart_id increase the quantity by 1 and set
			if($cart['productId'] == $this->cart_id){
				
				$this->cart[$i]['quantity'] =  $quantity; 
				$_SESSION['cart_array'] = $this->cart;
				}
			$i++;
			}
		}
	private function add_to_cart(){
		//if no ProductId with new productId value add to the array;
		if(!$this->found_cart_item){
			array_push($_SESSION['cart_array'],array('productName'=>$this->cartProductName,'productId'=>$this->cart_id,'quantity'=>1));
			$this->check_cart();
			}
		}
	public function empty_cart(){
		 if(isset($_SESSION['cart_array'])){unset($_SESSION['cart_array']);}
		 if(!empty($this->cart)){$this->cart = array();}
		} 
	public function unset_by_productId(){
		$i=0;
		//check to find if product already exist;
		foreach($this->cart as $cart){
			//if productId of current array == the new cart_id increase the quantity by 1 and set
			if($cart['productId'] == $this->cart_id){
				unset($this->cart[$i]);
				$_SESSION['cart_array'] = $this->cart;
				}
			$i++;
			}
		}
	public function total_price(){
	   return	$this->cart_total_price != 0 ? 'Cart Total: #'.$this->cart_total_price : '';
		}
	public function login($user){
		if($user){
			$_SESSION['user_id'] = $user->id;
			$_SESSION['pwd'] = $user->password;
			$this->logged_in = true;
			}
		}
	public function message($message=""){
		if(!empty($message)){
			$_SESSION['message'] = $message;
			}
		else{
		return $this->message;
		}
		}
	private function check_message(){
			if(isset($_SESSION['message'])){
				$this->message = $_SESSION['message'];
				unset($_SESSION['message']);
				}
			else{$this->message;}
		}
	public function logout(){
		unset($_SESSION['user_id']);
		unset($this->id);
		$this->logged_in = false;
		}
	}
	
	
$session = new Session();
?>