<?php 
class controller_home_user EXTENDS CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('model_RDIP/model_home_user');
        $this->load->model('model_RDIP/model_project');
        $this->load->helper('url_helper');
        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    public function display_contents_home_user(){
        $this->load->view('view_RDIP/header');
        $result['year']=$this->model_project->get_rdip_masterlist_year();
        $this->load->view('view_RDIP/home_user',$result);
        $this->load->view('view_RDIP/footer');
    }

    public function get_projects(){
        $data = $this->model_home_user->get_projects($this->input->post('year'), $this->input->post('chapter'));

        echo json_encode(array("projects" => $data));
    }

}