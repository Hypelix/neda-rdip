<?php 
class model_users_list EXTENDS CI_Model{

  public function __construct(){
   $this->load->database();
   $this->load->helper('url');
}

public function get_agencies(){
  $query = $this->db->query("SELECT * FROM agency");
  return $query->result();
}

public function get_all_users(){
  $query = $this->db->query("SELECT * FROM user_record");
  return $query->result();
}

public function get_users(){
  $query = $this->db->query("SELECT * FROM user_record LIMIT 10");
  return $query->result();
}

public function paginate_user_list($page){
  $page -= 1;
  $page *= 10;
  $query = $this->db->query("SELECT * FROM user_record LIMIT 10 OFFSET ".$page);
  return $query->result();
}

public function set_user(){
  $data = array(
      'Username' => $this->input->post('Username'),
      'Password' => $this->input->post('Password'),
      'Type' => $this->input->post('Type'),
      'AgencyID' => $this->input->post('Agency'),
      'Status' => $this->input->post('Status')
  );

  return $this->db->insert('user_record', $data);
}

public function update_user(){
  $data = array(
	    		//'Old_Username' => $this->input->post('Old_Username'),
      'Username' => $this->input->post('Username'),
      'Password' => $this->input->post('Password'),
      'Type' => $this->input->post('Type'),
      'AgencyID' => $this->input->post('Agency'),
      'Status' => $this->input->post('Status')
  );

  $this->db->set($data);
  $this->db->where('Username', $this->input->post('Old_Username'));
  return $this->db->update('user_record');
}

public function delete_user($Username){
  $this->db->where('Username', $Username);
  return $this->db->delete('user_record');
}
}