<?php 
class model_home_admin EXTENDS CI_Model{

	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
	}

	public function generate_chart1($year=null){
		$query = $this->db->query("SELECT agency.Name, COUNT(*) AS projects FROM prog_proj INNER JOIN project_chapter ON prog_proj.ID=project_chapter.prog_proj_ID INNER JOIN rdip_ml ON project_chapter.rdip_ml_ID=rdip_ml.ID INNER JOIN agency ON prog_proj.AgencyID=agency.AgencyID WHERE rdip_ml.Year='".$year."' GROUP BY agency.Name");
		return $query->result();
	}

	public function generate_chart2($year=null,$chapter=null){
		$query = $this->db->query("SELECT agency.Name, COUNT(*) AS projects FROM prog_proj INNER JOIN project_chapter ON prog_proj.ID=project_chapter.prog_proj_ID INNER JOIN rdip_ml ON project_chapter.rdip_ml_ID=rdip_ml.ID INNER JOIN agency ON prog_proj.AgencyID=agency.AgencyID WHERE rdip_ml.Year='".$year."' AND rdip_ml.ID=".$chapter." GROUP BY agency.Name");
		return $query->result();	
	}

}