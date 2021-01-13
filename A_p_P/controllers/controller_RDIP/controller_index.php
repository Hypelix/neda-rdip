<?php 
class controller_index EXTENDS CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('model_RDIP/model_index');
		$this->load->model('model_RDIP/model_home_user');
		$this->load->model('model_RDIP/model_project');
		$this->load->model('model_RDIP/model_logs');
		$this->load->helper('url_helper');
		$this->load->helper('form');
		$this->load->library('form_validation');
	}

	public function display_contents_index(){
		$this->load->view('view_RDIP/header');
		$result['year']=$this->model_project->get_rdip_masterlist_year();
		$this->load->view('view_RDIP/login', $result);
		$this->load->view('view_RDIP/footer');
        	//print_r($_SESSION);
	}

	public function check_user(){
		$this->form_validation->set_rules('Username', 'Username', 'required|trim');
		$this->form_validation->set_rules('Password', 'Password', 'required|trim');

		if ($this->form_validation->run() === FALSE){
			if($this->model_logs->RDIP_sys_log($this->input->post('Username'),"login","sign in","false","validation error")){
				echo json_encode(array("success" => false, "message" => validation_errors()));
			}
		}
		else{
			if($this->model_index->get_user($this->input->post('Username'), $this->input->post('Password'))){
				$array = $this->model_index->get_user($this->input->post('Username'), $this->input->post('Password'));
				$_SESSION['UN'] = $array[0]->Username;
				$_SESSION['user_type'] = $array[0]->Type;
				$_SESSION['user_agency'] = $array[0]->AgencyID;
				if(($_SESSION['user_type']>0) && ($_SESSION['user_type']<4)){
					//redirect("controller_RDIP/controller_home_admin/display_contents_home_admin");
					if($this->model_logs->RDIP_sys_log($this->input->post('Username'),"login","sign in","true","login success")){
						echo json_encode(array("success" => true, "message" => "Login successful!"));
					}
				}
					// else if($_SESSION['user_type']==3){
					// 	redirect("controller_RDIP/controller_home_user/display_contents_home_user");
					// 	//echo "normal user";
					// }
			}
			else{
				//print_r($this->db->error());
				if($this->model_logs->RDIP_sys_log($this->input->post('Username'),"login","sign in","false","login failed")){
					echo json_encode(array("success" => false, "message" => "Login failed!"));
				}
			}
		}
            // print_r($_SESSION);
	}

	public function get_rdip_masterlist_chapter(){
		$this->form_validation->set_rules('Year', 'Year', 'required');

		if ($this->form_validation->run() === FALSE){
			echo "Searching failed";
		}
		else{
			if($this->model_project->get_rdip_masterlist_chapter($this->input->post('Year'))){
					//$this->index();

				$output='';

				$result['chapter']=$this->model_project->get_rdip_masterlist_chapter($this->input->post('Year'));

				foreach ($result['chapter'] as $row) {
					$output.='<option value="'.$row->ID.'">'.$row->Chap_No." - ".$row->Chap_Title.'</option>';
				}

				echo $output;
			}
			else{
				print_r($this->db->error());
			}
		}
	}

	public function get_projects(){
		$data = $this->model_home_user->get_projects($this->input->post('year'), $this->input->post('chapter'));

		echo json_encode(array("projects" => $data));
	}

}