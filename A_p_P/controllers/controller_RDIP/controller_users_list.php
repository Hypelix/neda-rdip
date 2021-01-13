<?php 
class controller_users_list EXTENDS CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('model_RDIP/model_users_list');
        $this->load->model('model_RDIP/model_logs');
        $this->load->helper('url_helper');
        $this->load->helper('form');
        $this->load->library('form_validation');
        if(($_SESSION['user_type']<1) || ($_SESSION['user_type']>3)){
            redirect("controller_RDIP/controller_index/display_contents_index");
        }
    }

    public function display_contents_users_list(){
        $this->load->view('view_RDIP/header');
        $result['data']=$this->model_users_list->get_users();
        $result['agencies']=$this->model_users_list->get_agencies();
        $this->load->view('view_RDIP/users_list',$result);
        $this->load->view('view_RDIP/footer');
    }

    public function user_add(){
        	//print_r($_POST);
        $this->form_validation->set_rules('Username', 'Username', 'required|is_unique[user_record.Username]|trim');
        $this->form_validation->set_rules('Password', 'Password', 'required|trim');
        $this->form_validation->set_rules('Type', 'Type', 'required|trim');
        $this->form_validation->set_rules('Agency', 'Agency', 'required|trim');
        $this->form_validation->set_rules('Status', 'Status', 'required|trim');

        if ($this->form_validation->run() === FALSE){
            echo json_encode(array("success" => false, "message" => validation_errors()));
        }
        else{
            if($this->model_users_list->set_user()){
					//$this->display_contents_users_list();
                if($this->model_logs->RDIP_sys_log($_SESSION['UN'],"user","create","true",$this->input->post('Username')." has been created")){
                // if($this->model_logs->RDIP_sys_log($_SESSION['UN'],"user","create","true",json_encode($this->input->post()))){
                    echo json_encode(array("success" => true, "message" => "Adding successful!"));
                }
            }
            else{
                print_r($this->db->error());
            }
        }
    }

    public function user_edit(){
        	//print_r($_POST);
        $this->form_validation->set_rules('Username', 'Username', 'required|trim');
        $this->form_validation->set_rules('Password', 'Password', 'required|trim');
        $this->form_validation->set_rules('Type', 'Type', 'required|trim');
        $this->form_validation->set_rules('Agency', 'Agency', 'required|trim');
        $this->form_validation->set_rules('Status', 'Status', 'required|trim');

        if ($this->form_validation->run() === FALSE){
            echo json_encode(array("success" => false, "message" => validation_errors()));
        }
        else{
            if($this->model_users_list->update_user()){
                if($this->model_logs->RDIP_sys_log($_SESSION['UN'],"user","update","true",$this->input->post('Old_Username')." has been updated")){
                    echo json_encode(array("success" => true, "message" => "Editing successful!"));
                }
            }
            else{
                print_r($this->db->error());
            }
        }
    }

    public function user_delete(){
        if($this->model_users_list->delete_user($this->input->post('Username'))){
            if($this->model_logs->RDIP_sys_log($_SESSION['UN'],"user","delete","true",$this->input->post('Username')." has been deleted")){
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
            $data = $this->model_users_list->get_all_users();
        }
        else if($page==0){
            $data = $this->model_users_list->get_users();
        }
        else{
            $data = $this->model_users_list->paginate_user_list($page);
        }

        $i=0;
        foreach($data as $row){
            $output .='<tr>
            <td id="Username'.$i.'" class="Username">'.$row->Username.'</td>
            <td style="-webkit-text-security:disc;" id="Password'.$i.'" class="Password">'.$row->Password.'</td>';
            if($row->Type==1) $output .= '<td id="Type'.$i.'" class="Type">Super Admin</td>';
            else if($row->Type==2) $output .='<td id="Type'.$i.'" class="Type">Admin</td>';
            else if($row->Type==3) $output .='<td id="Type'.$i.'" class="Type">User</td>';
            else $output .='<td id="Type'.$i.'" class="Type">null</td>';
            $output .='<td id="Agency'.$i.'" class="Agency">'.$row->AgencyID.'</td>';
            if($row->Status==1) $output .='<td id="Status'.$i.'" class="Status">Allowed</td>';
            else if($row->Status==0) $output .='<td id="Status'.$i.'" class="Status">Blocked</td>';
            else $output .='<td id="Status'.$i.'" class="Status">null</td>';
            $output .='<td>
            <div id="SaveBtn'.$i.'" class="btn-group">
            <button type="button" id="'.$row->Username.'" class="btn btn-xs btn-warning btn_save" data-toggle="modal" data-target="#myModal" onclick="pass_user_credentials(\''.$row->Username.'\', \''.$row->Password.'\', \''.$row->Type.'\', \''.$row->AgencyID.'\', \''.$row->Status.'\')">
            Update
            </button>
            <button type="button" id="'.$row->Username.'" class="btn btn-xs btn-danger btn_delete" >
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