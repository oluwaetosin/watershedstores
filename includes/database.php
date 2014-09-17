<?php require_once("config.php"); ?>
<?php
	class MYSQLDatabase{
			private $last_query;
			private $connection;
			private  $new_enough_php;
			private $gpc;
			function __construct(){
				$this->open_connection();
				$this->new_enough_php = function_exists("mysqli_real_escape_string");
				$this->gpc            =  get_magic_quotes_gpc();
				} 
			private function open_connection(){
				$this->connection = mysqli_connect(DB_HOST,DB_USER,DB_PWD);
				if(!$this->connection){
					die("Eror Connecting to Database");
					}else{
						if(!mysqli_select_db($this->connection,DB_NAME)){die ("Error Selecting Database");}
						}
			}
			private function confirm_query($query){
				$last_sql = $this->last_query;
				if(!$query){
					die("<p>Error Performing query</p><p>{$this->last_query}</p>".mysqli_error());
					}
				}
			public function free_result($result){
				mysqli_free_result($result);
				}
			public  function query($sql=""){
				$this->last_query = $sql;
				$result = mysqli_query($this->connection,$sql);
				$this->confirm_query($result);
				if($result){
					return $result;
					}else{
						return false;
						}
				}
			public  function insert_id(){
				return mysqli_insert_id($this->connection);
				}
			public  function affected_rows(){
				 return mysqli_affected_rows($this->connection);
				}
			public function num_rows($result){
				return mysqli_num_rows($result);
				}
			public function fetch_array($result){
					return mysqli_fetch_array($result, MYSQLI_ASSOC);
				}
			public function escape_value($value){
				 if($this->new_enough_php){
					 if($this->gpc){
						 $value = stripslashes($value);
						 }
					$value = mysqli_real_escape_string($this->connection,$value);
					 }else{
						 if(!$this->gpc){
							 $value = addslashes($value);
							 }
						 }
				 return $value;
				}
			public function close_connection(){
			   if(isset($this->connection)){
				   mysqli_close($this->connection);
				   unset($this->connection);
				   }
			}
		}
		
	$database = new MYSQLDatabase;
	?>