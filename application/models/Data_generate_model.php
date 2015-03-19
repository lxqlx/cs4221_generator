<?php
class Data_generate_model extends CI_Model {
	public function _construct() {
		$this->load->database();
	}
	
	public function generate() {
		$this->load->helper('url');

		$slug = url_title($this->input->post('datatype1'), 'dash', TRUE);
		return TRUE;
	}
}
?>
