<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Holiday extends CM_Controller {

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
		$this->load->view('holiday');
	}
	
	public function holiday_details()
	{
		$pagenum = $this->input->get("page"); 
		$pagesize = $this->input->get("size");
		$offset = ($pagenum - 1) * $pagesize; $keyword = $this->input->get("keyword");
		$result = $this->did_managements->holiday_details($pagesize,$offset,$keyword);
		print_r(json_encode($result));
	}
	
	public function holiday_details_csv()
	{	
		
		$pagenum = 1; 
		$pagesize = "1000000000000000";//$this->input->get("size");
		$offset = ($pagenum - 1) * $pagesize; $keyword = "";//$this->input->get("keyword");
		$result = $this->did_managements->holiday_details($pagesize,$offset,$keyword);
		$titles = array();$array = array(); $j = 1;
		$array[] = array('Sl.No', 'Date', 'Is Global', 'DID'); 
		foreach($result["tabledata"] as $res) 
		{ 		
			if($res['date'] == ''){ $res['date']="NA"; } if($res['is_global'] == ''){ $res['is_global']="NA"; }if($res['did'] == ''){ $res['did']="NA"; }			
			$array[] = array($j, $res['date'], $res['is_global'], $res['did']); $j++;
		} 
		
		$filename = "HOLIDAY_MANAGEMENT.csv";
		$this->my_excel->exports_csv($titles, $array, $filename);
	}
	
	public function holiday_create()  
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
				$options[] = array("date"=>date("Y-m-d",strtotime($col[0])),"is_global"=>$col[1],"did"=>$col[2],"create_date"=>date("Y-m-d H:i:s"));
				}
				$count++;
			}
			
			$option_insert = $this->did_managements->holiday_insert($options);
			if($option_insert == 1)
			{
				$response = json_encode(array('errcode' => 200, 'errmsg' => "Holiday Added Successfully."));
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
