<?php defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
class Api extends CM_Controller {

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
		$this->load->view('api');
	}
	
	public function did()  
	{				
		$action = $this->input->get("action");
		$did = $this->input->get("imgsm"); $mapp = $this->input->get("defaultlist"); $offhours = $this->input->get("offhours_defaultlist"); 
		$call_prefer = $this->input->get("call_preference"); $fallback = $this->input->get("fallback_list"); $holidaylist = $this->input->get("holidaylist");
		$options = array("did"=>$did,"did_status"=>1,"did_cli"=>'',"call_recording"=>1,"holiday_check"=>0,"timegroupid"=>'1',"OffTime_destination_type"=>'dial',"OffTime_destination_type_value"=>'',"holiday_destination_type"=>'',"holiday_destination_type_value"=>'',"create_date"=>date("Y-m-d H:i:s"));
		if($did != '')
		{
			if($action == 'insert')
			{		
				$didexists = $this->did_managements->did_exist($did);
				if($didexists == 1)
				{
					$option_insert = $this->did_managements->did_insert($options);
					if($option_insert == 1)
					{
						if($mapp != '')
						{
							$mapping = explode(",",$mapp);
							for($i=0;$i<count($mapping);$i++)
							{
								if($mapping[$i] !='')
								{
									$data = array("did"=>$did,"preferred_loc"=>$call_prefer,"number"=>$mapping[$i],"dnd"=>0,"type"=>1,"create_date"=>date("Y-m-d H:i:s"));
									$resultcallflow = $this->did_managements->call_flow_number_update($data);
								}
							}
						}
						
						if($offhours != '')
						{
							$mapping = explode(",",$offhours);
							for($i=0;$i<count($mapping);$i++)
							{
								if($mapping[$i] !='')
								{
									$data = array("did"=>$did,"preferred_loc"=>$call_prefer,"number"=>$mapping[$i],"dnd"=>0,"type"=>3,"create_date"=>date("Y-m-d H:i:s"));
									$resultcallflow = $this->did_managements->call_flow_number_update($data);
								}
							}
						}
						
						if($fallback != '')
						{
							$mapping = explode(",",$fallback);
							for($i=0;$i<count($mapping);$i++)
							{
								if($mapping[$i] !='')
								{
									$data = array("did"=>$did,"preferred_loc"=>$call_prefer,"number"=>$mapping[$i],"dnd"=>0,"type"=>2,"create_date"=>date("Y-m-d H:i:s"));
									$resultcallflow = $this->did_managements->call_flow_number_update($data);
								}
							}
						}
						
						if($holidaylist != '')
						{
							$mapping = explode(",",$holidaylist);
							for($i=0;$i<count($mapping);$i++)
							{
								if($mapping[$i] !='')
								{
									$data = array("did"=>$did,"preferred_loc"=>$call_prefer,"number"=>$mapping[$i],"dnd"=>0,"type"=>4,"create_date"=>date("Y-m-d H:i:s"));
									$resultcallflow = $this->did_managements->call_flow_number_update($data);
								}
							}
						}
						$response = json_encode(array('errcode' => 200, 'errmsg' => "DID added successfully."));
					}
					else
					{
						$response = json_encode(array('errcode' => 202, 'errmsg' => "Something Went Wrong, Please try once again."));
					}
				}
				else
				{
					$response = json_encode(array('errcode' => 205, 'errmsg' => "DID Already Exist."));
				}
			}
			else if($action == 'update')
			{
				$result = $this->did_managements->api_call_flow_number_delete($did);
				if($mapp != '')
				{
					$mapping = explode(",",$mapp);
					for($i=0;$i<count($mapping);$i++)
					{
						if($mapping[$i] !='')
						{
							$data = array("did"=>$did,"preferred_loc"=>$call_prefer,"number"=>$mapping[$i],"dnd"=>0,"type"=>1,"create_date"=>date("Y-m-d H:i:s"));
							$resultcallflow = $this->did_managements->call_flow_number_update($data);
						}
					}
				}
				
				if($offhours != '')
				{
					$mapping = explode(",",$offhours);
					for($i=0;$i<count($mapping);$i++)
					{
						if($mapping[$i] !='')
						{
							$data = array("did"=>$did,"preferred_loc"=>$call_prefer,"number"=>$mapping[$i],"dnd"=>0,"type"=>3,"create_date"=>date("Y-m-d H:i:s"));
							$resultcallflow = $this->did_managements->call_flow_number_update($data);
						}
					}
				}
				
				if($fallback != '')
				{
					$mapping = explode(",",$fallback);
					for($i=0;$i<count($mapping);$i++)
					{
						if($mapping[$i] !='')
						{
							$data = array("did"=>$did,"preferred_loc"=>$call_prefer,"number"=>$mapping[$i],"dnd"=>0,"type"=>2,"create_date"=>date("Y-m-d H:i:s"));
							$resultcallflow = $this->did_managements->call_flow_number_update($data);
						}
					}
				}
				
				if($holidaylist != '')
				{
					$mapping = explode(",",$holidaylist);
					for($i=0;$i<count($mapping);$i++)
					{
						if($mapping[$i] !='')
						{
							$data = array("did"=>$did,"preferred_loc"=>$call_prefer,"number"=>$mapping[$i],"dnd"=>0,"type"=>4,"create_date"=>date("Y-m-d H:i:s"));
							$resultcallflow = $this->did_managements->call_flow_number_update($data);
						}
					}
				}		
				
				$option_insert = $this->did_managements->api_did_update($did,$options);
				if($option_insert == 1)
				{
					$response = json_encode(array('errcode' => 200, 'errmsg' => "DID Updated successfully."));
				}
				else
				{
					$response = json_encode(array('errcode' => 202, 'errmsg' => "Something Went Wrong, Please try once again."));
				}
			}
			else if($action == 'delete')
			{
				$result = $this->did_managements->api_did_delete($did);
				if($result == 1)
				{
					$response = json_encode(array('errcode' => 200, 'errmsg' => "DID Deleted successfully."));
				}
				else
				{
					$response = json_encode(array('errcode' => 202, 'errmsg' => "Something Went Wrong, Please try once again."));
				}
			}
			else
			{
				$response = json_encode(array('errcode' => 203, 'errmsg' => "Invalid Action Input."));
			}
		}
		else
		{
			$response = json_encode(array('errcode' => 204, 'errmsg' => "Invalid DID Number."));
		}
		print_r($response);
	}
}
