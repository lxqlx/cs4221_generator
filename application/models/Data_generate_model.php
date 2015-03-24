<?php
define("G_BUFF_SIZE", 1000);

class Data_generate_model extends CI_Model {
	var $file_name;
	var $text;

	public function __construct() {
		$this->load->database();
		$this->load->helper('file');
		$this->load->model('regional_generator');
		$this->load->model('free_generator');
	}

	public function download() {
		$this->load->helper('download');
		//$data = file_get_contents($this->file_name); // Read the file's contents
		$name = "data.sql";


		$this->regional_generator->destroy_tables();
		force_download($name, $this->text);
	}
	
	public function generate() {
		//geting data from webpage
		$amount = $this->get_amount();
		$countries = $this->get_countries(); 
		$regional_unique_types = $this->get_regional_unique_types(); 
		$regional_normal_types = $this->get_regional_normal_types(); 
		$free_unique_types = $this->get_free_unique_types(); 
		$free_normal_types = $this->get_free_normal_types();

		//set_up generator models
		$this->regional_generator->set_types($regional_unique_types, $regional_normal_types, $countries, $amount);
		$this->free_generator->set_types($free_unique_types, $free_normal_types, $amount);
		//generate datas and insert to database
		$this->generate_and_insert($amount);
	}

	private function generate_and_insert($amount) {
		$get_start = 1;
		$get_end = 0;
		while($amount > 0){
			$size = min($amount, G_BUFF_SIZE);
			$get_end = $get_start + $size;
			$regional_data = $this->regional_generator->get_data($size);//class method
			$free_data = $this->free_generator->get_data($size);//class method
			$this->write_to_file($get_start, $get_end, $regional_data, $free_data);//function to do

			$amount -= $size;
			$get_start = $get_end;
		}
	}

	private function write_to_file($start, $end, $regional_data, $free_data) {
		$this->file_name = uniqid();
		$this->file_name .= ".sql";
		for($i=$start; $i<$end; $i++) {
			$txt = "";
			if($regional_data === NULL && $free_data === NULL) $data = array();
			else if($regional_data === NULL) $data = $free_data[$i];
			else if($free_data === NULL) $data = $regional_data[$i];
			else $data = $regional_data[$i] + $free_data[$i];
			$size = count($data);
			for($j = 1; $j <= $size ; $j++){
				$txt .= $data[$j].",";
			}
			$txt .="\n";
			$this->text .= $txt;
			//echo $txt;
			//write_file($this->file_name, $txt);
		}
	}
	
	private function get_amount() {
		//return $_POST['amount'];
		return 100;
	}
	private function get_countries() {
		return array('China', 'Japan', 'Malaysia');
	}
	private function get_regional_unique_types() {
		return array();
	}
	private function get_regional_normal_types() {
		return array(1 => array("datatype"=>"EMAIL"), 2 => array("datatype"=>"PHONE"),3 => array("datatype"=>"NAME"), 4 => array("datatype"=>"COUNTRY"));
	}
	private function get_free_unique_types() {
		return array();
	}
	private function get_free_normal_types() {
		return array();
	}

	
}
?>
