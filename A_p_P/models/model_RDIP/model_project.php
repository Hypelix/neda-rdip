<?php
class model_project EXTENDS CI_Model{

  public function __construct(){
     parent::__construct();
     $this->load->database();
     $this->load->helper('url');
     date_default_timezone_set('Asia/Manila');
 }

 public function get_rdip_masterlist_year(){
  $query = $this->db->query("SELECT DISTINCT(Year) FROM rdip_ml ORDER BY Year DESC");
  return $query->result();
}

public function get_rdip_masterlist_chapter($Year){
  $query = $this->db->query("SELECT ID, Chap_No, Chap_Title FROM rdip_ml WHERE YEAR='".$Year."'");
  return $query->result();
}

function getData($limit=null, $offset=0, $order=array(), $search="", $year=null, $chapters=null){
  $columns = array(
     "prog_proj.ID",
     "Title",
     "Prog_Proj_Brief",
     "prog_proj.AgencyID",
     "Spatial_Coverage",
     "prog_proj.FSID",
     "Year_1",
     "Year_2",
     "Year_3",
     "Year_4",
     "Year_5",
     "Year_6",
     "Total_Inv_Cost",
     "Latitude",
     "Longitude",
    			"Prio_No"//,
                // "Status",
                // "Remarks"
    		);

  $columns_searchable = $columns;
  $columns_searchable[] = "agency.Name";
  $columns_searchable[] = "funding_src.Name";

  $columns[] = "agency.Name AS agency_Name";
  $columns[] = "funding_src.Name AS funding_src_Name";

  $cols_orderable = array(
    			//0 => "ID",
     0 => "Title",
    			11 => "Total_Inv_Cost"//,
    			//13 => "Prio_No"
    		);

            //if user is admin or super admin algo
  if($_SESSION['user_type']==2){
    $this->db->select($columns)
    ->from('prog_proj')
                    //
    ->join('project_chapter', 'prog_proj.ID = project_chapter.prog_proj_ID','inner')
    ->join('rdip_ml', 'project_chapter.rdip_ml_ID = rdip_ml.ID','inner')
    ->join('agency', 'prog_proj.AgencyID = agency.AgencyID', 'inner')
    ->join('funding_src', 'prog_proj.FSID = funding_src.FSID', 'inner')
                    //
    ->limit($limit, $offset)
    ->order_by($cols_orderable[$order[0]["column"]], $order[0]["dir"])
                    ->where('prog_proj.AgencyID',$_SESSION['user_agency'])//;
                    ->where('rdip_ml.Year',$year)//;
                    //to be added
                    ->where('project_chapter.rdip_ml_ID',$chapters);
                }
                else{
                    $this->db->select($columns)
                    ->from('prog_proj')
                    ->join('project_chapter', 'prog_proj.ID = project_chapter.prog_proj_ID','inner')
                    ->join('rdip_ml', 'project_chapter.rdip_ml_ID = rdip_ml.ID','inner')
                    ->join('agency', 'prog_proj.AgencyID = agency.AgencyID', 'inner')
                    ->join('funding_src', 'prog_proj.FSID = funding_src.FSID', 'inner')
                    ->limit($limit, $offset)
                    ->order_by($cols_orderable[$order[0]["column"]], $order[0]["dir"])
                    ->where('rdip_ml.Year',$year)//;
                    //to be added
                    ->where('project_chapter.rdip_ml_ID',$chapters);
                }

            //kapag papalitan mo Agency at FSID field, may kailangan ka ring palitan dito...
                if($search != ""){
                 $this->db->group_start();
                 foreach ($columns_searchable as $key => $value) {
                    $this->db->or_like($value, $search, "BOTH", false);
                }
                $this->db->group_end();
            }

            $query = $this->db->get();

            return $query->result_array();
        }

        public function select_all_project(){
            return $this->db->get('prog_proj')->result_array();
        }

        public function add_project(){
            $data = array(
                'Title' => $this->input->post('Title'),
                'Prog_Proj_Brief' => $this->input->post('Prog_Proj_Brief'),
                'AgencyID' => $this->input->post('AgencyID'),
                'Spatial_Coverage' => $this->input->post('Spatial_Coverage'),
                'FSID' => $this->input->post('FSID'),
                'Year_1' => $this->input->post('Year_1'),
                'Year_2' => $this->input->post('Year_2'),
                'Year_3' => $this->input->post('Year_3'),
                'Year_4' => $this->input->post('Year_4'),
                'Year_5' => $this->input->post('Year_5'),
                'Year_6' => $this->input->post('Year_6'),
                'Total_Inv_Cost' => $this->input->post('Total_Inv_Cost'),
                'Latitude' => $this->input->post('Latitude'),
                'Longitude' => $this->input->post('Longitude'),
                'Prio_No' => $this->input->post('Prio_No')//,
                // 'Status' => $this->input->post('Status'),
                // 'Remarks' => $this->input->post('Remarks')
            );

            return $this->db->insert('prog_proj', $data);
        }

        public function update_project(){
            $data = array(
                'Title' => $this->input->post('Title'),
                'Prog_Proj_Brief' => $this->input->post('Prog_Proj_Brief'),
                'AgencyID' => $this->input->post('AgencyID'),
                'Spatial_Coverage' => $this->input->post('Spatial_Coverage'),
                'FSID' => $this->input->post('FSID'),
                'Year_1' => $this->input->post('Year_1'),
                'Year_2' => $this->input->post('Year_2'),
                'Year_3' => $this->input->post('Year_3'),
                'Year_4' => $this->input->post('Year_4'),
                'Year_5' => $this->input->post('Year_5'),
                'Year_6' => $this->input->post('Year_6'),
                'Total_Inv_Cost' => $this->input->post('Total_Inv_Cost'),
                'Latitude' => $this->input->post('Latitude'),
                'Longitude' => $this->input->post('Longitude'),
                'Prio_No' => $this->input->post('Prio_No')//,
                // 'Status' => $this->input->post('Status'),
                // 'Remarks' => $this->input->post('Remarks')
            );

            $this->db->set($data);
            $this->db->where('ID', $this->input->post('ID'));
            return $this->db->update('prog_proj');
        }

        public function get_recent_project_ID(){
            $query = $this->db->query("SELECT MAX(ID) AS ID FROM prog_proj");
            return $query->row_array();
        }

        public function add_project_chapter($rdip_ml_ID,$prog_proj_ID){
            $data = array(
                'rdip_ml_ID' => $rdip_ml_ID,
                'prog_proj_ID' => $prog_proj_ID
            );

            return $this->db->insert('project_chapter', $data);
        }

        public function add_prog_proj_status(){
            $data = array(
                'Status' => $this->input->post('Status'),
                'Remarks' => $this->input->post('Remarks'),
                'Date' => date("Y-m-d H:i:s"),
                'prog_proj_ID' => $this->input->post('prog_proj_ID')
            );

            return $this->db->insert('prog_proj_status', $data);
        }

        public function get_prog_proj_status($prog_proj_ID){
            $query = $this->db->query("SELECT * FROM prog_proj_status WHERE prog_proj_ID='".$prog_proj_ID."'");
            return $query->result();
        }

        public function update_prog_proj_status(){
            $data = array(
                'Code' => $this->input->post('Code'),
                'Status' => $this->input->post('Status'),
                'Remarks' => $this->input->post('Remarks')
            );

            $this->db->set($data);
            $this->db->where('Code', $this->input->post('Code'));
            return $this->db->update('prog_proj_status');
        }

    }