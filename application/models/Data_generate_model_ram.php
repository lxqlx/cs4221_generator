<?php
define("G_BUFF_SIZE", 1000);

class Data_generate_model_ram extends CI_Model {
	var $file_name;
	var $text;

	var $all_types;
	var $r_u_types;
	var $r_n_types;
	var $f_u_types;
	var $f_n_types;

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
		$this->divide_types();
		$amount = $this->get_amount();
		$countries = $this->get_countries(); 
		$regional_unique_types = $this->get_regional_unique_types(); 
		$regional_normal_types = $this->get_regional_normal_types(); 
		$free_unique_types = $this->get_free_unique_types(); 
		$free_normal_types = $this->get_free_normal_types();

		die();
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

	private function group_data() {
		$this->all_types = array();
		$datas = $this->input->post();
		unset($datas['countries']);
		unset($datas['rows']);
		
		foreach ($datas as $key => $value) {
			$a = preg_split('#(?=[a-z])(?<=\d)#i', $key);
			$name = $a[0];
			$col = $a[1];
			if (!isset($this->all_types[$col])) {
				$this->all_types[$col] = array();
			}
			$this->all_types[$col][$name] = $value;
		}
	}

	private function divide_types() {
		$this->group_data();

		foreach ($this->$all_types as $key => $value) {
			switch ($value['datatype']) {
				case 'country':
					$this->r_n_types[$key] = $value;
					break;

				case 'name_regional':
					if ($value['constraint'] !== 'notnull'){
						$this->r_u_types[$key] = $value;
					}else{
						$this->r_n_types[$key] = $value;
					}
					break;

				case 'phone_regional':
					if ($value['constraint'] !== 'notnull'){
						$this->r_u_types[$key] = $value;
					}else{
						$this->r_n_types[$key] = $value;
					}
					break;

				case 'email_regional':
					if ($value['constraint'] !== 'notnull'){
						$this->r_u_types[$key] = $value;
					}else{
						$this->r_n_types[$key] = $value;
					}
					break;

				case 'name':
					if ($value['constraint'] !== 'notnull'){
						$this->f_u_types[$key] = $value;
					}else{
						$this->f_n_types[$key] = $value;
					}
					break;

				case 'phone':
					if ($value['constraint'] !== 'notnull'){
						$this->f_u_types[$key] = $value;
					}else{
						$this->f_n_types[$key] = $value;
					}
					break;

				case 'email':
					if ($value['constraint'] !== 'notnull'){
						$this->f_u_types[$key] = $value;
					}else{
						$this->f_n_types[$key] = $value;
					}
					break;

				case 'gender':
					$this->f_n_types[$key] = $value;
					break;

				case 'date':
					if ($value['constraint'] !== 'notnull'){
						$this->f_u_types[$key] = $value;
					}else{
						$this->f_n_types[$key] = $value;
					}
					break;

				case 'string':
					if ($value['constraint'] !== 'notnull'){
						$this->f_u_types[$key] = $value;
					}else{
						$this->f_n_types[$key] = $value;
					}
					break;

				case 'integer':
					if ($value['constraint'] !== 'notnull'){
						$this->f_u_types[$key] = $value;
					}else{
						$this->f_n_types[$key] = $value;
					}
					break;

				case 'float':
					if ($value['constraint'] !== 'notnull'){
						$this->f_u_types[$key] = $value;
					}else{
						$this->f_n_types[$key] = $value;
					}
					break;
				
				default:
					# code...
					break;
			}
		}
	}
	
	private function get_amount() {
		//return $this->input->post('rows');
		//return 100;
	}
	private function get_countries() {
		if (count($_POST['countries']) === 0) {
			return array('China', 
						'Malaysia',
						'Singapore',
						'United States',
						'United Kingdom',
						'Mexico',
						'Egypt');
		}

		$countries = array();
		foreach ($_POST['countries'] as $value) {
			$countries[] = $value;
		}
		print_r($counties);
		//return $countries;
		//return array('China', 'Japan', 'Malaysia');
	}

	private function get_regional_unique_types() {
		print_r($this->r_u_types);
		//return array(1 => array("datatype"=>"EMAIL"), 2 => array("datatype"=>"PHONE"),  3 => array("datatype"=>"NAME"));
	}
	private function get_regional_normal_types() {
		print_r($this->r_n_types);
		//return array( 4 => array("datatype"=>"COUNTRY"));
	}
	private function get_free_unique_types() {
		print_r($this->f_u_types);
		// return array( 5=> array('datatype' =>'INTEGER'),
		// 				7 => array('datatype' =>'NAME'),
		// 				8 => array('datatype' => 'DATE'));
	}
	private function get_free_normal_types() {
		print_r($this->f_n_types);
		// return array(6 => array('datatype' => 'INTEGER', 'low' => 2, 'high' => 200, 'step' => 2, 'distribution' => 'uniform',
		// 	'std_dev' => '9'),
		// 				9 => array('datatype' => 'GENDER'));
	}

	
}
?>
