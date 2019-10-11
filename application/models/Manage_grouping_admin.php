<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage_grouping_admin extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function taskmanager_modules()
	{
		$this->help = $this->load->database('taskmanager', TRUE);
		$this->help->select('*');
		$this->help->from('ap_modules');
		$query = $this->help->get();
		return $tabledata = $query->result_array();
	}
	
	public function taskmanager_modules_update($data,$id)
	{
		$this->help = $this->load->database('taskmanager', TRUE);
		$this->help->where('module_id',$id);
		if($this->help->update('ap_modules', $data))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	public function deptlist($offset,$pagesize,$keyword)
	{
		$qry= "";
		
		if($keyword != '')
		{
			$qry.= "(ama_department_name LIKE '%".$keyword."%' OR ama_department_code LIKE '%".$keyword."%' )";
		}
		
		
		if($qry != ''){ $this->db->where($qry); }
		$count = $this->db->count_all_results('ama_departments');
				
		$this->db->select('*');
		$this->db->from('ama_departments');
		if($qry != ''){ $this->db->where($qry); }
		$this->db->order_by('ama_department_id','desc');
		$this->db->limit($pagesize,$offset);
		$query = $this->db->get();
		$tabledata = $query->result_array();
		
		$result = array('tabledata' => $tabledata, 'totalCount' => $count);
		
		return $result;
	}
	
	public function catagorylist($offset,$pagesize,$keyword)
	{
		$qry= "";
		
		if($keyword != '')
		{
			$qry.= "(ama_category_name LIKE '%".$keyword."%' OR ama_category_code LIKE '%".$keyword."%' )";
		}
		
		if($qry != ''){ $this->db->where($qry); }
		$this->db->where("parent_id","0");
		$count = $this->db->count_all_results('ama_category');
				
		$this->db->select('*');
		$this->db->from('ama_category');
		$this->db->where("parent_id","0");
		if($qry != ''){ $this->db->where($qry); }
		$this->db->order_by('ama_category_id','desc');
		$this->db->limit($pagesize,$offset);
		$query = $this->db->get();
		$tabledata = $query->result_array();
		
		$result = array('tabledata' => $tabledata, 'totalCount' => $count);
		
		return $result;
	}
	
	public function subcatagorylist($offset,$pagesize,$keyword)
	{
		$qry= "";
		
		if($keyword != '')
		{
			$qry.= "(ama_category_name LIKE '%".$keyword."%' OR ama_category_code LIKE '%".$keyword."%' )";
		}
		
		if($qry != ''){ $this->db->where($qry); }
		$this->db->where("parent_id!='0'");
		$count = $this->db->count_all_results('ama_category');
				
		$this->db->select('*');
		$this->db->from('ama_category');
		$this->db->where("parent_id!='0'");
		if($qry != ''){ $this->db->where($qry); }
		$this->db->order_by('ama_category_id','desc');
		$this->db->limit($pagesize,$offset);
		$query = $this->db->get();
		$tabledata = $query->result_array();
		
		$result = array('tabledata' => $tabledata, 'totalCount' => $count);
		
		return $result;
	}
	
	public function getDeptDetails($val)
	{
		$this->db->select('*');
		$this->db->from('ama_departments');
		$this->db->where("ama_department_code='".$val."'");
		$query = $this->db->get();
		return $result = $query->row_array();
	}
	
	public function getDeptCataDetails($val)
	{
		$this->db->select('*');
		$this->db->from('ama_category');
		$this->db->where("ama_department_id='".$val."'");
		$this->db->order_by('ama_category_id','DESC');
		$this->db->limit(1);
		$query = $this->db->get();
		return $result = $query->row_array();
	}
	
	public function getDeptNo()
	{
		$this->db->select('*');
		$this->db->from('ama_autogeneration');
		$query = $this->db->get();
		$result = $query->row_array();
		return ($result["department_id"]+1);
	}
	
	public function getAutoNo()
	{
		$this->db->select('*');
		$this->db->from('ama_autogeneration');
		$query = $this->db->get();
		$result = $query->row_array();
		return ($result);
	}
	public function createDept($data)
	{
		
		if($this->db->insert('ama_departments',$data))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	public function updateDept($data,$id)
	{
		$this->db->where('ama_department_id',$id);
		if($this->db->update('ama_departments', $data))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	public function deleteDept($id)
	{
		$this->db->where('ama_department_id',$id);
		if($this->db->delete('ama_departments'))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	public function updateAutoTable($data)
	{
		if($this->db->update('ama_autogeneration', $data))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	public function departmentList()
	{
		$this->db->select('*');
		$this->db->from('ama_departments');
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	
	public function categoyList($id)
	{
		$this->db->select('*');
		$this->db->from('ama_category');
		$this->db->where('ama_department_id',$id);
		$this->db->where('parent_id=0');
		$query = $this->db->get();
		$result = $query->result_array();
		return ($result);
	}
	
	public function createCata($data)
	{
		if($this->db->insert('ama_category',$data))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	public function updateCata($id,$data)
	{
		$this->db->where('ama_category_id',$id);
		if($this->db->update('ama_category', $data))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	public function deleteCata($id)
	{
		$this->db->where('ama_category_id',$id);
		if($this->db->delete('ama_category'))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	public function editdata($eid)
	{
		$this->db->select('*');
		$this->db->from('ama_users');
		$this->db->where('id',$eid);
		$query = $this->db->get();
		$result = $query->row_array();
		return $result;
	}
	
	public function selectdata($eid,$pwd)
	{
		$this->db->select('*');
		$this->db->from('ama_users');
		$this->db->where('apuser',$eid);
		$this->db->where('appassword',$pwd);
		$query = $this->db->get();
		if($query->num_rows() >0)
		{
			$result = $query->row_array();
		}
		else
		{
			$result = '';
		}
		return $result;
	}
	
	public function create($data)
	{
		if($this->db->insert('ama_users',$data))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	public function update($id,$data)
	{
		$this->db->where('id', $id);
		if($this->db->update('ama_users', $data))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	public function delete($id) 
	{		
		$this->db->where('id', $id);	
		$this->db->delete('ama_users');
	}
	
	public function getdepartment_product($key)
	{
		$this->db->select('pro.*,dep.ama_department_name as title');
		$this->db->from('ama_products as pro');
		$this->db->join('ama_departments as dep','dep.ama_department_code=pro.department_code','left');
		$this->db->where('pro.department_code',$key);
		$this->db->order_by('dep.ama_department_name','ASC');
		$this->db->order_by('pro.itemname','ASC');
		$query = $this->db->get();
		$res = $query->result_array();
		return $res;
	}
	
	public function getcategory_product($key)
	{
		$this->db->select('pro.*, cat.ama_category_name as title');
		$this->db->from('ama_products as pro');
		$this->db->join('ama_category as cat','cat.ama_category_code=pro.cata_code','left');
		$this->db->where('pro.cata_code',$key);
		$this->db->order_by('cat.ama_category_name','ASC');
		$this->db->order_by('pro.itemname','ASC');
		$query = $this->db->get();
		$res = $query->result_array();
		return $res;
	}
	
	public function getsubcategory_product($key)
	{
		$this->db->select('pro.*, cat.ama_category_name as title');
		$this->db->from('ama_products as pro');
		$this->db->join('ama_category as cat','cat.ama_category_code=pro.subcata_code','left');
		$this->db->where('pro.subcata_code',$key);
		$this->db->order_by('cat.ama_category_name','ASC');
		$this->db->order_by('pro.itemname','ASC');
		$query = $this->db->get();
		$res = $query->result_array();
		return $res;
	}
	
	public function getdepartment_summary($key)
	{
		$this->db->select('dep.*,cat.*,cat.ama_department_id as cat_dep_id');
		$this->db->from('ama_departments as dep');
		$this->db->join('ama_category as cat','cat.ama_department_id = dep.ama_department_code','right');
		if($key != 0){ $this->db->where('dep.ama_department_code',$key); }
		$this->db->order_by('dep.ama_department_name','ASC');
		$query = $this->db->get();
		$res = $query->result_array();
		return $res;
	}
	
	public function getdepartment($key)
	{
		$this->db->select('*');
		$this->db->from('ama_departments');
		if($key != '0'){ $this->db->where('ama_department_code',$key); }
		$this->db->group_by('ama_department_code');
		$this->db->order_by('ama_department_name','ASC');
		$query = $this->db->get();
		$res = $query->result_array();
		return $res;
	}
	
	public function getcatagory($key)
	{
		$this->db->select('*');
		$this->db->from('ama_category');
		if($key != '0'){ $this->db->where('ama_department_id',$key); }
		$this->db->where('parent_id','0');
		$this->db->group_by('ama_category_code');
		$this->db->order_by('ama_category_name','ASC');
		$query = $this->db->get();
		$res = $query->result_array();
		return $res;
	}
}
