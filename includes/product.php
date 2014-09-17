<?php
require_once('database.php');
class Product {
    protected static $table_name="products";
	protected static $db_fields = array('product_id', 'productName','price','details','category_category_id','dateAdded','pictureName','pictureId');
	public $product_id;
	public $productName;
	public $price;
	public $details;
	public $category_category_id;
	public $dateAdded;
	public $pictureName;
	public $pictureId;
	public  function productNameCount(){
		 global $database;
		 $sql = "SELECT COUNT(productName) FROM products WHERE productName = '".$this->productName."' LIMIT 1";
		 $productNameSet = $database->query($sql); 
	     return array_shift($database->fetch_array($productNameSet));
		}
	public static function find_all() {
		return self::find_by_sql("SELECT * FROM ".self::$table_name);
  }
  
  public static function find_by_id($id=0) {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE  product_id={$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  
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

	private static function instantiate($record) {
		// Could check that $record exists and is an array
    $object = new self;
		// Simple, long-form approach:
		// $object->id 				= $record['id'];
		// $object->username 	= $record['username'];
		// $object->password 	= $record['password'];
		// $object->first_name = $record['first_name'];
		// $object->last_name 	= $record['last_name'];
		
		// More dynamic, short-form approach:
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
	
	protected function sanitized_attributes() {
	  global $database;
	  $clean_attributes = array();
	  // sanitize the values before submitting
	  // Note: does not alter the actual value of each attribute
	  foreach($this->attributes() as $key => $value){
	    $clean_attributes[$key] = $database->escape_value($value);
	  }
	  return $clean_attributes;
	}
	
	public function save() {
	  // A new record won't have an id yet.
	  return isset($this->product_id) ? $this->update() : $this->create();
	}
	
	public function create() {
		global $database; 
		$attributes = $this->sanitized_attributes();
		$productName = $database->escape_value($this->productName);
		$price       = $database->escape_value($this->price);
		$details     = $database->escape_value($this->details);
		$category_category_id = $database->escape_value($this->category_category_id);
		$dateAdded   = $database->escape_value($this->dateAdded);
	    $sql = 'INSERT INTO products (product_id, productName, price, details, category_category_id, dateAdded)
	         VALUES ("","'.$productName.'","'.$price.'","'.$details.'", "'.$category_category_id.'","'.$dateAdded.'")';
	  if($database->query($sql)) {
	    $this->product_id = $database->insert_id();
	    return true;
	  } else {
	    return false;
	  }
	}
    public function productPrice($quantity){
		return $this->price * $quantity;
		}
	public function update() {
	  global $database;
		// Don't forget your SQL syntax and good habits:
		// - UPDATE table SET key='value', key='value' WHERE condition
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		$attributes = $this->sanitized_attributes();
		$attribute_pairs = array();
		foreach($attributes as $key => $value) {
		  $attribute_pairs[] = "{$key}='{$value}'";
		}
		$sql = "UPDATE ".self::$table_name." SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE product_id=". $database->escape_value($this->product_id);
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	}
	public static function find_product_by_id($product_id){
		        global $database;
		         $product_id = preg_replace('#[^0-9]#i','',$product_id);
		         $sql = ' SELECT products.product_id as product_id,products.productName as productName,products.price as price,
				          pictures.name as pictureName';
				 $sql .= ' FROM '.self::$table_name;
                 $sql .= ' INNER JOIN pictures ON products.product_id = pictures.product_id';
                 $sql .= ' WHERE products.product_id = '.$product_id ;
		         $sql .= ' LIMIT 1';
				 return array_pop(self::find_by_sql($sql));
		}
    public static function find_by_category_category_id($category_category_id){
		$sql  = ' SELECT products.product_id as product_id,products.productName as productName,products.price as price,products.details as details,products.category_category_id as category_category_id,products.dateAdded as dateAdded,pictures.name as pictureName,pictures.picture_id as pictureId';
        $sql .= ' FROM '.self::$table_name;
        $sql .= ' INNER JOIN pictures ON products.product_id = pictures.product_id';
        $sql .= ' WHERE products.category_category_id = '.$category_category_id ;
		$sql .= ' LIMIT 3';
		return self::find_by_sql($sql);
		}
	public static function find_all_by_category_category_id($category_category_id){
		$sql  = ' SELECT products.product_id as product_id,products.productName as productName,products.price as price,products.details as details,products.category_category_id as category_category_id,products.dateAdded as dateAdded,pictures.name as pictureName,pictures.picture_id as pictureId';
        $sql .= ' FROM '.self::$table_name;
        $sql .= ' INNER JOIN pictures ON products.product_id = pictures.product_id';
        $sql .= ' WHERE products.category_category_id = '.$category_category_id ;
		return self::find_by_sql($sql);
		}
	public function delete() {
		global $database;
		// Don't forget your SQL syntax and good habits:
		// - DELETE FROM table WHERE condition LIMIT 1
		// - escape all values to prevent SQL injection
		// - use LIMIT 1
	  $sql = "DELETE FROM ".self::$table_name;
	  $sql .= " WHERE product_id=". $database->escape_value($this->product_id);
	  $sql .= " LIMIT 1";
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	
		// NB: After deleting, the instance of User still 
		// exists, even though the database entry does not.
		// This can be useful, as in:
		//   echo $user->first_name . " was deleted";
		// but, for example, we can't call $user->update() 
		// after calling $user->delete().
	}

	}

?>