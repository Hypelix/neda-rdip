<?php 
class controller_project EXTENDS CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('model_RDIP/model_project');
        $this->load->model('model_RDIP/model_users_list');
        $this->load->model('model_RDIP/model_fund_source');
        $this->load->model('model_RDIP/model_logs');
        $this->load->helper('url_helper');
        $this->load->helper('form');
        $this->load->library('form_validation');
        if(($_SESSION['user_type']<1) || ($_SESSION['user_type']>3)){
            redirect("controller_RDIP/controller_index/display_contents_index");
        }
    }

    public function index(){
        $this->load->view('view_RDIP/header');
        $result['year']=$this->model_project->get_rdip_masterlist_year();
        $result['agencies']=$this->model_users_list->get_agencies();
        $result['fund']=$this->model_fund_source->search_all_fund_source();
        $this->load->view('view_RDIP/project', $result);
        $this->load->view('view_RDIP/footer');
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

    public function getData(){
			//retrieve all post values from DOM's datatable
        $data = $this->input->post();

			//pass to the model
        $output = $this->model_project->getData(
            $data['length'],
            $data['start'],
            $data['order'],
            $data['search']['value'],
            $data['year'],
            $data['chapters']
        );

			//format and return to DOM's datatable
			//A. format
        $all_project = $this->model_project->select_all_project();
        $result=array(
            "draw" => $data["draw"],
            "data" => $output,
            "recordsTotal" => count($all_project),
            "recordsFiltered" => $data['search']['value'] != "" ? count($output) : count($all_project)
        );

			//B. return
        echo json_encode($result);
    }

    public function add_project(){
        $this->form_validation->set_rules('Title', 'Title', 'required|trim');
        $this->form_validation->set_rules('Prog_Proj_Brief', 'Prog_Proj_Brief', 'required|trim');
        $this->form_validation->set_rules('AgencyID', 'AgencyID', 'required|trim');
        $this->form_validation->set_rules('Spatial_Coverage', 'Spatial_Coverage', 'required|trim');
        $this->form_validation->set_rules('FSID', 'FSID', 'required|trim');
        $this->form_validation->set_rules('Year_1', 'Year_1', 'required|trim');
        $this->form_validation->set_rules('Year_2', 'Year_2', 'required|trim');
        $this->form_validation->set_rules('Year_3', 'Year_3', 'required|trim');
        $this->form_validation->set_rules('Year_4', 'Year_4', 'required|trim');
        $this->form_validation->set_rules('Year_5', 'Year_5', 'required|trim');
        $this->form_validation->set_rules('Year_6', 'Year_6', 'required|trim');
        $this->form_validation->set_rules('Total_Inv_Cost', 'Total_Inv_Cost', 'required|trim');
        $this->form_validation->set_rules('Latitude', 'Latitude', 'required|trim');
        $this->form_validation->set_rules('Longitude', 'Longitude', 'required|trim');
        $this->form_validation->set_rules('rdip_ml_ID', 'rdip_ml_ID', 'required|trim');

        if ($this->form_validation->run() === FALSE){
            echo json_encode(array("success" => false, "message" => validation_errors()));
        }
        else{
            if($this->model_project->add_project()){
                $rdip_ml_ID = $this->input->post('rdip_ml_ID');
                $prog_proj_ID = $this->model_project->get_recent_project_ID();

                if($this->model_project->add_project_chapter($rdip_ml_ID,$prog_proj_ID['ID'])){
                    $credentials = $this->model_logs->retrieve_credentials(1,"prog_proj","ID",null);
                    if($this->model_logs->RDIP_sys_log($_SESSION['UN'],"project","create","true","Record: ".json_encode($credentials))){
                        echo json_encode(array("success" => true, "message" => "Adding successful!"));
                    }
                }
                else{
                    print_r($this->db->error());
                }
            }
            else{
                print_r($this->db->error());
            }
        }
    }

    public function update_project(){
        $this->form_validation->set_rules('Title', 'Title', 'required|trim');
        $this->form_validation->set_rules('Prog_Proj_Brief', 'Prog_Proj_Brief', 'required|trim');
        $this->form_validation->set_rules('AgencyID', 'AgencyID', 'required|trim');
        $this->form_validation->set_rules('Spatial_Coverage', 'Spatial_Coverage', 'required|trim');
        $this->form_validation->set_rules('FSID', 'FSID', 'required|trim');
        $this->form_validation->set_rules('Year_1', 'Year_1', 'required|trim');
        $this->form_validation->set_rules('Year_2', 'Year_2', 'required|trim');
        $this->form_validation->set_rules('Year_3', 'Year_3', 'required|trim');
        $this->form_validation->set_rules('Year_4', 'Year_4', 'required|trim');
        $this->form_validation->set_rules('Year_5', 'Year_5', 'required|trim');
        $this->form_validation->set_rules('Year_6', 'Year_6', 'required|trim');
        $this->form_validation->set_rules('Total_Inv_Cost', 'Total_Inv_Cost', 'required|trim');
        $this->form_validation->set_rules('Latitude', 'Latitude', 'required|trim');
        $this->form_validation->set_rules('Longitude', 'Longitude', 'required|trim');

        if ($this->form_validation->run() === FALSE){
            echo json_encode(array("success" => false, "message" => validation_errors()));
        }
        else{
            $credentials = $this->model_logs->retrieve_credentials(0,"prog_proj","ID",$this->input->post('ID'));
            if($this->model_project->update_project()){
                if($this->model_logs->RDIP_sys_log($_SESSION['UN'],"project","update","true","Old Record: ".json_encode($credentials)." ----- New Record:".json_encode($this->input->post()))){
                    echo json_encode(array("success" => true, "message" => "Editing successful!"));
                }
            }
            else{
                print_r($this->db->error());
            }
        }
    }

    public function add_prog_proj_status(){
        $this->form_validation->set_rules('Status', 'Status', 'required');
        $this->form_validation->set_rules('Remarks', 'Remarks', 'required');
        $this->form_validation->set_rules('prog_proj_ID', 'prog_proj_ID', 'required');

        if ($this->form_validation->run() === FALSE){
            echo json_encode(array("success" => false, "message" => validation_errors()));
        }
        else{
            if($this->model_project->add_prog_proj_status()){
                $credentials = $this->model_logs->retrieve_credentials(1,"prog_proj_status","Code",null);
                if($this->model_logs->RDIP_sys_log($_SESSION['UN'],"project->status","create","true","Record: ".json_encode($credentials))){
                    echo json_encode(array("success" => true, "message" => "Adding successful!"));
                }
            }
            else{
                print_r($this->db->error());
            }
        }
    }

    public function get_prog_proj_status($prog_proj_ID){
            //$this->form_validation->set_rules('prog_proj_ID', 'prog_proj_ID', 'required');
        $output = '';

        $data = $this->model_project->get_prog_proj_status($prog_proj_ID);

        $i=0;
        foreach($data as $row){
            $output .='<tr>
            <td>'.$row->Code.'</td>
            <td>'.$row->Status.'</td>
            <td>'.$row->Remarks.'</td>
            <td>'.$row->Date.'</td>';
            if(($_SESSION['user_type']==1) || ($_SESSION['user_type']==2)){
                $output.='<td>
                <button onclick="pass_status_credentials(\''.$row->Code.'\', \''.$row->Status.'\', \''.$row->Remarks.'\')">Edit</button>
                </td>';
            }
            $output .='</tr>';
            $i++;
        }
        echo $output;
    }

    public function update_prog_proj_status(){
        $this->form_validation->set_rules('Code', 'Code', 'required');
        $this->form_validation->set_rules('Status', 'Status', 'required');
        $this->form_validation->set_rules('Remarks', 'Remarks', 'required');

        if ($this->form_validation->run() === FALSE){
            echo json_encode(array("success" => false, "message" => validation_errors()));
        }
        else{
            $credentials = $this->model_logs->retrieve_credentials(0,"prog_proj_status","Code",$this->input->post('Code'));
            if($this->model_project->update_prog_proj_status()){
                if($this->model_logs->RDIP_sys_log($_SESSION['UN'],"project->status","update","true","Old Record: ".json_encode($credentials)." ----- New Record:".json_encode($this->input->post()))){
                    echo json_encode(array("success" => true, "message" => "Editing successful!"));
                }
            }
            else{
                print_r($this->db->error());
            }
        }
    }

}