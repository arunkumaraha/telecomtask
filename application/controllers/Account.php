<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class account extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('account_model');
		
	}

	public function index()
	{
		$this->load->helper('url');
		$data['providers'] = $this->account_model->getAllServiceProviders();
		//print_r($data['provider']);
		$this->load->view('account_view', $data);
		//$this->load->view('account_view');
	}
	
	public function ajax_get_account()
	{
		$this->load->helper('url');
		$account_number = $this->input->post('account_number');
		$this->account_model->get_account($account_number);
	}
	
	public function ajax_get_account_numbers()
	{
		$this->load->helper('url');
		$account_number = $this->input->post('account_number');
		$data = $this->account_model->get_account_numbers($account_number);
		echo json_encode($data);
	}
	
	public function ajax_get_fnf_numbers()
	{
		$this->load->helper('url');
		$phone_number = $this->input->post('phone_number');
		$data = $this->account_model->get_fnf_numbers($phone_number);
		echo json_encode($data);
	}
	
	public function ajax_add()
	{
		//$this->_validate();
		
		$data = array(
				'fnf_number' => $this->input->post('fnf_number'),
				'number' => $this->input->post('number'),
				'provider' => $this->input->post('provider'),
				'status' => $this->input->post('status')
			);

		$insert = $this->account_model->save($data);
		//echo $insert;
		echo json_encode(array("status" => TRUE));
	}


	public function ajax_edit($id)
	{
		$data = $this->account_model->get_by_id($id);
		
		echo json_encode($data);
	}

	
	public function ajax_update()
	{
		$data = array(
				'provider' => $this->input->post('provider'),
				'fnf_number' => $this->input->post('fnf_number'),
				'status' => $this->input->post('status')
			);


		$this->account_model->update(array('id' => $this->input->post('fnf_id')), $data);
		echo json_encode(array("status" => TRUE));
	}

}
