<?php
	class Regional_generator extends CI_Model {
		var $u_types;
		var $n_types;
		var $c_lang;

		public function __construct() {
			$this->load->database();
		}

		public function set_types($unique_types, $normal_types, $countries) {

		}

		public function get_data($size) {

		}

		private function g_name($country){
			$lang = $this->db->query('SELECT language FROM country WHERE countryname=$country');
			$queryF = $this->db->query('SELECT firstn FROM firstname WHERE flanguage=$lang ORDER BY RAND() LIMIT 1');
			$queryL = $this->db->query('SELECT lastn FROM lastname WHERE flanguage=$lang ORDER BY RAND() LIMIT 1');
			$rowF = $queryF->row_array();
			$rowL = $queryL->row_array();
			return "".$rowF['fristn']." ".$rowL['lastn'];
		}
		private function g_unique_name($country, $id){
			$lang = $this->db->query('SELECT language FROM country WHERE countryname=$country');

		}

		private function g_phone($country, $id){
		}
		private function g_unique_phone($country, $id){
		}
		private function g_email($country, $id){
		}
		private function g_unique_email($country, $id){
		}
		private function g_country($country){
		}
		
	}
?>
