<?php 
class controller_investment_summary EXTENDS CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('model_RDIP/model_investment_summary');
		$this->load->model('model_RDIP/model_project');
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
		$this->load->view('view_RDIP/investment_summary', $result);
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
					$output.='<div class="table-responsive"><table class="table table-hover table-bordered" id="id_chapters">
					<thead>
					<tr>
					<th width="10%">'.$row->ID.'</th>
					<th width="90%" colspan="3">Chapter '.$row->Chap_No.": ".$row->Chap_Title.'</th>
					<tr>
					<tr>
					<th width="10%">RLA/SUC/LGU</th>
					<th width="20%">TOTAL COST (in M PHP)</th>
					<th width="15%">SHARE (IN %)</th>
					<th width="55%">MAJOR PAPS</th>
					<tr>
					</thead>
					<tbody>';
					$result['content']=$this->model_investment_summary->aggregate_rdip_projects($this->input->post('Year'),$row->ID);
					$total_budget = $this->model_investment_summary->total_budget($this->input->post('Year'),$row->ID);
					foreach ($result['content'] as $key) {
						$output.='<tr>
						<td>'.$key->Name.'</td>
						<td align="right">'.$key->Total_Inv_Cost.'</td>
						<td align="right">'.round(($key->Total_Inv_Cost/$total_budget->Total)*(100),2).'</td>
						<td></td>
						</tr>';
					}
					$output.='<tr>
					<td style="font-weight: 900;">TOTAL</td>
					<td align="right" style="font-weight: 900;">'.$total_budget->Total.'</td>
					<td align="right" style="font-weight: 900;">100</td>
					<td></td>
					</tr>';
					$output.=	'</tbody><tfoot></tfoot>
					</table></div>';
				}

				echo $output;
			}
			else{
				print_r($this->db->error());
			}
		}
	}

	public function alvin(){
		$result = $this->model_investment_summary->alvin($this->input->post('Year'));
		$output = '';
		$temporary_array = array();
		
			//Formatting of needed data
		foreach($result as $row)
		{
			$temporary_array[$row["rdip_ml_ID"]]["Chap_Title"] = $row["Chap_Title"];
			$temporary_array[$row["rdip_ml_ID"]]["Chap_No"] = $row["Chap_No"];
			$temporary_array[$row["rdip_ml_ID"]]["row"][$row["Name"]]["Total_Inv_Cost"][] = $row["Total_Inv_Cost"];
			if($row["Prio_No"]=="1"){
				$temporary_array[$row["rdip_ml_ID"]]["row"][$row["Name"]]["Title"][] = $row["Title"];
			}
		}

			//Generation
		foreach($temporary_array as $key => $rows)
		{
			$output .= '<table class="table table-hover table-responsive" border="3">
			<thead>
			<tr>
			<th width="10%"></th>
			<th width="90%" colspan="3">Chapter ' . $rows["Chap_No"] . ': ' . $rows["Chap_Title"] . '</th>
			<tr>
			<tr>
			<th width="10%">RLA/SUC/LGU</th>
			<th width="20%">TOTAL COST (in M PHP)</th>
			<th width="15%">SHARE (IN %)</th>
			<th width="55%">MAJOR PAPS</th>
			<tr>
			</thead>
			<tbody>';

			$total_budget = $this->model_investment_summary->total_budget($this->input->post('Year'), $key);

			foreach($rows["row"] as $agency => $data){
				$sum = doubleval(array_sum($data["Total_Inv_Cost"]));
				$output.='<tr>
				<td>'.$agency.'</td>
				<td align="right">'.$sum.'</td>
				<td align="right">'.round(($sum/$total_budget->Total)*(100),2).'</td>';
				if(isset($data["Title"])){
					$output.='<td>- '.implode("<br>- ", $data["Title"]).'</td>';	
				}
				else{
					$output.='<td></td>';		
				}
				$output.='</tr>';
			}

			$output.='<tr>
			<td style="font-weight: 900;">TOTAL</td>
			<td align="right" style="font-weight: 900;">'.$total_budget->Total.'</td>
			<td align="right" style="font-weight: 900;">100</td>
			<td></td>
			</tr>';
			$output.='</tbody>
			</table>';
		}
		echo $output;
	}

}