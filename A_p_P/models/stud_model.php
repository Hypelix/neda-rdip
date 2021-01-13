<?php
class stud_model EXTENDS CI_Model {

	public function __construct(){
		$this->load->database();
    }

	public function set_stud() {
		$this->load->helper('url');

 		$data = array(
	        'fname' => $this->input->post('fname'),
	        'lname' => $this->input->post('lname')
	    );

	    return $this->db->insert('stud', $data);
	}

}