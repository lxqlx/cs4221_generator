<?php
class Free_generator extends CI_Model {
	var $u_types;
	var $n_types;

	var $test;

	public function __construct() {
		$this->load->database();
	}

	public function set_types($unique_types, $normal_types) {
		return NULL;
	}

	public function get_data($size) {
		return NULL;
	}
}
?>