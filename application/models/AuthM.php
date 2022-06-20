<?php

class AuthM extends CI_Model
{
	var $table = 'accounts';
	var $column_order = array('accounts_email', 'accounts_status', 'accounts_verified', 'ai_first_name');
	var $column_search = array('accounts_id', 'accounts_email', 'accounts_status', 'accounts_verified', 'ai_first_name');
	var $order = array('accounts_id' => 'desc');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		$this->db->from($this->table);

		$i = 0;

		foreach ($this->column_search as $item) // loop column 
		{
			if ($_POST['search']['value']) // if datatable send POST for search
			{

				if ($i === 0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if (count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}

		if (isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->order)) {
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1)
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

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('bank_id', $id);
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
	public function updateGameAccount($where, $data)
	{
		$this->db->update('users', $data, $where);
		return $this->db->affected_rows();
	}
	public function delete_by_id($id)
	{
		$this->db->where('bank_id', $id);
		$this->db->delete($this->table);
	}


	function getData()
	{
		$this->db->from($this->table);
		$this->db->where('status', '1');
		$query = $this->db->get();
		return $query->result();
	}

	// new query
	function get_account_by_id($passkey)
	{
		$q = $this->db->select('a.*')
			->from('users a')
			->where('user_id', $passkey)->get();

		if ($q->num_rows() > 0)
			return $q->row();
		else
			return NULL;
	}
}
