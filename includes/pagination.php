<?php
 class Pagination {
 	public $cur_page;
	public $per_page;
	public $total_count;
	public function offset(){
		return ($this->cur_page - 1) * $this->per_page;
		}
	public function __construct($page=1, $per_page=20, $total_count=0){
			$this->cur_page     = (int)$page;
			$this->per_page     = (int)$per_page;
			$this->total_count  = (int)$total_count;
		}
	public function total_pages(){
		return ceil($this->total_count/$this->per_page);
		}
	public function prev_page(){
		return $this->cur_page - 1;
		}
	public function next_page(){
		return $this->cur_page + 1;
		}
	public function has_next_page(){
         return $this->next_page() <= $this->total_pages() ? true : false;
		}
	public function has_prev_page(){
		return $this->prev_page() >=  1 ? true : false;
		}
 } 
 
 $pagination = new Pagination($page,$per_page,$total_count); 
 
?>