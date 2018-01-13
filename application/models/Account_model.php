<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class account_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	function get_account($id){
		$query = $this->db->query("select id,name,number from users where id=$id");
		return $query->row();
	}
	
	function get_account_numbers($id){
		$query = $this->db->query("SELECT `account_id`, `number`, `provider`, `status`, service_providers.name FROM user_numbers join service_providers on service_providers.id = user_numbers.provider where account_id=$id");
		return $query->result();
	}
	
	function get_fnf_numbers($number){
		$qry="SELECT user_fnf_numbers.id as id,`fnf_number`, service_providers.name as provider_name, `status` FROM user_fnf_numbers join service_providers on service_providers.id = user_fnf_numbers.provider where number=$number";
		$query = $this->db->query($qry);
		return $query->result();
	}
	
	function getAllServiceProviders()
	{
    	$query = $this->db->query('SELECT id,name FROM service_providers');
    	return $query->result();
	}
	
	public function get_by_id($id)
	{
		/*$this->db->from("user_fnf_numbers");
		$this->db->where('id',$id);*/
		$qry="SELECT `fnf_number`, `provider`, `status`, service_providers.name as provider_name FROM user_fnf_numbers join service_providers on service_providers.id = user_fnf_numbers.provider where user_fnf_numbers.id=$id";
		$query = $this->db->query($qry);

		return $query->row();
	}

	public function save($data)
	{
		$this->db->insert("user_fnf_numbers", $data);
		return $this->db->insert_id();
	}

	public function update($where, $data)
	{
		$this->db->update("user_fnf_numbers", $data, $where);
		return $this->db->affected_rows();
	}
}
