<?php
class Datagenerator extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('data_generate_model');
	}

	public function index() {
		$this->load->helper('form');
		$this->load->library('form_validation');

		$data['title'] = 'Generate Data';

		$this->form_validation->set_rules('datatype1', 'DataType1', 'required');
		$this->form_validation->set_rules('datatype2', 'DataType2', 'required');
		$this->form_validation->set_rules('datatype3', 'DataType3', 'required');
		$this->form_validation->set_rules('datatype4', 'DataType4', 'required');
		$this->form_validation->set_rules('datatype5', 'DataType5', 'required');
		$this->form_validation->set_rules('datatype6', 'DataType6', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header', $data);
			$this->load->view('generate');
			$this->load->view('templates/footer');
		} else {
			$this->data_generate_model->generate();
			$this->load->view('success');
		}

	}
}
?>
