<?php 
class model_index EXTENDS CI_Model{

	public function __construct(){
		$this->load->database();
		$this->load->helper('url');
	}

	public function get_user($Username, $Password){
    		//asdasdasd 
    		//$query = $this->db->query("SELECT * FROM stud WHERE id = ".$id);
		$query = $this->db->query("SELECT Username,Type, AgencyID FROM user_record WHERE CONCAT(Username, ' ', Password) = '".$Username.' '.$Password."' AND Status=1");
		return $query->result();
	}

}