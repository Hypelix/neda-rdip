<?php 
class model_investment_summary EXTENDS CI_Model{

	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
	}

	public function aggregate_rdip_projects($year=null, $rdip_ml_ID=null){
		$query = $this->db->query("SELECT agency.Name, SUM(prog_proj.Total_Inv_Cost) AS Total_Inv_Cost FROM prog_proj 
			INNER JOIN project_chapter ON prog_proj.ID=project_chapter.prog_proj_ID
			INNER JOIN rdip_ml ON project_chapter.rdip_ml_ID=rdip_ml.ID
			INNER JOIN agency ON prog_proj.AgencyID=agency.AgencyID
			WHERE rdip_ml.Year='".$year."' AND project_chapter.rdip_ml_ID='".$rdip_ml_ID."'
			GROUP BY prog_proj.AgencyID");
		return $query->result();
	}

	public function total_budget($year=null, $rdip_ml_ID=null){
		$query = $this->db->query("SELECT SUM(prog_proj.Total_Inv_Cost) AS Total FROM prog_proj 
			INNER JOIN project_chapter ON prog_proj.ID=project_chapter.prog_proj_ID
			INNER JOIN rdip_ml ON project_chapter.rdip_ml_ID=rdip_ml.ID
			WHERE rdip_ml.Year='".$year."' AND project_chapter.rdip_ml_ID='".$rdip_ml_ID."'");
			//if only one row, use this. This will be used as obj
		return $query->row();
	}

	public function alvin($year=null){
		// $query = $this->db->query("SELECT agency.Name, prog_proj.Total_Inv_Cost AS Total_Inv_Cost, prog_proj.Title, project_chapter.rdip_ml_ID, rdip_ml.Chap_Title, rdip_ml.Chap_No, prog_proj.Prio_No FROM prog_proj 
		// 	INNER JOIN project_chapter ON prog_proj.ID=project_chapter.prog_proj_ID
		// 	INNER JOIN rdip_ml ON project_chapter.rdip_ml_ID=rdip_ml.ID
		// 	INNER JOIN agency ON prog_proj.AgencyID=agency.AgencyID
		// 	WHERE rdip_ml.Year='".$year."'");
		$query = $this->db->query("SELECT agency.Name, prog_proj.Total_Inv_Cost AS Total_Inv_Cost, prog_proj.Title, project_chapter.rdip_ml_ID, rdip_ml.Chap_Title, rdip_ml.Chap_No, prog_proj.Prio_No FROM prog_proj 
			INNER JOIN project_chapter ON prog_proj.ID=project_chapter.prog_proj_ID
			INNER JOIN rdip_ml ON project_chapter.rdip_ml_ID=rdip_ml.ID
			INNER JOIN agency ON prog_proj.AgencyID=agency.AgencyID
			WHERE rdip_ml.Year='".$year."' ORDER BY rdip_ml.ID ASC, agency.Name ASC");
		return $query->result_array();
	}

}