<?php 
	class trial_controller EXTENDS CI_Controller{

		public function content($header = 'header', $footer = 'footer'){
			if(1==2){
				show_404();
			}
			else{
				$this->load->view('templates/gen_page_header');
				$this->load->view('trial/content');
				$this->load->view('templates/gen_page_footer');
			}
		}

	}