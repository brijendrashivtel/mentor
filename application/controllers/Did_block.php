<?php defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");

class Did_block extends CM_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('did_block');
	}
	
	public function did_block_details()
	{
		$pagenum = $this->input->get("page"); 
		$pagesize = $this->input->get("size");
		$offset = ($pagenum - 1) * $pagesize; $keyword = $this->input->get("keyword");
		$result = $this->did_managements->did_block_details($pagesize,$offset,$keyword);
		print_r(json_encode($result));
	}
	
	public function did_block_details_csv()
	{	
		
		$pagenum = 1; 
		$pagesize = "1000000000000000";//$this->input->get("size");
		$offset = ($pagenum - 1) * $pagesize; $keyword = "";//$this->input->get("keyword");
		$result = $this->did_managements->did_block_details($pagesize,$offset,$keyword);
		$titles = array();$array = array(); $j = 1;
		$array[] = array('Sl.No', 'clid','DID','IsActive','DND','IsGlobal'); 
		foreach($result["tabledata"] as $res) 
		{ 		
			if($res['clid'] == ''){ $res['clid']="NA"; }
			if($res['did'] == ''){ $res['did']="NA"; }
			if($res['isActive'] == ''){ $res['isActive']="NA"; }
			if($res['dnd'] == ''){ $res['dnd']="NA"; }
			if($res['is_global'] == ''){ $res['is_global']="NA"; }			
			$array[] = array($j, $res['clid'], $res['did'], $res['isActive'], $res['dnd'], $res['is_global']); $j++;
		} 
		
		$filename = "DID_BLOCK_MANAGEMENT.csv";
		$this->my_excel->exports_csv($titles, $array, $filename);
	}
	
	public function did_block_create()  
	{				
		$formdata = json_decode($this->input->get("formdata")); 		
		if($_FILES['fileInput']['name'] != '')
		{	
			$file = $_FILES['fileInput']['tmp_name'];
			$handle = fopen($file, 'r'); $options = array(); $count = 0;
			while(($files = fgetcsv($handle, 1000, ',')) !== false)
			{
				if($count !=0)
				{
				$num = count($files);
				for ($c=0; $c < $num; $c++) 
				{
					  $col[$c] = $files[$c];
				}
				$options[] = array("clid"=>$col[0],"is_global"=>$col[3],"did"=>$col[1],"isActive"=>$col[2],"dnd"=>$col[4],"create_date"=>date("Y-m-d H:i:s"));
				}
				$count++;
			}
			
			$option_insert = $this->did_managements->did_block_insert($options);
			if($option_insert == 1)
			{
				$response = json_encode(array('errcode' => 200, 'errmsg' => "Number Block Added Successfully."));
			}
			else
			{
				$response = json_encode(array('errcode' => 202, 'errmsg' => "Something Went Wrong, Please try once again."));
			}
		}
		else
		{
			$response = json_encode(array('errcode' => 202, 'errmsg' => "Please select any one file!"));
		}
		print_r($response);
	}
	
	public function login_details()
	{
		$formdata = json_decode($this->input->get("formdata"));
		if($formdata->uname == 'helpadmin' && $formdata->psw == 'helpadmin')
		{
			$sessionarray = array('apuid' => $formdata->uname,'apuser' => $formdata->psw);
			$this->session->set_userdata('logged_in', $sessionarray);
			$response = json_encode(array( "ErrorCode" => "200","LoginRedirect" => base_url("users/dashboard")));
		}
		else
		{
			$response = json_encode(array( "ErrorCode" => "202","LoginRedirect" => base_url("users/dashboard")));
		}
		print_r($response);
	}
}
