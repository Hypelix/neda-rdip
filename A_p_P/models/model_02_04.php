<?php 
	class model_02_04 EXTENDS CI_Model{

		public function __construct(){
			$this->load->database();
			$this->load->helper('url');
    	}

		public function set_stud(){
		    //$this->load->helper('url');

		    //$slug = url_title($this->input->post('title'), 'dash', TRUE);

		    $data = array(
		        'fname' => $this->input->post('fname'),
		        //'slug' => $slug,
		        'lname' => $this->input->post('lname')
		    );

		    return $this->db->insert('stud', $data);
		}

		public function get_stud($id){
			//$id = $this->input->post('id', true);
			$query = $this->db->query("SELECT * FROM stud WHERE id = ".$id);

			$row = $query->row();

			if (isset($row)){
		        echo $row->id;
		        echo $row->fname;
		        echo $row->lname;
			}
		}
	}