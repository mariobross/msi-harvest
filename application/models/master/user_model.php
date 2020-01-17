<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_Model extends CI_Model{

    function __construct(){
        parent::__construct(); 
    }

    function check_username_exist($username) {

        //$query = $this->db->select('email_id')
        $this->db->select('admin_id');
        $this->db->from('d_admin');
        $this->db->where('admin_username', $username);
        //->_compile_select();
        //echo $query;
        $rows = $this->db->count_all_results();
        //echo $this->db->last_query();

        if($rows)
            return TRUE;
        else
            return FALSE;
    }

    function check_username_password($username, $password) {

		$return = array();

		$this->db->select('admin_id');
		$this->db->from('d_admin');
		$this->db->where('admin_username', $username);
		$this->db->where('admin_password', md5($password));
			//->_compile_select();

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			$return = $query->row_array();
			$return['username_right'] = TRUE;
			$return['password_right'] = TRUE;
		} else {
			$return['admin_id'] = FALSE;
			$return['admin_right'] = TRUE;
			$return['username_right'] = TRUE;
			$return['password_right'] = FALSE;
		}

		return $return;
    }

    function admin_select($admin_id = 0) {

		$admin_id = (int) $admin_id;

		if(empty($admin_id)){
			if (!empty($this->session->userdata['ADMIN']))
			    $admin_id = $this->session->userdata['ADMIN']['admin_id'];
            else 
                $admin_id=0;
		}

		$this->db->from('d_admin, d_perm_group');
		$this->db->where('admin_id', $admin_id);
//		$this->db->where('group_id = perm_grups_id');
			//->_compile_select();

		$query = $this->db->get();
//		 echo $this->db->last_query(); echo '<hr />';

		if($query->num_rows() > 0) {
			$admin = $query->row_array();
			return $admin;
		} else {
			return FALSE;
		}

    }
    
    function check_employee_data($admin_id) {

		$return = array();

		$this->db->select('a.employee_id, a.nik, a.nama');
		$this->db->from('m_employee a, d_admin b');
		$this->db->where("a.employee_id = b.admin_emp_id and b.admin_id = ".$admin_id);
			//->_compile_select();

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			$return = $query->row_array();
		} else {
			$return = FALSE;
		}

		return $return;
    }
    
    function check_employee_exist($username) {

        //$query = $this->db->select('email_id')
        $this->db->select('employee_id');
        $this->db->from('m_employee');
        $this->db->where("(nik = '".$username."' OR email_kantor = '".$username."' OR email_pribadi = '".$username."') AND (portal_access = 1)");
        //	->_compile_select();
        //echo $query;
        $rows = $this->db->count_all_results();
        //echo $this->db->last_query();

        if($rows)
            return TRUE;
        else
            return FALSE;
    }

    function check_employee_password($username, $password) {

		$return = array();

		$this->db->select('employee_id,plant,nama,nik,portal_password,email_kantor');
		$this->db->from('m_employee');
		$this->db->where("(nik = '".$username."' OR email_kantor = '".$username."' OR email_pribadi = '".$username."') AND (portal_password = '".md5($password)."') ");
			//->_compile_select();

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			$return = $query->row_array();

			$this->db->select('admin_id');
			$this->db->from('d_admin');
			$this->db->where('admin_emp_id', intval($return['employee_id']));
			
			$query = $this->db->get();

			if($query->num_rows() > 0) {
				$admin_id = $query->row_array();
				$admin_id = $admin_id['admin_id'];
			} else {
				$admin_id = 1;
			}
			$return['admin_emp_id'] = $return['employee_id'];
			$return['admin_id'] = $admin_id;
			$return['username_right'] = TRUE;
			$return['password_right'] = TRUE;
		} else {
			$return['admin_id'] = FALSE;
			$return['admin_right'] = TRUE;
			$return['username_right'] = TRUE;
			$return['password_right'] = FALSE;
		}

		return $return;
    }
    
    function update_login($username,$swbipaddress) {
		$this->db->where('admin_username', $username);
		$this->db->set('admin_ipaddress',$swbipaddress);
		$this->db->set('admin_lastlogin','NOW()',false);
		if($this->db->update('d_admin'))
			return TRUE;
		else
			return FALSE;
	}

	function admin_update($data) {
		
		$this->db->where('admin_id', $data['admin_id']);

		if($this->db->update('d_admin', $data))
			return TRUE;
		else
			return FALSE;
	}
}   