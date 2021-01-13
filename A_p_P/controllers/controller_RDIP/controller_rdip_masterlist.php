<?php 
class controller_rdip_masterlist EXTENDS CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('model_RDIP/model_rdip_masterlist');
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
		$this->load->view('view_RDIP/rdip_masterlist');
		$this->load->view('view_RDIP/footer');
	}

	public function getData(){
		//retrieve all post values from DOM's datatable
		$data = $this->input->post();

		//pass to the model
		$output = $this->model_rdip_masterlist->query(
			$data['length'],
			$data['start'],
			$data['order'],
			$data['search']['value']
		);

		//format and return to DOM's datatable
		//A. format
		$all_masterlist = $this->model_rdip_masterlist->select_all_masterlist();
		$result=array(
			"draw" => $data["draw"],
			"data" => $output,
			"recordsTotal" => count($all_masterlist),
			"recordsFiltered" => $data['search']['value'] != "" ? count($output) : count($all_masterlist)
		);

		//B. return
		echo json_encode($result);
	}

        // public function getData(){
        // 	//$requestData = $_REQUEST;
        // 	$requestData = $_POST;


	       //  //declare coloum for shorting
	       //  $columns = array(
	       //      0 => 'ID',
	       //      1 => 'Chap_No',
	       //      2 => 'Chap_Title',
	       //      3 => 'Chap_Desc',
	       //      4 => 'Year'
	       //  );

	       //  //write query for get data
	       //  $sql = "SELECT * FROM rdip_ml  where 1=1";
	       //  $query = $this->model_rdip_masterlist->query($sql);
	       //  $totalData = count($query);
	       //  $totalFiltered = $totalData;

	       //  //define column for searching
	       //  if (!empty($requestData['search']['value'])) {
	       //      $sql .= " AND (  Chap_No LIKE '" . $requestData['search']['value'] . "%' ";
	       //      $sql .= " OR  Chap_Title LIKE '" . $requestData['search']['value'] . "%' ";
	       //      $sql .= " OR  Chap_Desc LIKE '" . $requestData['search']['value'] . "%' ";
	       //      $sql .= " OR  Year LIKE '" . $requestData['search']['value'] . "%' )";
	       //  }
	       //  $query = $this->model_rdip_masterlist->query($sql);
	       //  $totalFiltered = count($query);

	       //  //ordering clause //by default  0th coloumn asc
	       //  $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";  // adding length
	       //  $query = $this->model_rdip_masterlist->query($sql);

	       //  $data = array();

	       //  $cnt = $requestData['start'] + 1;
	       //  foreach ($query as $dt) {
	       //      $nestedData = array();
	       //      $nestedData['rowId'] = $dt['ID'];
	       //      $nestedData[] = $cnt++;
	       //      $nestedData[] = $dt['Chap_No'];
	       //      $nestedData[] = $dt['Chap_Title'];
	       //      $nestedData[] = $dt['Chap_Desc'];
	       //      $nestedData[] = $dt['Year'];
	       //      $nestedData[] = "";
	       //      $data[] = $nestedData;
	       //  }

	       //  //create json in datatable form
	       //  $json_data = array(
	       //      "draw" => intval($requestData['draw']),
	       //      "recordsTotal" => intval($totalData),
	       //      "recordsFiltered" => intval($totalFiltered),
	       //      "data" => $data
	       //  );

	       //  echo json_encode($json_data);
        // }

	public function add_masterlist(){
		$this->form_validation->set_rules('Chap_No', 'Chap_No', 'required|trim');
		$this->form_validation->set_rules('Chap_Title', 'Chap_Title', 'required|trim');
		$this->form_validation->set_rules('Chap_Desc', 'Chap_Desc', 'required|trim');
		$this->form_validation->set_rules('Year', 'Year', 'required|trim');

		if ($this->form_validation->run() === FALSE){
			echo json_encode(array("success" => false, "message" => validation_errors()));
		}
		else{
			if($this->model_rdip_masterlist->add_masterlist()){
				$credentials = $this->model_logs->retrieve_credentials(1,"rdip_ml","ID",null);
				if($this->model_logs->RDIP_sys_log($_SESSION['UN'],"rdip masterlist","create","true","Record: ".json_encode($credentials))){
					echo json_encode(array("success" => true, "message" => "Adding successful!"));
				}
			}
			else{
				print_r($this->db->error());
			}
		}
	}

	public function update_masterlist(){
		$this->form_validation->set_rules('Chap_No', 'Chap_No', 'required|trim');
		$this->form_validation->set_rules('Chap_Title', 'Chap_Title', 'required|trim');
		$this->form_validation->set_rules('Chap_Desc', 'Chap_Desc', 'required|trim');
		$this->form_validation->set_rules('Year', 'Year', 'required|trim');

		if ($this->form_validation->run() === FALSE){
			echo json_encode(array("success" => false, "message" => validation_errors()));
		}
		else{
			$credentials = $this->model_logs->retrieve_credentials(0,"rdip_ml","ID",$this->input->post('ID'));
			if($this->model_rdip_masterlist->update_masterlist()){
				if($this->model_logs->RDIP_sys_log($_SESSION['UN'],"rdip masterlist","update","true","Old Record: ".json_encode($credentials)." ----- New Record:".json_encode($this->input->post()))){
					echo json_encode(array("success" => true, "message" => "Editing successful!"));
				}
			}
			else{
				print_r($this->db->error());
			}
		}
	}

}