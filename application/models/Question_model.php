<?php

class Question_model extends CI_Model
{

	//*== Init variable ==*/
	private $table_name = "questions";
	private $table_id = "id";


	//*== Construct ==*/
	function __construct()
	{
		parent::__construct();
	}


	//*== Get list data ==*/  
	function get_list($menu = '')
	{
		$this->db->select("a.*");
		if ($menu != '')
			$this->db->where("a.menu", $menu);
		$this->db->order_by("a.created_at", "DESC");
		$query = $this->db->get("$this->table_name a");

		if ($query->num_rows() > 0)
			return $query->result();
		else
			return NULL;
	}


	//*== Get list data ==*/  
	function get_list_summary()
	{
		$this->db->select("DATE_FORMAT(created_at,'%Y-%m-%d') as date, count(id) as total");
		$this->db->group_by("date");
		$this->db->order_by("a.created_at", "DESC");
		$query = $this->db->get("$this->table_name a");

		if ($query->num_rows() > 0)
			return $query->result();
		else
			return NULL;
	}


	//*== Get data ==*/  
	function get_detail($id)
	{
		$this->db->select("b.*");
		$this->db->where("question_id", $id);
		$this->db->order_by("b.sort_no", "ASC");
		$query = $this->db->get("question_details b");

		if ($query->num_rows() > 0)
			return $query->result();
		else
			return NULL;
	}


	//*== Get data ==*/  
	function get($id)
	{
		$this->db->select("a.*");
		$this->db->where("a.$this->table_id", $id);
		$query = $this->db->get("$this->table_name a");

		if ($query->num_rows() > 0)
			return $query->row();
		else
			return NULL;
	}

	//*== Get data ==*/  
	function get_first_question($trivia_id)
	{
		$this->db->select("a.*");
		$this->db->where("a.menu", $trivia_id);
		$this->db->order_by("id", 'ASC');
		$this->db->limit(1);
		$query = $this->db->get("$this->table_name a");

		if ($query->num_rows() > 0)
			return $query->row();
		else
			return NULL;
	}


	//*== Get data ==*/
	function get_next_question($trivia_id, $last_id)
	{
		$this->db->select("a.*");
		$this->db->where("a.menu", $trivia_id);
		$this->db->where("a.id > $last_id");
		$this->db->order_by("id", 'ASC');
		$this->db->limit(1);
		$query = $this->db->get("$this->table_name a");

		if ($query->num_rows() > 0)
			return $query->row();
		else
			return NULL;
	}


	//*== Get data ==*/  
	function check_answer($answer)
	{
		$this->db->select("b.is_correct");
		$this->db->where("b.id", $answer);
		$query = $this->db->get("question_details b");

		return $query->row()->is_correct;
	}

	//*== Get data ==*/  
	function check_answer_multiple($answer)
	{
		$this->db->select("b.is_correct");
		$this->db->where_in("b.id", $answer);
		$this->db->where("is_correct", 1);
		$query = $this->db->get("question_details b");

		if ($query->num_rows() > 0)
			return 1;
		else
			return 0;
	}

	//*== Get data ==*/  
	function check_right_answer($qid)
	{
		$this->db->select("b.is_correct");
		$this->db->where("b.question_id", $qid);
		$this->db->where("b.is_correct", 1);
		$query = $this->db->get("question_details b");

		if ($query->num_rows() > 0)
			return $query->row()->is_correct;
		else
			return NULL;
	}


	//*== Get wrong answer ==*/  
	function get_wrong_answer($qid)
	{
		$this->db->select("b.id");
		$this->db->where("b.question_id", $qid);
		$this->db->where("b.is_correct", 0)->limit(2);
		$query = $this->db->get("question_details b");

		if ($query->num_rows() > 0)
			return $query->result();
		else
			return NULL;
	}


	//*== Get data ==*/  
	function get_question($q_answered = '', $trivia_id = '', $question_no = '')
	{
		$this->db->select("a.*");
		// if($q_answered!=''){
		// 	$qa = explode(",",$q_answered);
		// 	$this->db->where_not_in("a.id",$qa);
		// }

		$this->db->where("id > $question_no");

		$this->db->where("a.status", 1);

		if ($trivia_id != '') {
			$this->db->where("menu", $trivia_id);
		}


		$this->db->where("a.status", 1);
		$this->db->limit(1);
		//$this->db->order_by("RAND()");
		$query = $this->db->get("$this->table_name a");

		if ($query->num_rows() > 0)
			return $query->row();
		else
			return NULL;
	}

	//*== Get data ==*/  
	function get_by_category_cp($cat, $cp, $q_answered = '', $qtype = 1)
	{
		$this->db->select("a.*");
		$this->db->where("a.category", $cat);
		$this->db->where("a.checkpoint", $cp);
		if ($q_answered != '') {
			$qa = explode(",", $q_answered);
			$this->db->where_not_in("a.id", $qa);
		}

		$this->db->where("a.status", 1);
		$this->db->where("a.category", $cat);
		$this->db->where("a.type", $qtype);
		$this->db->limit(1);
		$this->db->order_by("RAND()");
		$query = $this->db->get("$this->table_name a");

		if ($query->num_rows() > 0)
			return $query->row();
		else
			return NULL;
	}


	//*== Save data ==*/
	function save($data, $id_hf)
	{
		if ($id_hf == "") // insert
		{
			$this->db->insert($this->table_name, $data);
			$id = $this->db->insert_id();

			return $id;
		} else // update
		{
			$this->db->where("$this->table_id", $id_hf);
			$this->db->update($this->table_name, $data);

			return $id_hf;
		}
	}


	//*== Update Poin ==*/
	function update_poin_benar($poin)
	{

		$this->db->set('poin', $poin, FALSE);
		$this->db->update($this->table_name);
	}


	//*== Save data ==*/
	function save_detail($data, $qid, $sort_no)
	{
		if ($qid == "") // insert
		{
			$this->db->insert("question_details", $data);
			$id = $this->db->insert_id();
			return $id;
		} else // update
		{
			$this->db->where("question_id", $qid);
			$this->db->where("sort_no", $sort_no);
			$this->db->update("question_details", $data);
		}
	}


	//*== Delete data ==*/
	function delete($id)
	{
		// delete
		$this->db->where($this->table_id, $id);
		$this->db->delete($this->table_name);
	}

	//*== Delete data ==*/
	function delete_detail($id)
	{
		// delete
		$this->db->where("question_id", $id);
		$this->db->delete("question_details");
	}
}
