<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();  
		if(isset($this->session->userdata['log_in']))
		{
			$this->username = $this->session->userdata['log_in']['username'];
			redirect('did_management');
		}
	}
	
	public function index()  
	{
		$this->load->view('login');
	}
		
	public function checklogin()  
	{
		$formdata = json_decode($this->input->get("formdata")); //print_r($formdata);exit;
		$userlog = $this->did_managements->logincheck($formdata->username,md5($formdata->pwd));
		if($userlog!=0)
		{
			$session_data = array('username' => $formdata->username);
			$this->session->set_userdata('log_in', $session_data); // Add user data in session
			$response = json_encode(array('errcode' =>200, 'errmsg' => 'did_management')); 
			//redirect('did_management'); exit();
		}
		else
		{
			$response = json_encode(array('errcode' =>202, 'errmsg' => 'Invalid Credentials!')); 
		}
		print_r($response);
	}
}


