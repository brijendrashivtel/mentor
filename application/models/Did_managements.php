<?php date_default_timezone_set('Asia/Kolkata');
defined('BASEPATH') OR exit('No direct script access allowed');

class Did_managements extends CI_Model { 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function logincheck($eid,$pwd)
	{
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('username',$eid);
		$this->db->where('password',$pwd);
		//$this->db->where('aprole',$type);
		$query = $this->db->get();
		if($query->num_rows() >0)
		{
			$result = $query->row_array();
		}
		else
		{
			$result = 0;
		}
		return $result;
	}
	
	public function reasons()
	{
		$this->db->select('*');
		$this->db->from('reasons');
		$query = $this->db->get();
		$dept = $query->result_array();
		return $dept;
	}
	
	public function did_exist($did)
	{
		$final = array();
		$this->db->select('*');
		$this->db->from('did_tbl');
		$this->db->where('did',$did);
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
			return 0;
		}else
		{
			return 1;
		}
	}
	
	public function call_flow_number($did,$type)
	{
		$final = array();
		$this->db->select('*');
		$this->db->from('call_flow_number');
		$this->db->where('did',$did);
		//$this->db->where('type',$type);
		$query = $this->db->get();
		$dept = $query->result_array();
		return $dept;
	}
	
	public function call_flow_number_update($data)
	{
		if($this->db->insert('call_flow_number',$data))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	public function get_clid_block_status($did,$status,$src,$reason,$global) 
	{		
		
		if($status == 'B')
		{
			$isactive = 1; 
			$data = array("clid"=>$did,"isActive"=>$isactive,"is_global"=>$global,"did"=>$src,"Reason"=>$reason,"create_date"=>date("Y-m-d H:i:s"));
			$this->db->select('*');
			$this->db->from('blocked_no');
			$this->db->where('did',$src);
			$query = $this->db->get();
			if($query->num_rows()>0)
			{
				$this->db->where('did', $src);
				if($this->db->update('blocked_no',$data))
				{
					return 1;
				}
				else
				{
					return 0;
				}
			}
			else
			{
				if($this->db->insert('blocked_no',$data))
				{
					return 1;
				}
				else
				{
					return 0;
				}
			}
		}
		else if($status == 'U')
		{
			$this->db->where('did', $src);
			if($this->db->delete('blocked_no'))
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}
	}
	
	public function get_clid_unblock_status($did,$status,$src) 
	{		
		if($status == 'U')
		{
			$this->db->where('did', $src);
			if($this->db->delete('blocked_no'))
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}
	}
	
	public function call_flow_number_delete($did,$maptype) 
	{		
		$this->db->where('did', $did);
		//$this->db->where('type', $maptype);	
		if($this->db->delete('call_flow_number'))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	public function common_delete($sts,$id) 
	{		
		if($sts == 'cm') $type = "1"; if($sts == 'fb') $type = "2"; if($sts == 'fh') $type == "3"; if($sts == 'hn') $type = "4";
		$this->db->where('number', $id);
		//$this->db->where('type', $type);
		if($this->db->delete('call_flow_number'))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	public function did_delete_bulk($id) 
	{		
		$this->db->where('did in ('.$id.')');
		if($this->db->delete('did_tbl'))
		{
			$this->db->where('did in ('.$id.')');
			$this->db->delete('call_flow_number');
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	public function did_delete($id) 
	{		
		$this->db->where('id', $id);
		if($this->db->delete('did_tbl'))
		{
			$this->db->where('did = "'.$id.'"');
			$this->db->delete('call_flow_number');
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	public function api_did_delete($id) 
	{		
		$this->db->where('did', $id);
		if($this->db->delete('did_tbl'))
		{
			$this->db->where('did = "'.$id.'"');
			$this->db->delete('call_flow_number');
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	public function api_call_flow_number_delete($id) 
	{		
		$this->db->where('did', $id);
		if($this->db->delete('call_flow_number'))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	public function timegroup_delete($id) 
	{		
		$this->db->where('id', $id);
		if($this->db->delete('timegroup'))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	public function timegroup_delete_bulk($id) 
	{		
		$this->db->where('id in ('.$id.')');
		if($this->db->delete('timegroup'))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	public function prompt_delete($id) 
	{		
		$this->db->where('id', $id);
		if($this->db->delete('prompts'))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	public function prompt_delete_bulk($id) 
	{		
		$this->db->where('id in ('.$id.')');
		if($this->db->delete('prompts'))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	public function holiday_delete($id) 
	{		
		$this->db->where('id', $id);
		if($this->db->delete('holiday'))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	public function holiday_delete_bulk($id) 
	{		
		$this->db->where('id in ('.$id.')');
		if($this->db->delete('holiday'))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	public function didblock_delete($id) 
	{		
		$this->db->where('id', $id);
		if($this->db->delete('blocked_no'))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	public function didblock_delete_bulk($id) 
	{		
		$this->db->where('id in ('.$id.')');
		if($this->db->delete('blocked_no'))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	public function cdr_details_listen($id,$data) 
	{		
		$this->db->where('id', $id);
		if($this->db->update('custom_cdr',$data))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	public function didblock_update($id,$data) 
	{		
		$this->db->where('id', $id);
		if($this->db->update('blocked_no',$data))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	public function holiday_update($id,$data) 
	{		
		$this->db->where('id', $id);
		if($this->db->update('holiday',$data))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	public function did_update($id,$data) 
	{		
		$this->db->where('id', $id);
		if($this->db->update('did_tbl',$data))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	public function api_did_update($id,$data) 
	{		
		$this->db->where('did', $id);
		if($this->db->update('did_tbl',$data))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	public function timegroup_update($id,$data) 
	{		
		$this->db->where('id', $id);
		if($this->db->update('timegroup',$data))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	public function did_related_num($did,$type)
	{
		$this->db->select('number');
		$this->db->from('call_flow_number');
		$this->db->where("did ='".$did."'"); 
		$this->db->where("type ='".$type."'");
		$this->db->order_by('number','desc');
		$mquery = $this->db->get();
		return $mapped = $mquery->result_array();		
	}
	
	public function did_details($pagesize,$offset,$keyword)
	{
		$qry = '';
		if($keyword!=''){ $this->db->where("did LIKE '".$keyword."%'"); }
		$count = $this->db->count_all_results('did_tbl');
		
		$final = array();
		$this->db->select('*');
		$this->db->from('did_tbl');
		if($keyword!=''){ $this->db->where("did LIKE '".$keyword."%'"); }
		$this->db->where("delete_date is NULL");
		$this->db->order_by('id','desc');
		$this->db->limit($pagesize,$offset);
		$query = $this->db->get();
		$dept = $query->result_array();
		foreach($dept as $dept)
		{
			$this->db->select('count(*) as mapped');
			$this->db->from('call_flow_number');
			$this->db->where("did ='".$dept["did"]."'"); $this->db->where("type ='1'");
			$this->db->order_by('number','desc');
			$mquery = $this->db->get();
			$mapped = $mquery->row_array();
			$dept["mcount"] = $mapped["mapped"];
			
			$this->db->select('count(*) as fallback');
			$this->db->from('call_flow_number');
			$this->db->where("did ='".$dept["did"]."'"); $this->db->where("type ='2'");
			$this->db->order_by('number','desc');
			$fquery = $this->db->get();
			$fallback = $fquery->row_array();
			$dept["fcount"] = $fallback["fallback"];
			
			$this->db->select('count(*) as offhour');
			$this->db->from('call_flow_number');
			$this->db->where("did ='".$dept["did"]."'"); $this->db->where("type ='3'");
			$this->db->order_by('number','desc');
			$oquery = $this->db->get();
			$offhour = $oquery->row_array();
			$dept["offcount"] = $offhour["offhour"];
			
			$this->db->select('count(*) as hcount');
			$this->db->from('call_flow_number');
			$this->db->where("did ='".$dept["did"]."'"); $this->db->where("type ='4'");
			$this->db->order_by('number','desc');
			$hquery = $this->db->get();
			$hcount = $hquery->row_array();
			$dept["hcount"] = $hcount["hcount"];
			
			$dept["allcount"] =$dept["mcount"]+$dept["fcount"]+$dept["offcount"]+$dept["hcount"];
			
			$final[] = $dept;
		}
		$response = array('tabledata' => $final, 'totalCount' => $count);
		return $response;
	}
	
	public function option_insert($data)
	{
		if($this->db->insert_batch('did_tbl',$data))
		{ return 1; }
		else
		{ return 0; }
	}
	
	public function did_insert($data)
	{
		if($this->db->insert('did_tbl',$data))
		{ return 1; }
		else
		{ return 0; }
	}
	
	public function holiday_details($pagesize,$offset,$keyword)
	{
		$qry = '';
		if($keyword!=''){ $this->db->where("date LIKE '".$keyword."%'"); }
		$count = $this->db->count_all_results('holiday');
		
		$final = array();
		$this->db->select('*');
		$this->db->from('holiday');
		if($keyword!=''){ $this->db->where("date LIKE '".$keyword."%'"); }
		$this->db->order_by('id','desc');
		$this->db->limit($pagesize,$offset);
		$query = $this->db->get();
		$dept = $query->result_array();
		$response = array('tabledata' => $dept, 'totalCount' => $count);
		return $response;
	}
	
	public function holiday_insert($data)
	{
		if($this->db->insert_batch('holiday',$data))
		{ return 1; }
		else
		{ return 0; }
	}
	
	public function prompt_details($pagesize,$offset,$keyword)
	{
		$qry = '';
		if($keyword!=''){ $this->db->where("name LIKE '".$keyword."%'"); }
		$count = $this->db->count_all_results('prompts');
		
		$final = array();
		$this->db->select('*');
		$this->db->from('prompts');
		if($keyword!=''){ $this->db->where("name LIKE '".$keyword."%'"); }
		$this->db->order_by('id','desc');
		$this->db->limit($pagesize,$offset);
		$query = $this->db->get();
		$dept = $query->result_array();
		$response = array('tabledata' => $dept, 'totalCount' => $count);
		return $response;
	}
	
	public function prompt_insert($data) 
	{		
		if($this->db->insert('prompts',$data))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	public function prompt_update($data,$id) 
	{		
		$this->db->where('id', $id);
		if($this->db->update('prompts',$data))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	public function prompt_details_all()
	{
		$this->db->select('*');
		$this->db->from('prompts');
		$this->db->order_by('id','desc');
		$query = $this->db->get();
		$dept = $query->result_array();
		return $dept;
	}
	
	public function timegroup_details_all()
	{
		$this->db->select('*');
		$this->db->from('timegroup');
		$this->db->order_by('id','desc');
		$query = $this->db->get();
		$dept = $query->result_array();
		return $dept;
	}
	
	public function timegroup_details($pagesize,$offset,$keyword)
	{
		$qry = '';
		if($keyword!=''){ $this->db->where("name LIKE '".$keyword."%'"); }
		$count = $this->db->count_all_results('timegroup');
		
		$final = array();
		$this->db->select('*');
		$this->db->from('timegroup');
		if($keyword!=''){ $this->db->where("name LIKE '".$keyword."%'"); }
		$this->db->order_by('id','desc');
		$this->db->limit($pagesize,$offset);
		$query = $this->db->get();
		$dept = $query->result_array();
		$response = array('tabledata' => $dept, 'totalCount' => $count);
		return $response;
	}
	
	public function timegroup_insert($data)
	{
		if($this->db->insert_batch('timegroup',$data))
		{ return 1; }
		else
		{ return 0; }
	}
	
	public function did_block_details($pagesize,$offset,$keyword)
	{
		$qry = '';
		if($keyword!=''){ $this->db->where("did LIKE '".$keyword."%'"); }
		$count = $this->db->count_all_results('blocked_no');
		
		$final = array();
		$this->db->select('*');
		$this->db->from('blocked_no');
		if($keyword!=''){ $this->db->where("did LIKE '".$keyword."%'"); }
		$this->db->order_by('id','desc');
		$this->db->limit($pagesize,$offset);
		$query = $this->db->get();
		$dept = $query->result_array();
		$response = array('tabledata' => $dept, 'totalCount' => $count);
		return $response;
	}
	
	public function cdr_indetails($clid,$sdate,$edate,$disposition,$sd)
	{
		$qry = '';
		if($sdate!=''){ $this->db->where("(calldate>='".$sdate."' and calldate<='".$edate."')"); }
		if($disposition!=''){ $this->db->where("disposition='".$disposition."'"); }
		if($sd!=''){ $this->db->where("(src='".$sd."' or dst='".$sd."')"); }
		$this->db->where("(clid='".$clid."')"); $this->db->where("(disposition='ANSWER')");
		$count = $this->db->count_all_results('custom_cdr');
		
		$final = array();
		$this->db->select('*');
		$this->db->from('custom_cdr');
		if($sdate!=''){ $this->db->where("(calldate>='".$sdate."' and calldate<='".$edate."')"); }
		if($disposition!=''){ $this->db->where("disposition='".$disposition."'"); }
		if($sd!=''){ $this->db->where("(src='".$sd."' or dst='".$sd."')"); }
		$this->db->where("(clid='".$clid."')");  $this->db->where("(disposition='ANSWER')");
		$this->db->order_by('id','desc');
		//$this->db->limit($pagesize,$offset);
		$query = $this->db->get();
		$dept = $query->result_array(); $final = array();
		foreach($dept as $dept)
		{
			$dept["recordings"] = str_replace("/","~",$dept["recording"]);
			$dsstt = explode("@",$dept["dst"]);
			$dept["dialed"] = @$dsstt[0]; 
			$final[] = $dept;
		}
		$response = array('tabledata' => $final, 'totalCount' => $count);
		return $response;
	}
	
	public function cdr_indetails_src($clid,$sdate,$edate,$disposition,$sd)
	{
		$qry = '';
		if($sdate!=''){ $this->db->where("(calldate>='".$sdate."' and calldate<='".$edate."')"); }
		if($disposition!=''){ $this->db->where("disposition='".$disposition."'"); }
		if($sd!=''){ $this->db->where("(src='".$sd."' or dst='".$sd."')"); }
		$this->db->where("(src='".$clid."')"); $this->db->where("(disposition='ANSWER')");
		$count = $this->db->count_all_results('custom_cdr');
		
		$final = array();
		$this->db->select('*');
		$this->db->from('custom_cdr');
		if($sdate!=''){ $this->db->where("(calldate>='".$sdate."' and calldate<='".$edate."')"); }
		if($disposition!=''){ $this->db->where("disposition='".$disposition."'"); }
		if($sd!=''){ $this->db->where("(src='".$sd."' or dst='".$sd."')"); }
		$this->db->where("(src='".$clid."')");  $this->db->where("(disposition='ANSWER')");
		$this->db->order_by('id','desc');
		//$this->db->limit($pagesize,$offset);
		$query = $this->db->get();
		$dept = $query->result_array(); $final = array();
		foreach($dept as $dept)
		{
			$dept["recordings"] = str_replace("/","~",$dept["recording"]);
			$dsstt = explode("@",$dept["dst"]);
			$dept["dialed"] = @$dsstt[0]; 
			$final[] = $dept;
		}
		$response = array('tabledata' => $final, 'totalCount' => $count);
		return $response;
	}
	
	public function cdr_details($pagesize,$offset,$sdate,$edate,$disposition,$sd,$asc)
	{
		$qry = '';
		if($sdate!=''){ $this->db->where("(calldate>='".$sdate."' and calldate<='".$edate."')"); }
		$this->db->where("disposition='ANSWER'");
		$count = $this->db->count_all_results('custom_cdr');
		
		$final = array();
		$this->db->select('calldate,clid,src,count(*) as numrows,sum(billsec) as billsum');
		$this->db->from('custom_cdr');
		if($sdate!=''){ $this->db->where("(calldate>='".$sdate."' and calldate<='".$edate."')"); }
		if($disposition!=''){ $this->db->where("disposition='".$disposition."'"); }
		if($sd!=''){ $this->db->where("(src='".$sd."' or dst='".$sd."')"); }
		$this->db->where("disposition='ANSWER'");
		$this->db->group_by('clid','desc');
		if($asc!=''){ $this->db->order_by('numrows',$asc); } else { $this->db->order_by('id','desc');  }
		$this->db->limit($pagesize,$offset);
		$query = $this->db->get();
		$count = $query->num_rows(); 
		$dept = $query->result_array();  $final = array();
		foreach($dept as $dept)
		{
			$this->db->select('*');
			$this->db->from('blocked_no');
			$this->db->where("(clid='".$dept["clid"]."')");
			//$this->db->where("(did='".$dept["src"]."')");
			//$this->db->where("(isActive='1')");
			$queryun = $this->db->get();
			$deptun = $queryun->row_array();  
			if($queryun->num_rows() == 0) $dept["block"] = 'Y'; else  $dept["block"] = 'N'; 
			
			$today = date("Y-m-d"); $seven = date('Y-m-d', strtotime('-7 days'));
			
			$this->db->select('count(*) as numrows');
			$this->db->from('custom_cdr');
			$this->db->where("(calldate>='".$seven."' and calldate<='".$today."') and clid='".$dept["clid"]."' and disposition='ANSWER'");
			$queryw = $this->db->get(); 
			$deptw = $queryw->row_array(); 
			$dept["weeklynumrows"] = $deptw["numrows"];
			$clidweekly = $deptw["numrows"];
			
			$this->db->select('count(*) as allrows,sum(billsec) as billsum');
			$this->db->from('custom_cdr');
			$this->db->where("clid='".$dept["clid"]."' and disposition='ANSWER'");
			$queryw = $this->db->get(); 
			$deptw = $queryw->row_array(); 
			$clidall = $deptw["allrows"]; $clidallsum = $deptw["billsum"];
			
			$this->db->select('count(*) as numrows');
			$this->db->from('custom_cdr');
			$this->db->where("(calldate>='".$seven."' and calldate<='".$today."') and src='".$dept["src"]."' and disposition='ANSWER'");
			$queryw = $this->db->get(); 
			$deptw = $queryw->row_array(); 
			$dept["weeklynumrows"] = $deptw["numrows"];
			$srcweekly = $deptw["numrows"];
			
			$this->db->select('count(*) as allrows,sum(billsec) as billsum');
			$this->db->from('custom_cdr');
			$this->db->where("src='".$dept["src"]."' and disposition='ANSWER'");
			$queryw = $this->db->get(); 
			$deptw = $queryw->row_array(); 
			$srcall = $deptw["allrows"];  $srcallsum = $deptw["billsum"];
			
			$dept["clidata"] = array("clid"=>$dept["clid"],"counts"=>$clidall,"weekly"=>$clidweekly,"clidallsum"=>$clidallsum);
			$dept["srcdata"] = array("src"=>$dept["src"],"counts"=>$srcall,"weekly"=>$srcweekly,"srcallsum"=>$srcallsum);
			$final[] = $dept;
		}
		$response = array('tabledata' => $final, 'totalCount' => $count);
		return $response;
	}
	
	public function cdr_details_report($pagesize,$offset,$sdate,$edate,$disposition,$sd)
	{
		$qry = '';
		if($sdate!=''){ $this->db->where("(calldate>='".$sdate."' and calldate<='".$edate."')"); }
		if($disposition!=''){ $this->db->where("disposition='".$disposition."'"); }
		if($sd!=''){ $this->db->where("(src='".$sd."'  or dst like '%".$sd."%' or clid like '%".$sd."%')"); }
		$count = $this->db->count_all_results('custom_cdr');
		
		$final = array();
		$this->db->select('*');
		$this->db->from('custom_cdr');
		//$this->db->where("disposition='ANSWER'");
		if($sdate!=''){ $this->db->where("(calldate>='".$sdate."' and calldate<='".$edate."')"); }
		if($disposition!=''){ $this->db->where("disposition='".$disposition."'"); }
		if($sd!=''){ $this->db->where("(src='".$sd."' or dst like '%".$sd."%' or clid like '%".$sd."%')"); }
		//$this->db->group_by('clid','desc');
		$this->db->order_by('id','desc');
		$this->db->limit($pagesize,$offset);
		$query = $this->db->get();
		$dept = $query->result_array(); 
		foreach($dept as $dept)
		{
			$this->db->select('*');
			$this->db->from('blocked_no');
			$this->db->where("(clid='".$dept["clid"]."')");
			//$this->db->where("(did='".$dept["src"]."')");
			//$this->db->where("(isActive='1')");
			$queryun = $this->db->get();
			$deptun = $queryun->row_array();  
			if($queryun->num_rows() == 0) $dept["block"] = 'Y'; else  $dept["block"] = 'N'; 
			$dept["billsecs"] = $dept["duration"] -  $dept["billsec"]; 
			$dsstt = explode("@",$dept["dst"]);
			$dept["cpno"] = @$dsstt[0]; 
			$final[] = $dept;
		}
		$response = array('tabledata' => $final, 'totalCount' => $count);
		return $response;
	}
	
	public function cdr_details_report_unanswered_popup($sd)
	{
		$qry = '';
		if($sd!=''){ $this->db->where("(uniqueid='".$sd."')"); }
		$count = $this->db->count_all_results('unans_cdr');
		
		$final = array();
		$this->db->select('*');
		$this->db->from('unans_cdr');
		if($sd!=''){ $this->db->where("(uniqueid='".$sd."')"); }
		$this->db->order_by('id','desc');
		$query = $this->db->get();
		$dept = $query->result_array(); 
		
		foreach($dept as $dept)
		{
			$this->db->select('*');
			$this->db->from('blocked_no');
			$this->db->where("(clid='".$dept["clid"]."')");
			//$this->db->where("(did='".$dept["src"]."')");
			//$this->db->where("(isActive='1')");
			$queryun = $this->db->get();
			$deptun = $queryun->row_array();  
			if($queryun->num_rows() == 0) $dept["block"] = 'Y'; else  $dept["block"] = 'N'; 
			$dept["billsecs"] = $dept["duration"] -  $dept["billsec"]; 
			$final[] = $dept;
		}
		$response = array('tabledata' => $final, 'totalCount' => $count);
		return $response;
	}
	
	public function cdr_details_report_unanswered($pagesize,$offset,$sdate,$edate,$disposition,$sd)
	{
		$qry = '';
		if($sdate!=''){ $this->db->where("(calldate>='".$sdate."' and calldate<='".$edate."')"); }
		if($disposition!=''){ $this->db->where("report_disposition='".$disposition."'"); }
		if($sd!=''){ $this->db->where("(src='".$sd."' or dst like '%".$sd."%' or clid like '%".$sd."%')"); }
		$this->db->where("disposition!='ANSWERED'");
		$count = $this->db->count_all_results('unans_cdr');
		
		$final = array();
		$this->db->select('*');
		$this->db->from('unans_cdr');
		if($sdate!=''){ $this->db->where("(calldate>='".$sdate."' and calldate<='".$edate."')"); }
		if($disposition!=''){ $this->db->where("report_disposition='".$disposition."'"); }
		if($sd!=''){ $this->db->where("(src='".$sd."' or dst like '%".$sd."%' or clid like '%".$sd."%')"); }
		$this->db->where("disposition!='ANSWERED'");
		//$this->db->group_by('clid','desc');
		$this->db->order_by('id','desc');
		$this->db->limit($pagesize,$offset);
		$query = $this->db->get();
		$dept = $query->result_array(); 
		
		foreach($dept as $dept)
		{
			$this->db->select('*');
			$this->db->from('blocked_no');
			$this->db->where("(clid='".$dept["clid"]."')");
			//$this->db->where("(did='".$dept["src"]."')");
			//$this->db->where("(isActive='1')");
			$queryun = $this->db->get();
			$deptun = $queryun->row_array();  
			if($queryun->num_rows() == 0) $dept["block"] = 'Y'; else  $dept["block"] = 'N'; 
			$dept["billsecs"] = $dept["duration"] -  $dept["billsec"]; 
			$final[] = $dept;
		}
		$response = array('tabledata' => $final, 'totalCount' => $count);
		return $response;
	}
	
	public function did_block_insert($data)
	{
		if($this->db->insert_batch('blocked_no',$data))
		{ return 1; }
		else
		{ return 0; }
	}
	
	public function all_details_search($key)
	{
		$key = str_replace(' ', '%', $key);
		$this->db->select('*');
		$this->db->from('ama_category');
		$this->db->where('content_descp like "%'.$key.'%"');
		$querys = $this->db->get();
		$cata = $querys->result_array();
			
		return $cata;
	}
	
	public function details_prevnext($key)
	{
		$final = array();
		$this->db->select('*');
		$this->db->from('ama_category');
		$this->db->where('ama_category_id = "'.$key.'"');
		$querys = $this->db->get();
		$cata = $querys->row_array();
		return $cata;
	}
}
