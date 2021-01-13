<?php 
class controller_fund_source EXTENDS CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('model_RDIP/model_fund_source');
        $this->load->model('model_RDIP/model_logs');
        $this->load->helper('url_helper');
        $this->load->helper('form');
        $this->load->library('form_validation');
        if(($_SESSION['user_type']<1) || ($_SESSION['user_type']>3)){
            redirect("controller_RDIP/controller_index/display_contents_index");
        }
    }

    public function display_contents_fund_source(){
        $this->load->view('view_RDIP/header');
        $this->load->view('view_RDIP/fund_source');
        $this->load->view('view_RDIP/footer');
    }

    public function add_fund_source(){
        $this->form_validation->set_rules('Name', 'Name', 'required|trim');
        $this->form_validation->set_rules('Description', 'Description', 'required|trim');

        if ($this->form_validation->run() === FALSE){
            echo json_encode(array("success" => false, "message" => validation_errors()));
        }
        else{
            if($this->model_fund_source->add_fund_source()){
                $credentials = $this->model_logs->retrieve_credentials(1,"funding_src","FSID",null);
                if($this->model_logs->RDIP_sys_log($_SESSION['UN'],"funding source","create","true","Record: ".json_encode($credentials))){
                    echo json_encode(array("success" => true, "message" => "Adding successful!"));
                }
            }
            else{
                print_r($this->db->error());
            }
        }
    }

    public function update_fund_source(){
        $this->form_validation->set_rules('Name', 'Name', 'required|trim');
        $this->form_validation->set_rules('Description', 'Description', 'required|trim');

        if ($this->form_validation->run() === FALSE){
            echo json_encode(array("success" => false, "message" => validation_errors()));
        }
        else{
            $credentials = $this->model_logs->retrieve_credentials(0,"funding_src","FSID",$this->input->post('FSID'));
            if($this->model_fund_source->update_fund_source()){
                if($this->model_logs->RDIP_sys_log($_SESSION['UN'],"funding source","update","true","Old Record: ".json_encode($credentials)." ----- New Record:".json_encode($this->input->post()))){
                    echo json_encode(array("success" => true, "message" => "Editing successful!"));
                }
            }
            else{
                print_r($this->db->error());
            }
        }
    }

    public function delete_fund_source(){
        $credentials = $this->model_logs->retrieve_credentials(0,"funding_src","FSID",$this->input->post('FSID'));
        if($this->model_fund_source->delete_fund_source($this->input->post('FSID'))){
            if($this->model_logs->RDIP_sys_log($_SESSION['UN'],"funding source","delete","true","Record: ".json_encode($credentials))){
                echo json_encode(array("success" => true, "message" => "Deletion successful!"));
            }
        }
        else{
            print_r($this->db->error());
        }
    }

    public function reload_table($page){
        $output = '';

        if($page==-1){
            $data = $this->model_fund_source->search_all_fund_source();
        }
        else if($page==0){
            $data = $this->model_fund_source->search_fund_source();
        }
        else{
            $data = $this->model_fund_source->paginate_fund_source($page);
        }

        $i=0;
        foreach($data as $row){
            $output .='<tr>
            <td id="ID'.$i.'" class="ID">'.$row->FSID.'</td>
            <td id="Name'.$i.'" class="Name">'.$row->Name.'</td>
            <td id="Description'.$i.'" class="Description">'.$row->Description.'</td>';
            $output .='<td>
            <div id="SaveBtn'.$i.'" class="btn-group">
            <button type="button" id="'.$row->FSID.'" class="btn btn-xs btn-warning btn_save" data-toggle="modal" data-target="#myModal" onclick="pass_fund_source_credentials(\''.$row->FSID.'\', \''.$row->Name.'\', \''.$row->Description.'\')">
            Update
            </button>
            <button type="button" id="'.$row->FSID.'" class="btn btn-xs btn-danger btn_delete" >
            Delete
            </button>
            </div>
            </td>';
            $output .='</tr>';
            $i++;
        }
        echo $output;
    }

}