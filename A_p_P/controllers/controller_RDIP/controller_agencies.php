<?php
class controller_agencies EXTENDS CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('model_RDIP/model_agencies');
        $this->load->model('model_RDIP/model_logs');
        $this->load->helper('url_helper');
        $this->load->helper('form');
        $this->load->library('form_validation');
        if(($_SESSION['user_type']<1) || ($_SESSION['user_type']>3)){
            redirect("controller_RDIP/controller_index/display_contents_index");
        }
    }

    public function display_contents_agencies(){
        $this->load->view('view_RDIP/header');
    		//$result['data']=$this->model_agencies->get_agencies();
    		//$result['agencies']=$this->model_users_list->get_agencies();
        $this->load->view('view_RDIP/agencies');
        $this->load->view('view_RDIP/footer');
    }

    public function add_agency(){
        $this->form_validation->set_rules('Name', 'Name', 'required|trim');
        $this->form_validation->set_rules('Description', 'Description', 'required|trim');

        if ($this->form_validation->run() === FALSE){
            echo json_encode(array("success" => false, "message" => validation_errors()));
        }
        else{
            if($this->model_agencies->add_agency()){
                $credentials = $this->model_logs->retrieve_credentials(1,"agency","AgencyID",null);
                // if($this->model_logs->RDIP_sys_log($_SESSION['UN'],"agency","create","true",$this->input->post('Name')." has been created. Record:".json_encode($this->input->post()))){
                if($this->model_logs->RDIP_sys_log($_SESSION['UN'],"agency","create","true","Record: ".json_encode($credentials))){
                    echo json_encode(array("success" => true, "message" => "Adding successful!"));
                }
            }
            else{
                print_r($this->db->error());
            }
        }
    }

    public function update_agency(){
        $this->form_validation->set_rules('Name', 'Name', 'required|trim');
        $this->form_validation->set_rules('Description', 'Description', 'required|trim');

        if ($this->form_validation->run() === FALSE){
            echo json_encode(array("success" => false, "message" => validation_errors()));
        }
        else{
            $credentials = $this->model_logs->retrieve_credentials(0,"agency","AgencyID",$this->input->post('AgencyID'));
            if($this->model_agencies->update_agency()){
                if($this->model_logs->RDIP_sys_log($_SESSION['UN'],"agency","update","true","Old Record: ".json_encode($credentials)." ----- New Record:".json_encode($this->input->post()))){
                    echo json_encode(array("success" => true, "message" => "Editing successful!"));
                }
            }
            else{
                print_r($this->db->error());
            }
        }
    }

    public function delete_agency(){
        $credentials = $this->model_logs->retrieve_credentials(0,"agency","AgencyID",$this->input->post('AgencyID'));
        if($this->model_agencies->delete_agency($this->input->post('AgencyID'))){
            // if($this->model_logs->RDIP_sys_log($_SESSION['UN'],"agency","delete","true","PK=".$this->input->post('AgencyID')." has been deleted")){
            if($this->model_logs->RDIP_sys_log($_SESSION['UN'],"agency","delete","true","Record: ".json_encode($credentials))){
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
            $data = $this->model_agencies->search_all_agencies();
        }
        else if($page==0){
            $data = $this->model_agencies->search_agencies();
        }
        else{
            $data = $this->model_agencies->paginate_agencies($page);
        }

        $i=0;
        foreach($data as $row){
            $output .='<tr>
            <td id="ID'.$i.'" class="ID">'.$row->AgencyID.'</td>
            <td id="Name'.$i.'" class="Name">'.$row->Name.'</td>
            <td id="Description'.$i.'" class="Description">'.$row->Description.'</td>';
            $output .='<td>
            <div id="SaveBtn'.$i.'" class="btn-group">
            <button type="button" id="'.$row->AgencyID.'" class="btn btn-xs btn-warning btn_save" data-toggle="modal" data-target="#myModal" onclick="pass_agency_credentials(\''.$row->AgencyID.'\', \''.$row->Name.'\', \''.$row->Description.'\')">
            Update
            </button>
            <button type="button" id="'.$row->AgencyID.'" class="btn btn-xs btn-danger btn_delete" >
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