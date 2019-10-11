<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cdr extends CM_Controller {

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
		$this->load->view('cdr');
	}
	
	public function unanswered()
	{
		$this->load->view('report_unanswered');
	}
	
	public function report()
	{
		$this->load->view('report');
	}
	
	public function download() 
	{   
		$filename = $this->uri->segment(3); 
		//$filename = str_replace("~","/",$link);
    	$data = file_get_contents("http://112.196.109.66:8181/mentor/promptdocs/".$filename);
    	force_download(end($filename), $data);
	}
	
	public function cdr_download() 
	{   
		$filename = $this->uri->segment(3); 
		//$filename = str_replace("~","/",$link);
    	$data = file_get_contents("http://112.196.109.66:8181/recording/".str_replace("~","/",$filename));
    	force_download(end($filename), $data);
	}
	
	public function cdr_details()
	{
		$pagenum = $this->input->get("page"); 
		$pagesize = $this->input->get("size"); $asc = $this->input->get("asc");
		$offset = ($pagenum - 1) * $pagesize; 
		$sdate = $this->input->get("sdate"); $edate = $this->input->get("edate"); $disposition = $this->input->get("disposition");  $sd = $this->input->get("sd");
		$result = $this->did_managements->cdr_details($pagesize,$offset,$sdate,$edate,$disposition,$sd,$asc);
		print_r(json_encode($result));
	}
	
	public function get_clid_block_status()
	{
		$formdata = json_decode($this->input->get("didedit"));
		$clid = $formdata->clid;  $src = $formdata->did; $reason = $formdata->reason;  $global = $formdata->is_global; 
		$status = $this->input->get("status");
		$result = $this->did_managements->get_clid_block_status($clid,$status,$src,$reason,$global);
		print_r(json_encode($result));
	}
	
	public function get_clid_unblock_status()
	{
		$clid = $this->input->get("clid");  $src = $this->input->get("src"); 
		$status = $this->input->get("status");
		$result = $this->did_managements->get_clid_unblock_status($clid,$status,$src);
		print_r(json_encode($result));
	}
	
	
	public function reasons()
	{
		$result = $this->did_managements->reasons();
		print_r(json_encode($result));
	}
	
	public function cdr_details_listen()
	{
		$id = $this->input->get("id");  $data = array("listen"=>'Yes');
		$result = $this->did_managements->cdr_details_listen($id,$data);
		print_r(json_encode($result));
	}
	
	public function cdr_details_report()
	{
		$pagenum = $this->input->get("page"); 
		$pagesize = $this->input->get("size");
		$offset = ($pagenum - 1) * $pagesize; 
		$sdate = $this->input->get("sdate"); $edate = $this->input->get("edate"); $disposition = $this->input->get("disposition");  $sd = $this->input->get("sd");
		$result = $this->did_managements->cdr_details_report($pagesize,$offset,$sdate,$edate,$disposition,$sd);
		print_r(json_encode($result));
	}
	
	public function cdr_details_report_unanswered_popup()
	{
		$sd = $this->input->get("sd");
		$result = $this->did_managements->cdr_details_report_unanswered_popup($sd);
		print_r(json_encode($result));
	}
	
	public function cdr_details_report_unanswered()
	{
		$pagenum = $this->input->get("page"); 
		$pagesize = $this->input->get("size");
		$offset = ($pagenum - 1) * $pagesize; 
		$sdate = $this->input->get("sdate"); $edate = $this->input->get("edate"); $disposition = $this->input->get("disposition");  $sd = $this->input->get("sd");
		$result = $this->did_managements->cdr_details_report_unanswered($pagesize,$offset,$sdate,$edate,$disposition,$sd);
		print_r(json_encode($result));
	}
	
	public function cdr_indetails()
	{ 
		$clid = $this->input->get("clid");
		$sdate = $this->input->get("sdate"); $edate = $this->input->get("edate"); $disposition = $this->input->get("disposition");  $sd = $this->input->get("sd");
		$result = $this->did_managements->cdr_indetails($clid,$sdate,$edate,$disposition,$sd);
		print_r(json_encode($result));
	}
	
	public function cdr_indetails_src()
	{ 
		$clid = $this->input->get("clid");
		$sdate = $this->input->get("sdate"); $edate = $this->input->get("edate"); $disposition = $this->input->get("disposition");  $sd = $this->input->get("sd");
		$result = $this->did_managements->cdr_indetails_src($clid,$sdate,$edate,$disposition,$sd);
		print_r(json_encode($result));
	}
	
	public function cdr_indetails_weekly()
	{ 
		$clid = $this->input->get("clid");
		$sdate = date('Y-m-d', strtotime('-7 days')); $edate = date('Y-m-d'); $disposition = $this->input->get("disposition");  $sd = $this->input->get("sd");
		$result = $this->did_managements->cdr_indetails($clid,$sdate,$edate,$disposition,$sd);
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
}
