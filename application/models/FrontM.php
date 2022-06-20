<?php

class FrontM extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function update_common($where, $data)
	{
		$this->db->update("commons", $data, $where);
		return $this->db->affected_rows();
	}

	public function getUser($id_user)
	{
		$q = $this->db->select('a.*')
			->from('users a')
			->where('user_id', $id_user)
			->get();

		if ($q->num_rows() > 0)
			return $q->row();
		else
			return NULL;
	}

	public function update_user($where, $data)
	{
		$this->db->update('users', $data, $where);
		return $this->db->affected_rows();
	}
	public function signup($data)
	{
		$this->db->insert('users', $data);
		$id = $this->db->insert_id();
		return (isset($id)) ? $id : FALSE;
		$insert = $this->db->insert('users', $data);
		return $insert;
	}

	public function getRoomStream($room_user)
	{

		$q = $this->db->select('a.*')
			->from('rooms a')
			->like('branch_1', $room_user)
			->or_like('branch_2', $room_user)
			->or_like('branch_3', $room_user)
			->or_like('branch_4', $room_user)
			->or_like('branch_5', $room_user)
			->or_like('branch_6', $room_user)
			->or_like('branch_7', $room_user)
			->or_like('branch_8', $room_user)
			->where('status_room', 1)
			->order_by('id_room', "desc")
			->get();

		if ($q->num_rows() > 0)
			return $q->row();
		else
			return NULL;
	}

	public function cekStream()
	{
		$q = $this->db->select('a.*')
			->from('rooms a')
			->where('status_room', 1)
			->order_by('id_room', "desc")
			->get();

		if ($q->num_rows() > 0)
			return $q->row();
		else
			return NULL;
	}

	public function common_quiz()
	{
		$q = $this->db->select('a.*')
			->from('commons a')
			->get();

		if ($q->num_rows() > 0)
			return $q->row();
		else
			return NULL;
	}

	public function jalanQuiz($where, $data)
	{
		$this->db->update("commons", $data, $where);
		return $this->db->affected_rows();
	}


	public function resetUserGame($where, $data)
	{
		$this->db->update("users", $data, $where);
		return $this->db->affected_rows();
	}

	public function getLink()
	{
		$this->db->select("*");
		$this->db->from("link");
		$this->db->where('status', 1);
		$query = $this->db->get();
		return $query->result();
	}

	public function cekQuiz()
	{
		$this->db->select("quiz_status");
		$this->db->from("commons");
		$query = $this->db->get();
		return $query->row()->quiz_status;
	}
	// get total quiz
	function getQuiz()
	{
		$this->db->select("*");
		$this->db->from("questions");
		$query = $this->db->get();
		return $query->num_rows();
	}

	// function get_score()
	// {
	// 	$hasil = $this->db->query("SELECT * FROM users WHERE game_1_status =1 ORDER BY game_1_score DESC LIMIT 10 ");
	// 	return $hasil;
	// }

	public function get_score()
	{
		$this->db->select("*");
		$this->db->from("users");
		$this->db->where('game_1_status', 1);
		$this->db->order_by("game_1_score desc, created asc");
		$this->db->limit(10);

		$query = $this->db->get();
		return $query->result();
	}

	function get_semua_vote()
	{
		$this->db->select("*");
		$this->db->from("users");
		$this->db->where('voted', 1);
		$query = $this->db->get();
		return $query->num_rows();
	}
}
