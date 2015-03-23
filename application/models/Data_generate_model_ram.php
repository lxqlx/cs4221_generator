<?php
define("G_BUFF_SIZE", 1000);

class Data_generate_model_ram extends CI_Model {
	var $file_name;
	var $text;

	public function __construct() {
		$this->load->database();
		$this->load->helper('file');
		$this->load->model('regional_generator_ram');
		$this->load->model('free_generator');
	}

	public function download() {
		$this->load->helper('download');
		//$data = file_get_contents($this->file_name); // Read the file's contents
		$name = "data.sql";


		$this->regional_generator_ram->destroy_tables();
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
		$this->regional_generator_ram->set_types($regional_unique_types, $regional_normal_types, $countries, $amount);
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
			$regional_data = $this->regional_generator_ram->get_data($size);//class method
			$free_data = $this->free_generator->get_data($size);//class method
			$this->write_to_file($get_start, $get_end, $regional_data, $free_data);//function to do

			$amount -= $size;
			$get_start = $get_end;
		}
	}

	private function write_to_file($start, $end, $regional_data, $free_data) {
		$this->file_name = uniqid();
		$this->file_name .= ".sql";

		if($regional_data === NULL && $free_data === NULL) $data = array();
		else if($regional_data === NULL) $data = $free_data;
		else if($free_data === NULL) $data = $regional_data;
		else $data = $regional_data + $free_data;
		$size = count($data);

		for($i=$start; $i<$end; $i++) {
			$txt = "";
			for($j = 1; $j <= $size ; $j++){
				$txt .= $data[$j][$i].",";
			}
			$txt .="\n";
			$this->text .= $txt;
			//echo $txt;
			//write_file($this->file_name, $txt);
		}
	}
	
	private function get_amount() {
		//return $_POST['amount'];
		return 10000;
	}
	private function get_countries() {
		return array('China', 'Japan', 'Malaysia');
	}
	private function get_regional_unique_types() {
		return array(1 => array("datatype"=>"EMAIL"), 2 => array("datatype"=>"PHONE"),  3 => array("datatype"=>"NAME"));
	}
	private function get_regional_normal_types() {
		return array( 4 => array("datatype"=>"COUNTRY"));
	}
	private function get_free_unique_types() {
		return array( 5=> array('datatype' =>'INTEGER'),
						7 => array('datatype' =>'NAME'),
						8 => array('datatype' => 'DATE'));
	}
	private function get_free_normal_types() {
		return array(6 => array('datatype' => 'INTEGER', 'low' => 2, 'high' => 200, 'step' => 2, 'distribution' => 'uniform',
			'std_dev' => '9'),
						9 => array('datatype' => 'PHONE'));
	}

	
}
?>
