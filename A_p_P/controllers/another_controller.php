<?php 
	class another_controller EXTENDS CI_Controller{
		public function __construct(){
            parent::__construct();
            $this->load->model('stud_model');
            $this->load->helper('url_helper');
        }

		public function merely_displaying_contents_together(){
			$this->load->view('temp/header');
			$this->load->view('static/content');
			$this->load->view('temp/footer');
		}

		public function insert_student(){
            $this->load->helper('form');
            $this->load->library('form_validation');

            //$data['title'] = 'Create a news item';

            $this->form_validation->set_rules('fname', 'First Name', 'required');
            $this->form_validation->set_rules('lname', 'Last Name', 'required');

            if ($this->form_validation->run() === FALSE)
            {
                // $this->load->view('templates/header', $data);
                // $this->load->view('news/create');
                // $this->load->view('templates/footer');

            }
            else
            {
                $this->stud_model->set_stud();
                //$this->load->view('news/success');
            }
        }

	}