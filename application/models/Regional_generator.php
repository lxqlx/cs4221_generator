<?php
	/**
	* Generate phone numbers of given length(Not Unique)
	*/
	function generate_phone($length=8){
	    $characters = '0123456789';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}
	function random_string($maxlength=15) {
		$characters = 'abcdefghijklmnopqrstuvwxyz';
    	$charactersLength = strlen($characters);
		$numbers = '0123456789';
		$length = mt_rand(9, $maxlength);
		$random_str = '';
		$c_length = 9;
		$n_length = $length - $c_length;
		for ($i = 0; $i < $c_length; $i++) {
			$random_str .= $characters[rand(0, $charactersLength - 1)];
		}
		for ($i = 0; $i < $n_length; $i++) {
			$random_str .= $numbers[rand(0, 9)];
		}
		return $random_str;
	}
	function replace_digits($origin, $map, $length){
		$result = '';
		for($i=0; $i<$length; $i++){
			$index = $origin % 10;
			$result .= $map[$index];
			$origin /= 10;
		}
		return $result;
	}

	class Regional_generator extends CI_Model {
		var $tables;
		var $amount;
		var $c_table;
		var $get_start;
		var $get_end;
		var $u_types;
		var $n_types;

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
			$this->create_tables($unique_types);
			$this->preprocess_unique($unique_types);
		}

		public function get_data($size) {
			$this->get_end = $this->get_start + $size;
			$result = array();
			$unique_datas = $this->get_unique_datas($this->get_start, $this->get_end);
			$normal_datas = $this->get_normal_datas($this->get_start, $this->get_end);
			for($i=$this->get_start; $i<$this->get_end; $i++) {
				$temp = $unique_datas[$i] + $normal_datas[$i];
				array_push($result, $temp);
			}
			$this->get_start = $this->get_end;
			return $result;
		}

		private function get_unique_datas($start, $end) {
			$columns = array();
			for($i=$start; $i<$end; $i++) {
				$columns[$i] = array();
			}
			foreach ($this->u_types as $key => $value) {
				$table_name = $this->tables[$key];
				$query = $this->db->query("SELECT entry_id, $table_name FROM $table_name 
					WHERE entry_id>=$start and entry_id<$end ORDER BY entry_id");
				$temp = array();
				foreach ($query->result_array() as $row) {
					$columns[$row['entry_id']][$key] = $row[$table_name];
				}
			}

			return $columns;
		}
		private function get_normal_datas($start, $end) {
			$table_name = $this->c_table;
			$query = $this->db->query("SELECT entry_id, country_name FROM $table_name 
					WHERE entry_id>=$start and entry_id<$end ORDER BY entry_id");
			//initialize arrays
			$columns = array();
			for($i=$start; $i<$end; $i++) {
				$columns[$i] = array();
			}

			foreach ($query->result() as $row) {
				$entry_id = $row->entry_id;
				$country = $row->country_name;

				foreach ($this->n_types as $key => $value) {
					$columns[$entry_id][$key] = $this->get_single_normal($country, $value);
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

		private function set_random_countries($countries){
			//create country table
			$this->c_table = uniqid();
			$fields = array(
		                'entry_id' => array(
		                                         'type' => 'INT',
		                                         'constraint' => 9,
		                                         'unsigned' => TRUE,
		                                         'auto_increment' => TRUE
		                                  ),
		                'country_name' => array(
		                                         'type' => 'VARCHAR',
		                                         'constraint' => '30',
		                                  ),
		                'language' => array(
		                                         'type' =>'VARCHAR',
		                                         'constraint' => '30',
		                                  ),
                );
			$this->dbforge->add_field($fields);
			$this->dbforge->add_key('entry_id',TRUE);
			$this->dbforge->create_table($this->c_table);

			//generate random countries and insert
			$count = 0;
			while($count < $this->amount){
				$c_name = $countries[array_rand($countries)];
				$query_str = "SELECT countryname, language FROM country WHERE countryname='$c_name'";
				$query = $this->db->query($query_str);
				$row = $query->result()[array_rand($query->result())];
				$data = array(
						   'country_name' => $row->countryname ,
						   'language' => $row->language
						   );
				$this->db->insert($this->c_table, $data);

				$count++;
			}
		}
		public function destroy_tables(){
			$this->dbforge->drop_table($this->c_table);

			foreach ($this->tables as $key => $value) {
				$this->dbforge->drop_table($value);
			}
		}

		private function create_tables($unique_types){
			foreach ($unique_types as $key => $value) {
				$table_name = uniqid();
				$this->tables[$key] = $table_name;
				$fields = array(
		                'entry_id' => array(
		                                         'type' => 'INT',
		                                         'constraint' => 9,
		                                         'unsigned' => TRUE,
		                                  ),
		                $table_name => array(
		                                         'type' => 'VARCHAR',
		                                         'constraint' => '60',
		                                  ),
                );


				$this->dbforge->add_field($fields);
				$this->dbforge->add_key($table_name, TRUE);
				$this->dbforge->create_table($table_name);
			}
		}

		private function preprocess_unique($unique_types){
			foreach ($unique_types as $key => $value) {
				$table_name = $this->tables[$key];
				switch ($value['datatype']) {
					case 'PHONE':
						$this->g_unique_phone($key);
						break;
					
					case 'EMAIL':
						$this->g_unique_email($key);
						break;
					
					case 'NAME':
						$this->g_unique_name($key);
						break;

					default:
						# code...
						break;
				}
			}
		}

		private function g_name($country){
			$language_query = $this->db->query("SELECT language FROM country WHERE countryname='$country'");
			$langobj = $language_query->result()[array_rand($language_query->result())];
			$lang = $langobj->language;
			$queryF = $this->db->query("SELECT firstn FROM firstname WHERE flanguage='$lang' ORDER BY RAND() LIMIT 1");
			$queryL = $this->db->query("SELECT lastn FROM lastname WHERE llanguage='$lang' ORDER BY RAND() LIMIT 1");
			$rowF = $queryF->row_array();
			$rowL = $queryL->row_array();
			return "".$rowF['firstn']." ".$rowL['lastn'];
		}
		//too complicated
		private function g_unique_name($id){
		}

		private function g_phone($country){
			$codequery = $this->db->query("SELECT code,length FROM phone
			WHERE country='$country'");
			$codeobj = $codequery->row();
			$code = $codeobj->code;

			$number = generate_phone($codeobj->length);

			return "+".$code." ".$number;
		}

		private function g_unique_phone($id){
			$length=8;

			$start = 1;
			$amount = $this->amount;
			$size = min($amount, 1000);
			$end = $start + $size;

			//for inner loop
			$count = 0;
			$max_number = pow(10, $length);

			$number = mt_rand(0, $max_number-1);
			$digits_map = range(0, 9);
			shuffle($digits_map);
			$jump = ($max_number-$this->amount)/($this->amount/10000+1);


			while( $amount > 0) {
				$country_codes = $this->db->query("SELECT entry_id, code, length 
					FROM $this->c_table, phone 
					WHERE $this->c_table.country_name=phone.country
					and entry_id>=$start and entry_id<$end");


				foreach ($country_codes->result() as $row) {
					$str_number = replace_digits($number, $digits_map, $length);
					$str_number .= generate_phone($row->length-$length);
					$table_name = $this->tables[$id];
					$data = array(
							   'entry_id' => $row->entry_id ,
							   $table_name => "+".$row->code." ".$str_number
							   );
					$this->db->insert($table_name, $data);

					if($count !== 0 && $count % 10000 === 0){
						$number = ($number + mt_rand($jump/10 * 9, $jump))%$max_number;
					}

					$count++;
					$number = ($number+1) % $max_number;
				}

				$amount -= $size;
				$start = $end;
				$size = min($amount, 1000);
				$end = $start + $size;
			}
			
		}
		private function g_email($country){
			$domainquery = $this->db->query("SELECT emaildomain FROM domain
			WHERE country='$country' or country='Global'");
			$domainobj = $domainquery->result()[array_rand($domainquery->result())];
			$domain_name = $domainobj->emaildomain;

			$username = random_string();
			return "".$username.$domain_name;
		}

		private function g_unique_email($id){
			$start = 1;
			$amount = $this->amount;
			$size = min($amount, 1000);
			$end = $start + $size;
			while( $amount > 0) {
				$country = $this->db->query("SELECT entry_id, country_name
					FROM ".$this->c_table."
					WHERE entry_id>=$start and entry_id<$end");

				foreach ($country->result() as $row) {
					//get random domain name
					$domainquery = $this->db->query("SELECT emaildomain FROM domain
					WHERE country='".$row->country_name."' or country='Global'");
					$domainobj = $domainquery->result()[array_rand($domainquery->result())];
					$domain_name = $domainobj->emaildomain;

					//get username
					$username = uniqid();

					$table_name = $this->tables[$id];
					$data = array(
							   'entry_id' => $row->entry_id ,
							   $table_name => "".$username."@".$domain_name
							   );
					$this->db->insert($table_name, $data);
				}

				$amount -= $size;
				$start = $end;
				$size = min($amount, 1000);
				$end = $start + $size;
			}
			
		}
		
	}
?>
