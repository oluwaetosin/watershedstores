<?php require_once('constants.php'); ?>
<?php require_once('database.php'); ?>
<?php
class  PicUpload{
	public $filePath    = PIC_PATH;
	public $picture_id;
	public $name;
	public $product_id;
	  protected static $table_name="pictures";
	protected static $db_fields = array('picture_id', 'name','product_id');
	public $fileName     = "";
	public $fileFormats  = array( 'jpeg','png','jpg','JPEG','PNG');
	public $fileTemp     = "";
	public $fileSize     = "";
	public $fileType     = "";	
	public function __construct($file){
		   $this->fileName = $file['name'];
		   $this->fileType = $file['type'];
		   $this->fileSize = $file['size'];
	   	   $this->fileTemp = $file['tmp_name'];
		   $this->name = rand().time().".".basename($this->fileType);
		}
	public function validateFileType(){
			if(!in_array(basename($this->fileType),$this->fileFormats)){
				@unlink($this->fileTemp);
				return false;
				}
			else{
				return true;
				}
		}
	public function validateFileSize(){
			if($this->fileSize > MM){
				@unlink($this->fileTemp);
				return false;
				}
			else{
				return true;
				}
		}
	public function moveFile(){
		
			if(move_uploaded_file($this->fileTemp,$this->filePath.$this->name)){
				@unlink($this->fileTemp);
				return true;
				}
			else{
				@unlink($this->fileTemp);
				return false;
				}
		}
		
	 public function unlink($picture_name){
		 unlink(PIC_PATH.$picture_name);
		 }

	}
 
?>