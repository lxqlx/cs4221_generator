<?php
require 'functions.php';
class Regional_generator_ram extends CI_Model {
	var $country_domain;
	var $country_language;
	var $language_ids;
	var $tables;
	var $amount;
	var $c_table;
	var $get_start;
	var $get_end;
	var $u_types;
	var $n_types;
	var $country_codes;

	public function __construct() {
		$this->load->database();
		$this->load->dbforge();
		$this->tables = array();
		$this->get_start = 1;
		$this->get_end = 1;
	}

	public function set_types($unique_types, $normal_types, $countries, $amount) {
		$this->amount = $amount;
		$this->u_types = $unique_types;
		$this->n_types = $normal_types;
		$this->set_random_countries($countries);
		$this->set_country_code($countries);
		$this->create_tables($unique_types);
		$this->preprocess_unique($unique_types);
	}

	public function get_data($size) {
		$this->get_end = $this->get_start + $size;
		$result = array();
		//$unique_datas = $this->get_unique_datas($this->get_start, $this->get_end);
		$normal_datas = $this->get_normal_datas($this->get_start, $this->get_end);
		$unique_datas = $this->get_unique_datas($this->get_start, $this->get_end);

		$result = $normal_datas + $unique_datas;
		$this->get_start = $this->get_end;
		return $result;
	}

	public function destroy_tables(){
		unset($this->c_table);
		unset($this->tables);
	}

	private function get_unique_datas($start, $end) {
		$columns = array();
		foreach ($this->tables as $key => $value) {
			ksort($this->tables[$key]);
			$temp_a = array_slice($this->tables[$key], $start-1, $end-$start, TRUE);
			$columns[$key] = $temp_a;
		}

		return $columns;
	}
	private function get_normal_datas($start, $end) {
		$table_name = $this->c_table;
		// $query = $this->db->query("SELECT entry_id, country_name FROM $table_name 
		// 		WHERE entry_id>=$start and entry_id<$end ORDER BY entry_id");
		//initialize arrays
		$columns = array();
		foreach ($this->n_types as $key => $value) {
			$columns[$key] = array();
		}

		for($i=$start; $i<$end; $i++) {
			$country = $this->c_table[$i];

			foreach ($this->n_types as $key => $value) {
				$columns[$key][$i] = $this->get_single_normal($country, $value);
			}
		}

		return $columns;
	}
	private function get_single_normal($country, $type){
		switch ($type['datatype']) {
			case 'NAME':
				return $this->g_name($country);
				break;

			case 'EMAIL':
				return $this->g_email($country);
				break;

			case 'PHONE':
				return $this->g_phone($country);
				break;
			
			case 'COUNTRY':
				return $country;
				break;

			default:
				# code...
				break;
		}
	}

	private function set_country_code($countries){
		$this->country_codes = array();
		foreach ($countries as $key => $value) {
			$query = $this->db->query("SELECT code,length FROM phone WHERE country='$value'");
			$result = $query->row_array();
			$code= $result['code'];
			$length= $result['length'];
			//print_r($result);
			$this->country_codes[$value] = array('code'=>$code, 'length'=>$length);
		}
	}
	private function set_random_countries($countries){
		
		$this->c_table = array();
		//$mem_table = array();
		//initialize language_ids
		$this->language_ids = array();
		// foreach ($countries as $value) {
		// 	$this->language_id[$value] = array();
		// }
		//set country_language table
		foreach ($countries as $value) {
			$query = $this->db->query("SELECT language FROM country WHERE countryname='$value'");
			$this->country_language[$value] = $query->result();
		}
		//set country_domain table;
		foreach ($countries as $value) {
			$query = $this->db->query("SELECT emaildomain FROM domain WHERE country='$value' OR country='Global'");
			$this->country_domain[$value] = $query->result();
		}

		//generate random countries and insert
		$count = 1;
		while($count <= $this->amount){
			$c_name = $countries[array_rand($countries)];
			// var $row;
			// if (isset($mem_table[$c_name])){
			// 	$row = $mem_table[$c_name][array_rand($mem_table[$c_name])];
			// }else{
			// 	$query_str = "SELECT language FROM country WHERE countryname='$c_name'";

			// 	$query = $this->db->query($query_str);
			// 	$mem_table[$c_name] = $query->result();
			// 	$row = $mem_table[$c_name][array_rand($mem_table[$c_name])];
			// }
			//$this->c_table[$count] = array('country_name'=>$c_name, 'language'=>$row->language);
			$this->c_table[$count] = $c_name;
			$language = $this->get_country_language($c_name);
			if(!isset($this->language_ids[$language])) {
				$this->language_ids[$language] = array();
			}
			array_push($this->language_ids[$language], $count);
			$count++;
		}
	}
	private function get_country_domain($country){
		$key = array_rand($this->country_domain[$country]);
		return $this->country_domain[$country][$key]->emaildomain;
	}
	private function get_country_language($country){
		$key = array_rand($this->country_language[$country]);
		return $this->country_language[$country][$key]->language;
	}
	private function create_tables($unique_types){
		foreach ($unique_types as $key => $value) {
			$table_name = array();
			$this->tables[$key] = $table_name;
		}
	}

	private function preprocess_unique($unique_types){
		foreach ($unique_types as $key => $value) {
			if ($value['datatype'] == 'NAME'){
				$this->g_unique_name($key);
			}
		}
		foreach ($unique_types as $key => $value) {
			if ($value['datatype'] == 'EMAIL'){
				$this->g_unique_email($key);
			}
		}
		foreach ($unique_types as $key => $value) {
			if ($value['datatype'] == 'PHONE'){
				$this->g_unique_phone($key);
			}
		}
		// foreach ($unique_types as $key => $value) {
		// 	$table_name = $this->tables[$key];
		// 	switch ($value['datatype']) {
		// 		case 'PHONE':
		// 			$this->g_unique_phone($key);
		// 			break;
				
		// 		case 'EMAIL':
		// 			$this->g_unique_email($key);
		// 			break;
				
		// 		case 'NAME':
		// 			$this->g_unique_name($key);
		// 			break;

		// 		default:
		// 			# code...
		// 			break;
		// 	}
		//}
	}

	private function g_name($country){
		// $language_query = $this->db->query("SELECT language FROM country WHERE countryname='$country'");
		// $langobj = $language_query->result()[array_rand($language_query->result())];
		$lang = $this->get_country_language($country);
		$queryF = $this->db->query("SELECT firstn FROM firstname WHERE flanguage='$lang' ORDER BY RAND() LIMIT 1");
		$queryL = $this->db->query("SELECT lastn FROM lastname WHERE llanguage='$lang' ORDER BY RAND() LIMIT 1");
		$rowF = $queryF->row_array();
		$rowL = $queryL->row_array();
		return "".$rowF['firstn']." ".$rowL['lastn'];
	}
	//too complicated
	private function g_unique_name($id){
		foreach ($this->language_ids as $lang => $entry_ids) {
			$size = count($entry_ids);
			$query = $this->db->query("SELECT firstn,lastn FROM firstname,lastname
				WHERE firstname.flanguage=lastname.llanguage and firstname.flanguage='$lang' ORDER BY RAND() LIMIT $size");
			$index = 0;
			if (count($query->result()) < $size) die("Not enough unique names!");
			foreach ($query->result() as $row) {
				$entry_id = $entry_ids[$index];
				$this->tables[$id][$entry_id] = "".$row->firstn." ".$row->lastn;

				$index++;
			}
		}
	}

	private function g_phone($country){
		$code = $this->country_codes[$country]['code'];

		$number = generate_phone($this->country_codes[$country]['length']);

		return "+".$code." ".$number;
	}

	private function g_unique_phone($id){
		$length=8;


		//for inner loop
		$count = 1;
		$max_number = pow(10, $length);

		$number = mt_rand(0, $max_number-1);
		$digits_map = range(0, 9);
		shuffle($digits_map);
		$jump = ($max_number-$this->amount)/($this->amount/10000+1);


		while($count <= $this->amount) {
			//get country infomation
			$country_name = $this->c_table[$count];
			$country_code = $this->country_codes[$country_name]['code'];
			$code_length = $this->country_codes[$country_name]['length'];

			//generate phone
			$str_number = replace_digits($number, $digits_map, $length);
			$str_number .= generate_phone($code_length-$length);

			//store in table
			$this->tables[$id][$count] = "+".$country_code." ".$str_number;

			//fake random
			if($count !== 0 && $count % 10000 === 0){
				$number = ($number + mt_rand($jump/10 * 9, $jump))%$max_number;
			}

			$count++;
			$number = ($number+1) % $max_number;
		}
		
	}
	private function g_email($country){
		$domain_name = $this->get_country_domain($country);

		$username = random_string();
		return "".$username."@".$domain_name;
	}

	private function g_unique_email($id){
		$count = 1;
		while( $count <= $this->amount) {
			$country = $this->c_table[$count];

			$domain_name = $this->get_country_domain($country);

			//get username
			$username = $this->get_user_name($count);

			$this->tables[$id][$count] = "".$username."@".$domain_name;

			$count++;
		}
		
	}
	private function get_user_name($entry_id){
		$name_key = NULL;
		$username = uniqid();
		foreach ($this->u_types as $key => $value) {
			if ($value['datatype'] == 'NAME') {
				$name_key = $key;
				$username = $this->tables[$name_key][$entry_id];

				$username = preg_replace("/[\s-]/", ".", $username);
				break;
			}
		}
		return $username;
	}
	
}
?>
