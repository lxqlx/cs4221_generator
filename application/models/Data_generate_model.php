<?php
define("G_BUFF_SIZE", 1000);

class Data_generate_model extends CI_Model {
	//array $r_generator;
	//array $f_generator;
	//var 	$amount;
	//array $countries; 
	//array $regional_unique_types; 
	//array $regional_normal_types; 
	//array $free_unique_type; 
	//array $free_normal_types;

	public function __construct() {
		$this->load->database();
		$this->load->model('regional_generator');
		$this->load->model('free_generator');
	}

	public function download() {
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
		$this->regional_generator->set_types($regional_unique_types, $regional_normal_types, $countries);//class to do
		$this->free_generator->set_types($free_unique_types, $free_normal_types);//class to do

		//generate datas and insert to database
		$this->generate_and_insert($amount);

		return TRUE;
	}

	private function generate_and_insert($amount) {
		while($amount > 0){
			$size = min($amount, G_BUFF_SIZE);
			$regional_data = $this->regional_generator->get_data($size);//class method
			$free_data = $this->free_generator->get_data($size);//class method
			$this->insert_and_check($size, $regional_data, $free_data);//function to do

			$amount -= $size;
		}
	}

	private function insert_and_check($size, $regional_data, $free_data) {

	}
	
	private function get_amount() {
		return $_POST['amount'];
	}
	private function get_countries() {
	}
	private function get_regional_unique_types() {
	}
	private function get_regional_normal_types() {
	}
	private function get_free_unique_types() {
	}
	private function get_free_normal_types() {
	}

	
}
?>
