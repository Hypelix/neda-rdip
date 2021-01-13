<?php 
	class controller_02_04 EXTENDS CI_Controller{

		public function __construct(){
            parent::__construct();
            $this->load->model('model_02_04');
            $this->load->helper('url_helper');

            $this->load->helper('form');
            $this->load->library('form_validation');
        }

		public function display_contents(){
			$this->load->view('view_02_04/header');
			$this->load->view('view_02_04/content');
			$this->load->view('view_02_04/footer');
		}

        public function add_stud(){
            $this->form_validation->set_rules('fname', 'First Name', 'required');
            $this->form_validation->set_rules('lname', 'Last Name', 'required');

            if ($this->form_validation->run() === FALSE){
            	//prompt
            	echo "zzz";
            }
            else{
                if($this->model_02_04->set_stud()){
                	//header("Location:http://localhost/debug/OOP/CodeIgniter-3.1.10/index.php/controller_02_04/display_contents");
					$this->display_contents();
                }
                else{
                	print_r($this->db->error());
                }
            }
        }

        public function search_stud(){
        	// $this->form_validation->set_rules('id', 'ID', 'required');

        	// if($this->form_validation->run() === FALSE){
        	// 	echo "zzz search";
        	// }
        	// else{
        	// 	if($this->model_02_04->get_stud()){

        	// 	}
        	// 	else{
        	// 		print_r($this->db->error());
        	// 	}
        	// }
        	$this->model_02_04->get_stud(5);
        }

	}