<?php 
class controller_home_admin EXTENDS CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('model_RDIP/model_home_admin');
        $this->load->model('model_RDIP/model_project');
        $this->load->model('model_RDIP/model_logs');
        $this->load->helper('url_helper');
        $this->load->helper('form');
        $this->load->library('form_validation');
        if(($_SESSION['user_type']<1) || ($_SESSION['user_type']>3)){
            redirect("controller_RDIP/controller_index/display_contents_index");
        }
    }

    public function display_contents_home_admin(){
        $this->load->view('view_RDIP/header');
        $result['year']=$this->model_project->get_rdip_masterlist_year();
        $this->load->view('view_RDIP/home_admin',$result);
        $this->load->view('view_RDIP/footer');
    }

    public function generate_chart1(){
        $data = $this->model_home_admin->generate_chart1($this->input->post('year'));
        $agency = array();
        $projects = array();
        foreach ($data as $row) {
            $agency[] = $row->Name;
            $projects[] = $row->projects;
        }
        echo json_encode(array("agency" => $agency, "projects" => $projects));
    }

    public function generate_chart2(){
        $data = $this->model_home_admin->generate_chart2($this->input->post('year'), $this->input->post('chapter'));
        $agency = array();
        $projects = array();
        foreach($data as $row){
            $agency[] = $row->Name;
            $projects[] = $row->projects;
        }
        echo json_encode(array("agency" => $agency, "projects" => $projects));

        //print_r($data);
    }

    public function logout_and_remove_credentials(){
        if($this->model_logs->RDIP_sys_log($_SESSION['UN'],"N/A","sign out","true","logout success")){
            session_destroy();
            redirect("controller_RDIP/controller_index/display_contents_index");
        }
    }

}