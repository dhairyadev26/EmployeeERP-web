<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Employee Model
 * 
 * Handles all database operations related to employee functions including
 * project assignments, work updates, and project tracking.
 * 
 * @package    Employee_ERP
 * @subpackage Models
 * @category   Model
 * @author     Development Team
 * @version    1.0.0
 */
class employee_model extends CI_Model
{
	/**
	 * Fetch employee projects with work history
	 * 
	 * Retrieves all projects assigned to a specific employee along with
	 * their work update history and project details.
	 * 
	 * @param string $value Employee ID
	 * @return object Database query result with joined project and work data
	 */
	public function fetch_project($value)
	{
		$data=array(
					'employee_id'	=> $value,
			);
		$result =$this->db->select('update_work.id,update_work.description,update_work.created_time,project_details.project_id,project_details.first_name,project_details.last_name,project_details.deadline,project_details.contact_number,project_details.contact_email')
						 ->where($data)
				 		 ->from('project_details')
				         ->join('update_work', 'project_details.project_id = update_work.project_id')
				         ->order_by('id','DESC')
		                 ->get();
		return $result;
	}
	
	/**
	 * Fetch all active project IDs
	 * 
	 * Returns a list of all active project IDs for dropdown/selection purposes
	 * 
	 * @return object Database query result with project IDs
	 */
	public function fetch_project_id()
	{
		$data=array(
					'status'	=> 0,
			);
		$result=$this->db->select('project_id')
						 ->where($data)
						 ->get('project_details');
		return $result;
	}
	
	/**
	 * Add work update for employee
	 * 
	 * Records daily work updates submitted by employees for their assigned projects
	 * 
	 * @param array $value Work update data from form
	 * @param string $employee_id Employee identifier
	 * @param string $employee_first_name Employee's first name
	 * @param string $employee_last_name Employee's last name
	 * @return object Database insertion result
	 */
	public function addwork($value,$employee_id,$employee_first_name,$employee_last_name)
	{
		date_default_timezone_set('Asia/Kolkata');
		$current_time=date('Y-m-d H:i:s');
		$result=$this->db->select('project_name')
						 ->where('project_id',$value['project_id'])
						 ->get('project_details');
		$project_name=$result->result_array()[0]['project_name'];
		$employee_data=array(
							 'last_project_id'   => $value['project_id'],
							 'last_project_name' => $project_name,
							 'last_work_time'	 => $current_time,
						);
		$this->db->where('employee_id', $employee_id);
		$this->db->update('employee_details', $employee_data);
		$project_data=array(
							 'last_employee_id'   => $employee_id,
							 'last_employee_name' => $employee_first_name.' '.$employee_last_name,
							 'last_work_time'	  => $current_time,
						);
		$this->db->where('project_id', $value['project_id']);
		$this->db->update('project_details', $project_data);
		$work_data=array(
					'project_id'	=> $value['project_id'],
					'employee_id'	=> $employee_id,
					'description'	=> $value['description'],
					'created_time'	=> $current_time,
			);
		$this->db->insert('update_work', $work_data);
		return $this->db->affected_rows();
	}	
}
?>