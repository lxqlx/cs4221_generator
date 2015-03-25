<?php
class Datagenerator extends CI_Controller {

	public function __construct() {
		parent::__construct();
		//$this->load->model('data_generate_model');
		$this->load->model('data_generate_model_ram');
	}

	public function index() {
		$this->load->helper('form');
		$this->load->library('form_validation');

		// $data['title'] = 'Generate Data';

		$this->form_validation->set_rules('rows', 'Rows', 'required');
		//$this->form_validation->set_rules('datatype2', 'DataType2', 'required');
		// $this->form_validation->set_rules('datatype3', 'DataType3', 'required');
		// $this->form_validation->set_rules('datatype4', 'DataType4', 'required');
		// $this->form_validation->set_rules('datatype5', 'DataType5', 'required');
		// $this->form_validation->set_rules('datatype6', 'DataType6', 'required');
		if ($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header');
			$this->load->view('pages/home');
			//$this->load->view('generate');
			$this->load->view('templates/footer');
		} else {
			$this->data_generate_model_ram->generate();
			$this->data_generate_model_ram->download();
			$this->load->view('success');


			// $this->load->view('templates/header');
			// $this->load->view('pages/generate');
			// $this->load->view('templates/footer');
		}

	}
}
?>
