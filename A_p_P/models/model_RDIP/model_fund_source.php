<?php 
	class model_fund_source EXTENDS CI_Model{

		public function __construct(){
			$this->load->database();
			$this->load->helper('url');
    	}

    	public function search_all_fund_source(){
    		$query = $this->db->query("SELECT * FROM funding_src");
    		return $query->result();
    	}

    	public function search_fund_source(){
    		$query = $this->db->query("SELECT * FROM funding_src LIMIT 10");
    		return $query->result();
    	}

    	public function paginate_fund_source($page){
    		$page -= 1;
    		$page *= 10;
    		$query = $this->db->query("SELECT * FROM funding_src LIMIT 10 OFFSET ".$page);
    		return $query->result();
    	}

    	public function add_fund_source(){
	    	$data = array(
		        'Name' => $this->input->post('Name'),
		        'Description' => $this->input->post('Description')
		    );

		    return $this->db->insert('funding_src', $data);
    	}

    	public function update_fund_source(){
	    	$data = array(
	    		//'Old_Username' => $this->input->post('Old_Username'),
		        'Name' => $this->input->post('Name'),
		        'Description' => $this->input->post('Description')
		    );

		    $this->db->set($data);
		    $this->db->where('FSID', $this->input->post('FSID'));
		    return $this->db->update('funding_src');
    	}

    	public function delete_fund_source($FSID){
    		$this->db->where('FSID', $FSID);
    		return $this->db->delete('funding_src');
    	}

	}