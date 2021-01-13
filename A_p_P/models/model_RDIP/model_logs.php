<?php 
class model_logs EXTENDS CI_Model{

	public function __construct(){
		$this->load->database();
		$this->load->helper('url');
	}

	public function RDIP_sys_log($user,$module,$transaction,$success,$log_msg) {
		//set the timezone
		date_default_timezone_set('Asia/Manila');

		//identify the directory and the folder where the log files will be stored
		$log_filename = $_SERVER['DOCUMENT_ROOT']."/log";
		if (!file_exists($log_filename)){
        	// create directory/folder uploads.
			mkdir($log_filename, 0777, true);
		}

		//set the filename of the log file with the complete directory
		$log_file_data = $log_filename.'/log_' . date('d-M-Y') . '.log';

		//append contents to the log file
		file_put_contents($log_file_data, date("H:i:s",time()). "	" . $user . "	<" . $module . ">	" . $transaction . "	->	" . $success . "	....." . $log_msg . "\n", FILE_APPEND);

		return true;
	}

	public function retrieve_credentials($transaction=0,$table=null,$column=null,$identifier=null){
		if($transaction==1){
			//if the transaction is create, this will be executed
			$query = $this->db->query("SELECT * FROM ".$table." WHERE ".$column." = (SELECT MAX(".$column.") FROM ".$table.")");
		}
		else{
			//if the transaction is either update or delete, this will be executed
			$query = $this->db->query("SELECT * FROM ".$table." WHERE ".$column."=".$identifier);
		}
		return $query->result();
	}

}