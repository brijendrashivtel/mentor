<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CM_Controller {

	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$this->session->unset_userdata('log_in');
		//redirect('kb_admin');
		?> <script>window.location = '<?php echo base_url("login"); ?>';</script> <?php
		exit();
	}
}