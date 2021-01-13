<?php 
class model_rdip_masterlist EXTENDS CI_Model{

  public function __construct(){
     parent::__construct();
     $this->load->database();
     $this->load->helper('url');
 }

 function query($limit=null, $offset=0, $order=array(), $search=""){
  $columns = array(
     "ID",
     "Chap_No",
     "Chap_Title",
     "Chap_Desc",
     "Year"
 );

  $cols_orderable = array(
     0 => "ID",
     1 => "Chap_No",
     4 => "Year"
 );

  $this->db->select($columns)
  ->from('rdip_ml')
  ->limit($limit, $offset)
  ->order_by($cols_orderable[$order[0]["column"]], $order[0]["dir"]);

  if($search != ""){
     $this->db->group_start();
     foreach ($columns as $key => $value) {
        $this->db->or_like($value, $search);
    }
    $this->db->group_end();
}

$query = $this->db->get();

return $query->result_array();
}

	    // function query($sql){
	    //     $data = $this->db->query($sql);
	    //     return $data->result_array();
	    // }

public function select_all_masterlist(){
    return $this->db->get('rdip_ml')->result_array();
}

public function add_masterlist(){
  $data = array(
      'Chap_No' => $this->input->post('Chap_No'),
      'Chap_Title' => $this->input->post('Chap_Title'),
      'Chap_Desc' => $this->input->post('Chap_Desc'),
      'Year' => $this->input->post('Year')
  );

  return $this->db->insert('rdip_ml', $data);
}

public function update_masterlist(){
    $data = array(
                //'Old_Username' => $this->input->post('Old_Username'),
        'Chap_No' => $this->input->post('Chap_No'),
        'Chap_Title' => $this->input->post('Chap_Title'),
        'Chap_Desc' => $this->input->post('Chap_Desc'),
        'Year' => $this->input->post('Year')
    );

    $this->db->set($data);
    $this->db->where('ID', $this->input->post('ID'));
    return $this->db->update('rdip_ml');
}

}