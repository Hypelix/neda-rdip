<?php 
class model_agencies EXTENDS CI_Model{

  public function __construct(){
     parent::__construct();
     $this->load->database();
     $this->load->helper('url');
 }

 public function search_all_agencies(){
  $query = $this->db->query("SELECT * FROM agency");
  return $query->result();
}

public function search_agencies(){
  $query = $this->db->query("SELECT * FROM agency LIMIT 10");
  return $query->result();
}

public function paginate_agencies($page){
  $page -= 1;
  $page *= 10;
  $query = $this->db->query("SELECT * FROM agency LIMIT 10 OFFSET ".$page);
  return $query->result();
}

public function add_agency(){
  $data = array(
      'Name' => $this->input->post('Name'),
      'Description' => $this->input->post('Description')
  );

  return $this->db->insert('agency', $data);
}

public function update_agency(){
  $data = array(
	    		//'Old_Username' => $this->input->post('Old_Username'),
      'Name' => $this->input->post('Name'),
      'Description' => $this->input->post('Description')
  );

  $this->db->set($data);
  $this->db->where('AgencyID', $this->input->post('AgencyID'));
  return $this->db->update('agency');
}

public function delete_agency($AgencyID){
  $this->db->where('AgencyID', $AgencyID);
  return $this->db->delete('agency');
}

}