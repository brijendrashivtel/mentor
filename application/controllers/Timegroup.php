<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
class Timegroup extends CM_Controller {

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
		$this->load->view('timegroup');
	}
	
	public function prompt()
	{
		$this->load->view('prompt');
	}
	
	public function timegroup_details()
	{
		$pagenum = $this->input->get("page"); 
		$pagesize = $this->input->get("size");
		$offset = ($pagenum - 1) * $pagesize; $keyword = $this->input->get("keyword");
		$result = $this->did_managements->timegroup_details($pagesize,$offset,$keyword);
		print_r(json_encode($result));
	}
	
	public function timegroup_details_csv()
	{	
		
		$pagenum = 1; 
		$pagesize = "1000000000000000";//$this->input->get("size");
		$offset = ($pagenum - 1) * $pagesize; $keyword = "";//$this->input->get("keyword");
		$result = $this->did_managements->timegroup_details($pagesize,$offset,$keyword);
		$titles = array();$array = array(); $j = 1;
		$array[] = array('Sl.No', 'TimeGroup ID','Name','TimeGroup'); 
		foreach($result["tabledata"] as $res) 
		{ 			
			if($res['id'] == ''){ $res['id']="NA"; }	
			if($res['name'] == ''){ $res['name']="NA"; }	
			if($res['timegroup'] == ''){ $res['timegroup']="NA"; }			
			$array[] = array($j, $res['id'], $res['name'], $res['timegroup']); $j++;
		} 
		
		$filename = "TIMEGROUP_MANAGEMENT.csv";
		$this->my_excel->exports_csv($titles, $array, $filename);
	}
	
	
	public function timegroup_create()  
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
				$options[] = array("name"=>$col[0],"timegroup"=>$col[1],"create_date"=>date("Y-m-d H:i:s"));
				}
				$count++;
			}
			
			$option_insert = $this->did_managements->timegroup_insert($options);
			if($option_insert == 1)
			{
				$response = json_encode(array('errcode' => 200, 'errmsg' => "TimeGroup Added Successfully."));
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
	
	public function prompt_create()  
	{				
		$formdata = json_decode($this->input->get("formdata"));	
		$name = $formdata->name;
		if($_FILES['fileInput']['name'] != '')
		{	
			$times = strtotime(date("Y-m-d H:i:s"));
			$filename = $times."_".$_FILES["fileInput"]["name"];
			$ext = explode('.',$filename);
			if($ext[1] == 'wav' || $ext[1] == 'mp3' || $ext[1] == 'MP3' || $ext[1] == 'gsm')
			{
				$file = $_FILES['fileInput']['tmp_name']; 
				$handle = fopen($file, 'r'); $options = array(); $count = 0;
				$burl = $this->config->base_url();
				$target_dir = "/var/www/html/mentor/promptdocs/";
				$target_file = $target_dir . basename($filename);
				if (move_uploaded_file($_FILES["fileInput"]["tmp_name"], $target_file))
				{			
					$options = array("name"=>$name,"file"=>$filename,"create_date"=>date("Y-m-d H:i:s"));
					$option_insert = $this->did_managements->prompt_insert($options);
					if($option_insert == 1)
					{
						$response = json_encode(array('errcode' => 200, 'errmsg' => "Prompt Added Successfully."));
					}
					else
					{
						$response = json_encode(array('errcode' => 202, 'errmsg' => "Something Went Wrong, Please try once again."));
					}
				}
				else
				{
					$response = json_encode(array('errcode' => 202, 'errmsg' => "Unable to Upload the document to specified path.!"));
				}
			}
			else
			{
				$response = json_encode(array('errcode' => 202, 'errmsg' => "Only wav or mp3 format need to be uploaded.!"));
			}
		}
		else
		{
			$response = json_encode(array('errcode' => 202, 'errmsg' => "Please select any one file!"));
		}
		print_r($response);
	}
	
	
	public function prompt_update()  
	{				
		$formdata = json_decode($this->input->get("formdata"));	
		$name = $formdata->name;
		$eid = $formdata->id;
		$upp = 0;
		if(!isset($_FILES['fileInput']['name'])){ $_FILES['fileInput']['name'] = ''; }
		if($_FILES['fileInput']['name'] != '')
		{	
			$file = $_FILES['fileInput']['tmp_name']; $times = strtotime(date("Y-m-d H:i:s"));
			$handle = fopen($file, 'r'); $options = array(); $count = 0;
			$burl = $this->config->base_url();
			$target_dir = "/var/www/html/mentor/promptdocs/";
			$filename = $times."_".$_FILES["fileInput"]["name"];
			$ext = explode('.',$filename);
			if($ext[1] == 'wav' || $ext[1] == 'mp3' || $ext[1] == 'MP3' || $ext[1] == 'gsm')
			{
				$target_file = $target_dir . basename($filename);
				if (move_uploaded_file($_FILES["fileInput"]["tmp_name"], $target_file))
				{			
					$upp = 1;
					$options = array("name"=>$name,"file"=>$filename,"create_date"=>date("Y-m-d H:i:s"));
				}
				else
				{
					$upp = 2;
					$options = array("name"=>$name,"create_date"=>date("Y-m-d H:i:s"));
				}
			}
			else
			{
				$upp = 3;
			}
		}
		else
		{
			$upp = 4;
			$options = array("name"=>$name,"create_date"=>date("Y-m-d H:i:s"));
		}
		if($upp == 1 || $upp == 4)
		{
			$option_insert = $this->did_managements->prompt_update($options,$eid);
			if($option_insert == 1)
			{
				$response = json_encode(array('errcode' => 200, 'errmsg' => "Prompt Updated Successfully."));
			}
			else
			{
				$response = json_encode(array('errcode' => 202, 'errmsg' => "Something Went Wrong, Please try once again."));
			}
		}
		else if($upp == 2)
		{
			$response = json_encode(array('errcode' => 202, 'errmsg' => "Unable to Upload the document to specified path.!"));
		}
		else if($upp == 3)
		{
			$response = json_encode(array('errcode' => 202, 'errmsg' => "Only wav or mp3 format need to be uploaded.!"));
		}
		print_r($response);
	}
	
	public function prompt_details()
	{
		$pagenum = $this->input->get("page"); 
		$pagesize = $this->input->get("size");
		$offset = ($pagenum - 1) * $pagesize; $keyword = $this->input->get("keyword");
		$result = $this->did_managements->prompt_details($pagesize,$offset,$keyword);
		print_r(json_encode($result));
	}

}
