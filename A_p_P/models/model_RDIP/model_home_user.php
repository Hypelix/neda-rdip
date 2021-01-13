<?php
class model_home_user EXTENDS CI_Model{

	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
            //date_default_timezone_set('Asia/Manila');
	}

	public function get_projects($year=null, $chapter=null){
		//$query = $this->db->query("SELECT * FROM prog_proj");
		//$query = $this->db->query("SELECT Title, Prog_Proj_Brief, agency.Name AS Agency, funding_src.Name AS FS, Spatial_Coverage, Total_Inv_Cost, Latitude, Longitude FROM prog_proj INNER JOIN agency ON prog_proj.AgencyID=agency.AgencyID INNER JOIN funding_src ON prog_proj.FSID=funding_src.FSID");
		//$query = $this->db->query("SELECT Title, Prog_Proj_Brief, agency.Name AS Agency, funding_src.Name AS FS, Spatial_Coverage, Total_Inv_Cost, Latitude, Longitude FROM prog_proj INNER JOIN agency ON prog_proj.AgencyID=agency.AgencyID INNER JOIN funding_src ON prog_proj.FSID=funding_src.FSID INNER JOIN project_chapter ON prog_proj.ID=project_chapter.prog_proj_ID INNER JOIN rdip_ml ON project_chapter.rdip_ml_ID=rdip_ml.ID WHERE rdip_ml.Year='2017-2022'");
		$query = $this->db->query("SELECT Title, Prog_Proj_Brief, agency.Name AS Agency, funding_src.Name AS FS, Spatial_Coverage, Total_Inv_Cost, Latitude, Longitude FROM prog_proj INNER JOIN agency ON prog_proj.AgencyID=agency.AgencyID INNER JOIN funding_src ON prog_proj.FSID=funding_src.FSID INNER JOIN project_chapter ON prog_proj.ID=project_chapter.prog_proj_ID INNER JOIN rdip_ml ON project_chapter.rdip_ml_ID=rdip_ml.ID WHERE rdip_ml.Year='".$year."' AND rdip_ml.ID='".$chapter."'");
		return $query->result();
		//return "g";
	}

}