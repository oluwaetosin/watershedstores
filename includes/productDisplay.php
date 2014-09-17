<?php require_once('session.php') ?>
<?php require_once('constants.php') ?>
<?php require_once('functions.php'); ?>
<?php require_once('database.php'); ?>
<?php require_once('product.php'); ?>
<?php require_once('category.php'); ?>
<?php require_once('pictures.php'); ?>
<?php 
	class ProductDisplay {
		public $categoryIdSet = array();
		public $product_id;
		public $productName;
		public $price;
		public $details;
		public $category_category_id;
		public $dateAdded;
		public static $db_fields = array('product_id','productName','price','details','category_category_id','dateAdded');
		function __construct(){
			  $this->categoryIdSet = self::allCategories();
			}
		/*public function allCategories(){
			global $database;
         $sql = 'SELECT DISTINCT category_category_id from products';
		 $resultSet = $database->query($sql);
	     return Parent::find_by_sql($sql);
			}
		
			public static function find_all() {
		return self::find_by_sql("SELECT * FROM ".self::$table_name);
  }
  
  public static function find_by_id($id=0) {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE  product_id={$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  */
  public static function find_by_sql($sql="") {
    global $database;
    $result_set = $database->query($sql);
    $object_array = array();
    while ($row = $database->fetch_array($result_set)) {
      $object_array[] = self::instantiate($row);
    }
    return $object_array;
  }

	public static function count_all() {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name;
    $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
    return array_shift($row);
	}
    private static function allCategories(){
		 return self::find_by_sql('SELECT DISTINCT category_category_id FROM products');
		}
	private static function instantiate($record) {
       $object = new self;
		foreach($record as $attribute=>$value){
		  if($object->has_attribute($attribute)) {
		    $object->$attribute = $value;
		  }
		}
		return $object;
	}
	
	private function has_attribute($attribute) {
	  // We don't care about the value, we just want to know if the key exists
	  // Will return true or false
	  return array_key_exists($attribute, $this->attributes());
	}

	protected function attributes() { 
		// return an array of attribute names and their values
	  $attributes = array();
	  foreach(self::$db_fields as $field) {
	    if(property_exists($this, $field)) {
	      $attributes[$field] = $this->$field;
	    }
	  }
	  return $attributes;
	}
		}
 $productDisplay = new ProductDisplay;


?>