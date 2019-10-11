<?php defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
class Did_management extends CM_Controller {

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
		$this->load->view('did_management');
	}
	
	public function timegroup_details_all()
	{
		$result = $this->did_managements->timegroup_details_all();
		print_r(json_encode($result));
	}
	
	public function prompt_details_all()
	{
		$result = $this->did_managements->prompt_details_all();
		print_r(json_encode($result));
	}
	
	
	public function common_delete()
	{
		$id = $this->input->get("id");  $sts = $this->input->get("sts"); 
		$result = $this->did_managements->common_delete($sts,$id);
		if($result == 1)
		{
			if($sts == "cm")  $str = "Call Mapping Number"; if($sts == "fb")  $str = "Fall Back Number"; if($sts == "fh")  $str = "Off Hour Number"; if($sts == "hn")  $str = "Holiday Number";
			$response = json_encode(array('errcode' => 200, 'errmsg' => " Deleted successfully."));
		}
		else
		{
			$response = json_encode(array('errcode' => 202, 'errmsg' => "Something Went Wrong, Please try once again."));
		}
		print_r($response);
	}
	
	public function timegroup_delete()
	{
		$id = $this->input->get("id"); 
		$result = $this->did_managements->timegroup_delete($id);
		if($result == 1)
		{
			$response = json_encode(array('errcode' => 200, 'errmsg' => "Timegroup Deleted successfully."));
		}
		else
		{
			$response = json_encode(array('errcode' => 202, 'errmsg' => "Something Went Wrong, Please try once again."));
		}
		print_r($response);
	}
	
	public function timegroup_delete_bulk()
	{
		$id = $this->input->get("id"); 
		$result = $this->did_managements->timegroup_delete_bulk($id);
		if($result == 1)
		{
			$response = json_encode(array('errcode' => 200, 'errmsg' => "Timegroup Deleted successfully."));
		}
		else
		{
			$response = json_encode(array('errcode' => 202, 'errmsg' => "Something Went Wrong, Please try once again."));
		}
		print_r($response);
	}
	
	public function prompt_delete()
	{
		$id = $this->input->get("id"); 
		$result = $this->did_managements->prompt_delete($id);
		if($result == 1)
		{
			$response = json_encode(array('errcode' => 200, 'errmsg' => "Prompt Deleted successfully."));
		}
		else
		{
			$response = json_encode(array('errcode' => 202, 'errmsg' => "Something Went Wrong, Please try once again."));
		}
		print_r($response);
	}
	
	public function prompt_delete_bulk()
	{
		$id = $this->input->get("id"); 
		$result = $this->did_managements->prompt_delete_bulk($id);
		if($result == 1)
		{
			$response = json_encode(array('errcode' => 200, 'errmsg' => "Prompt Deleted successfully."));
		}
		else
		{
			$response = json_encode(array('errcode' => 202, 'errmsg' => "Something Went Wrong, Please try once again."));
		}
		print_r($response);
	}
	
	public function timegroup_update()  
	{				
		$formdata = json_decode($this->input->get("id"));
		$eid = $formdata->id;
		$data = array("name"=>$formdata->name,"timegroup"=>$formdata->timegroup);
		$result = $this->did_managements->timegroup_update($eid,$data);
		if($result == 1)
		{
			$response = json_encode(array('errcode' => 200, 'errmsg' => "TimeGroup Updated successfully."));
		}
		else
		{
			$response = json_encode(array('errcode' => 202, 'errmsg' => "Something Went Wrong, Please try once again."));
		}
		print_r($response);
	}
	
	public function holiday_update()  
	{				
		$formdata = json_decode($this->input->get("id"));
		$eid = $formdata->id;
		$data = array("date"=>date("Y-m-d",strtotime($formdata->date)),"is_global"=>$formdata->is_global,"did"=>$formdata->did);
		$result = $this->did_managements->holiday_update($eid,$data);
		if($result == 1)
		{
			$response = json_encode(array('errcode' => 200, 'errmsg' => "Holiday Updated successfully."));
		}
		else
		{
			$response = json_encode(array('errcode' => 202, 'errmsg' => "Something Went Wrong, Please try once again."));
		}
		print_r($response);
	}
	
	public function didblock_update()  
	{				
		$formdata = json_decode($this->input->get("id"));
		$eid = $formdata->id;
		$data = array("clid"=>$formdata->clid,"is_global"=>$formdata->is_global,"did"=>$formdata->did,"isActive"=>$formdata->isActive,"dnd"=>$formdata->dnd);
		$result = $this->did_managements->didblock_update($eid,$data);
		if($result == 1)
		{
			$response = json_encode(array('errcode' => 200, 'errmsg' => "DID Block Updated successfully."));
		}
		else
		{
			$response = json_encode(array('errcode' => 202, 'errmsg' => "Something Went Wrong, Please try once again."));
		}
		print_r($response);
	}
	
	public function didblock_delete()
	{
		$id = $this->input->get("id"); 
		$result = $this->did_managements->didblock_delete($id);
		if($result == 1)
		{
			$response = json_encode(array('errcode' => 200, 'errmsg' => "DID Block Deleted Successfully."));
		}
		else
		{
			$response = json_encode(array('errcode' => 202, 'errmsg' => "Something Went Wrong, Please try once again."));
		}
		print_r($response);
	}
	
	public function didblock_delete_bulk()
	{
		$id = $this->input->get("id"); 
		$result = $this->did_managements->didblock_delete_bulk($id);
		if($result == 1)
		{
			$response = json_encode(array('errcode' => 200, 'errmsg' => "DID Block Deleted Successfully."));
		}
		else
		{
			$response = json_encode(array('errcode' => 202, 'errmsg' => "Something Went Wrong, Please try once again."));
		}
		print_r($response);
	}
	
	public function holiday_delete()
	{
		$id = $this->input->get("id"); 
		$result = $this->did_managements->holiday_delete($id);
		if($result == 1)
		{
			$response = json_encode(array('errcode' => 200, 'errmsg' => "Holiday Deleted Successfully."));
		}
		else
		{
			$response = json_encode(array('errcode' => 202, 'errmsg' => "Something Went Wrong, Please try once again."));
		}
		print_r($response);
	}
	
	public function holiday_delete_bulk()
	{
		$id = $this->input->get("id"); 
		$result = $this->did_managements->holiday_delete_bulk($id);
		if($result == 1)
		{
			$response = json_encode(array('errcode' => 200, 'errmsg' => "Holiday Deleted Successfully."));
		}
		else
		{
			$response = json_encode(array('errcode' => 202, 'errmsg' => "Something Went Wrong, Please try once again."));
		}
		print_r($response);
	}
	
	public function did_details()
	{
		$pagenum = $this->input->get("page"); 
		$pagesize = $this->input->get("size");
		$offset = ($pagenum - 1) * $pagesize; $keyword = $this->input->get("keyword");
		$result = $this->did_managements->did_details($pagesize,$offset,$keyword);
		print_r(json_encode($result));
	}
	
	public function did_update()  
	{				
		$formdata = json_decode($this->input->get("id"));
		$eid = $formdata->id;
		$data = array("did"=>$formdata->did,"did_status"=>$formdata->did_status,"did_cli"=>$formdata->did_cli,"call_recording"=>$formdata->call_recording,"holiday_check"=>$formdata->holiday_check,"timegroupid"=>$formdata->timegroupid,"OffTime_destination_type"=>$formdata->OffTime_destination_type,"OffTime_destination_type_value"=>$formdata->OffTime_destination_type_value,"holiday_destination_type"=>$formdata->holiday_destination_type,"holiday_destination_type_value"=>$formdata->holiday_destination_type_value);
		$result = $this->did_managements->did_update($eid,$data);
		if($result == 1)
		{
			$response = json_encode(array('errcode' => 200, 'errmsg' => "DID Updated successfully."));
		}
		else
		{
			$response = json_encode(array('errcode' => 202, 'errmsg' => "Something Went Wrong, Please try once again."));
		}
		print_r($response);
	}
	
	public function did_delete()
	{
		$id = $this->input->get("id"); 
		$result = $this->did_managements->did_delete($id);
		if($result == 1)
		{
			$response = json_encode(array('errcode' => 200, 'errmsg' => "DID Deleted successfully."));
		}
		else
		{
			$response = json_encode(array('errcode' => 202, 'errmsg' => "Something Went Wrong, Please try once again."));
		}
		print_r($response);
	}
	
	public function did_delete_bulk()
	{
		$id = $this->input->get("id"); 
		$result = $this->did_managements->did_delete_bulk($id);
		if($result == 1)
		{
			$response = json_encode(array('errcode' => 200, 'errmsg' => "DID Deleted successfully."));
		}
		else
		{
			$response = json_encode(array('errcode' => 202, 'errmsg' => "Something Went Wrong, Please try once again."));
		}
		print_r($response);
	}
	
	public function did_details_csv()
	{	
		
		$pagenum = 1; 
		$pagesize = "1000000000000000";//$this->input->get("size");
		$offset = ($pagenum - 1) * $pagesize; $keyword = "";//$this->input->get("keyword");
		$result = $this->did_managements->did_details($pagesize,$offset,$keyword);
		$titles = array();$array = array(); $j = 1;
		$array[] = array('Sl.No', 'DID No', 'DID Status', 'DID CLI', 'Call Recording', 'Holiday Check','TimeGroupId', 'OffTime Destination Type', 'OffTime Destination Type Value', 'Holiday Destination Type', 'Holiday Destination Type Value',"Mapped No.","Fallback No.","Off Hour No.","Holiday No."); 
		foreach($result["tabledata"] as $res) 
		{ 		
			
			if($res['did'] == ''){ $res['did']="NA"; }
			if($res['did_status'] == ''){ $res['did_status']="NA"; }
			if($res['did_cli'] == ''){ $res['did_cli']="NA"; }
			if($res['call_recording'] == ''){ $res['call_recording']="NA"; }
			if($res['holiday_check'] == ''){ $res['holiday_check']="NA"; }
			if($res['timegroupid'] == ''){ $res['timegroupid']="NA"; }
			if($res['OffTime_destination_type'] == ''){ $res['OffTime_destination_type']="NA"; }
			if($res['OffTime_destination_type_value'] == ''){ $res['OffTime_destination_type_value']="NA"; }
			
			$mapp = $this->did_managements->did_related_num($res['did'],1); $mapped = ''; foreach($mapp as $mapp) { $mapped .= $mapp["number"].';'; }
			$fall = $this->did_managements->did_related_num($res['did'],2); $falll = ''; foreach($fall as $fall) { $falll .= $fall["number"].';'; }
			$off = $this->did_managements->did_related_num($res['did'],3); $offf = ''; foreach($off as $off) { $offf .= $off["number"].';'; }
			$holi = $this->did_managements->did_related_num($res['did'],4); $holid = ''; foreach($holi as $holi) { $holid .= $holi["number"].';'; }
			
			$array[] = array($j, $res['did'], $res['did_status'], $res['did_cli'], $res['call_recording'], $res['holiday_check'], $res['timegroupid'], $res['OffTime_destination_type'], $res['OffTime_destination_type_value'], $res['holiday_destination_type'], $res['holiday_destination_type_value'],$mapped,$falll,$offf,$holid); $j++;
		} 
		$filename = "DID_MANAGEMENT.csv";
		$this->my_excel->exports_csv($titles, $array, $filename);
	}
	
	public function call_flow_number()
	{
		$did = $this->input->get("did"); $maptype = $this->input->get("maptype");
		$result = $this->did_managements->call_flow_number($did,$maptype);
		print_r(json_encode($result));
	}
	
	public function call_flow_number_update()
	{
		$maptype = $this->input->get("maptype"); $dnds = $this->input->get("dnds"); $tpps = $this->input->get("tpps"); 
		$did = $this->input->get("did");
		$results = $this->did_managements->call_flow_number_delete($did,'');
		$mapvals = explode(",",$this->input->get("mapvals")); $dndsvals = explode(",",$this->input->get("dnds")); $ttpsvals = explode(",",$tpps);
		$data = array();
		for($i=0;$i<count($mapvals);$i++)
		{
			if($mapvals[$i] != '')
			{
			$data = array("did"=>$did,"preferred_loc"=>"IN","number"=>$mapvals[$i],"dnd"=>$dndsvals[$i],"type"=>$ttpsvals[$i],"create_date"=>date("Y-m-d H:i:s"));
			//print_r($data);
			$result = $this->did_managements->call_flow_number_update($data);
			}
		}
		print_r(json_encode($result));
	}
	
	public function didDeleteUpload()  
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
					$options[] = $col[0];
				}
				$count++;
			}
			$opts = implode(",",$options);
			$result = $this->did_managements->did_delete_bulk($opts);
			if($result == 1)
			{
				$response = json_encode(array('errcode' => 200, 'errmsg' => "DID List Deleted successfully."));
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
	
	public function did_create()  
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
					$options[] = array("did"=>$col[0],"did_status"=>$col[1],"did_cli"=>$col[2],"call_recording"=>$col[3],"holiday_check"=>$col[4],"timegroupid"=>$col[5],"OffTime_destination_type"=>$col[6],"OffTime_destination_type_value"=>$col[7],"holiday_destination_type"=>$col[8],"holiday_destination_type_value"=>$col[9],"create_date"=>date("Y-m-d H:i:s"));
					$mapp = $col[10];
					if($mapp != '')
					{
						$mapping = explode(";",$mapp);
						for($i=0;$i<count($mapping);$i++)
						{
							if($mapping[$i] !='')
							{
								$data = array("did"=>$col[0],"preferred_loc"=>"IN","number"=>$mapping[$i],"dnd"=>0,"type"=>1,"create_date"=>date("Y-m-d H:i:s"));
								$resultcallflow = $this->did_managements->call_flow_number_update($data);
							}
						}
					}
					
					$mapp = $col[11];
					if($mapp != '')
					{
						$mapping = explode(";",$mapp);
						for($i=0;$i<count($mapping);$i++)
						{
							if($mapping[$i] !='')
							{
								$data = array("did"=>$col[0],"preferred_loc"=>"IN","number"=>$mapping[$i],"dnd"=>0,"type"=>2,"create_date"=>date("Y-m-d H:i:s"));
								$resultcallflow = $this->did_managements->call_flow_number_update($data);
							}
						}
					}
					$mapp = $col[12];
					if($mapp != '')
					{
						$mapping = explode(";",$mapp);
						for($i=0;$i<count($mapping);$i++)
						{
							if($mapping[$i] !='')
							{
								$data = array("did"=>$col[0],"preferred_loc"=>"IN","number"=>$mapping[$i],"dnd"=>0,"type"=>3,"create_date"=>date("Y-m-d H:i:s"));
								$resultcallflow = $this->did_managements->call_flow_number_update($data);
							}
						}
					}
					
					$mapp = $col[13];
					if($mapp != '')
					{
						$mapping = explode(";",$mapp);
						for($i=0;$i<count($mapping);$i++)
						{
							if($mapping[$i] !='')
							{
								$data = array("did"=>$col[0],"preferred_loc"=>"IN","number"=>$mapping[$i],"dnd"=>0,"type"=>4,"create_date"=>date("Y-m-d H:i:s"));
								$resultcallflow = $this->did_managements->call_flow_number_update($data);
							}
						}
					}
				}
				$count++;
			}
			
			$option_insert = $this->did_managements->option_insert($options);
			if($option_insert == 1)
			{
				$response = json_encode(array('errcode' => 200, 'errmsg' => "DID added successfully."));
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
