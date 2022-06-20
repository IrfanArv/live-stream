<?php

class Accounts_model extends CI_Model {
    var $table = 'accounts';
	var $column_order = array('accounts_email','accounts_status','accounts_verified','ai_first_name');
	var $column_search = array('accounts_id','accounts_email','accounts_status','accounts_verified','ai_first_name');
    var $order = array('accounts_id' => 'desc');

    public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

    
	private function _get_datatables_query()
	{
		$this->db->from($this->table);
        $this->db->where('accounts_type', 'webadmin');
		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}
	private function _get_datatables_query2()
	{
		$this->db->from($this->table);
        $this->db->where('accounts_type', 'customers');
		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables() 
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function get_datatables2() 
	{
		$this->_get_datatables_query2();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	function count_filtered2()
	{
		$this->_get_datatables_query2();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function count_all2()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('accounts_id',$id);
		$query = $this->db->get();
		return $query->row();
	}

	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update($where, $data) 
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$this->db->where('accounts_id', $id);
		$this->db->delete($this->table);
	}


    // Admin login
    function login_admin($username, $password) {
        $remember = $this->input->post('remember');
        $this->db->select('accounts_email,accounts_password,accounts_id,accounts_type,ai_first_name,ai_last_name');
        $this->db->where('accounts_email', $username);
        $this->db->where('accounts_password', sha1($password));
        $this->db->where('accounts_is_admin', '1');
        $this->db->where('accounts_status', 'yes');
        $q = $this->db->get('accounts');
        $user = $q->result();
        $num = $q->num_rows();
        if ($num > 0) {
            if (empty ($remember)) {
                $this->session->sess_expire_on_close = TRUE;
            }
            $this->session->set_userdata('logged_admin', $user[0]->accounts_id);
            $this->session->set_userdata('logged_id', $user[0]->accounts_id);
            if ($user[0]->accounts_type == "webadmin") {
                $this->session->set_userdata('logged_super_admin', 'superadmin');
                $this->session->set_userdata('accountType', 'Super Admin');
            }
            else {
                $this->session->set_userdata('accountType', 'Admin');
            }
            $this->session->set_userdata('logged_time', time());
            $this->session->set_userdata('role', $user[0]->accounts_type);
            $this->session->set_userdata('fullName', $user[0]->ai_first_name . " " . $user[0]->ai_last_name);
            
            return true;
        }
        else {
            return false;
        }
    }

    // check account customers
    public function checkEmail($username)
    {
      $this->db->where('accounts_email', $username);
      return $this->db->get('accounts')->row_array();
    }

    // customer register
    public function CustomerRegister($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }


    
}
