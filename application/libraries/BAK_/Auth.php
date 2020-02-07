<?php

/**
 * Authority and Permission Class
 * @author Wiwid Lukiyanto <wiwid@wiwid.org>
 */
class Auth {

	function is_logged_in() {

		$this->obj =& get_instance();

		if ($this->obj->session) {

			if ($this->obj->session->userdata('logged_in'))
				return TRUE;
			else
				return FALSE;

		} else {
			return FALSE;
		}
	}

	function is_have_perm($perm_name, $admin_id = 0) {
		// echo $perm_name;
		$this->obj =& get_instance();
		
		if($admin_id === 0)
			$admin_id = $this->obj->session->userdata['ADMIN']['admin_id'];

		if(is_array($perm_name)) {

			foreach($perm_name as $perm_value) {

				if(empty($perm_value))
					return TRUE;

//				echo $perm_value;
				$perm_group_ids = $this->obj->m_perm->admin_perm_group_ids_select($admin_id);
//				print_r($perm_groups_id);
//				echo $perm_group_id." ";

				foreach($perm_group_ids as $perm_group_id) {
					$admin_perm = $this->obj->m_perm->admin_perm_select($perm_group_id);

					$perm_code = $this->obj->m_perm->perm_code_select($perm_value);
	//				echo $perm_code." ";
					@$perm_have = substr_count($admin_perm, $perm_code);
	//				echo $perm_have." ";

					if($perm_have || ($admin_perm == "*"))
						return TRUE;
				}


			}
			return FALSE;

		} else {

			$perm_group_ids = $this->obj->m_perm->admin_perm_group_ids_select($admin_id);
//				echo $perm_group_id." ";

			foreach($perm_group_ids as $perm_group_id) {
			/* //disabled due security issue
				if(empty($perm_group_id))
					return TRUE;
			*/
				$admin_perm = $this->obj->m_perm->admin_perm_select($perm_group_id);
	//				echo $member_perm." ";
				$perm_code = $this->obj->m_perm->perm_code_select($perm_name);
	//				echo $perm_code." ";
				@$perm_have = substr_count($admin_perm, $perm_code);

				if($perm_have || ($admin_perm == "*"))
					return TRUE;

			}

			return FALSE;

		}

	}

}