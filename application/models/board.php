<?php

class Board extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}
	
	
	//新增board資料
	public function add ($m_id, $b_subject, $b_content)
	{
		$data = array(
				'm_id'=> $m_id,
   				'b_subject' => $b_subject,
				'b_content' => $b_content,
				'created' => date ('Y-m-d H:i:s')
	);
		return $this->db->insert('board', $data); 
	}
	
	
	//列出board資料
	public function all($m_id)
	{		
		$this->db->select('b_id, b_subject, b_content');
		$query = $this->db->get_where('board', array('m_id' => $m_id));
		return $query->result_array();
	}
	
	
	//列出單個board資料
	public function get($m_id, $b_id)
	{
		$this->db->select('b_id, b_subject, b_content');
		$this->db->from('board');
		$condition = array('m_id'=> $m_id,'b_id'=> $b_id);
		$this->db->where($condition);
		$query= $this->db->get();
		return $query->row_array();
	}
	
		
	//刪除board資料
	public function del($b_id)
	{
		return $this->db->delete('board', array('b_id' => $b_id));
	}
	
	
	//更新資料
	public function update($b_id, $m_id, $b_subject, $b_content)
	{
		$data = array(
				'b_subject' => $b_subject,
				'b_content' => $b_content
		);
		
		$this->db->where('b_id', $b_id);
		$this->db->where('m_id', $m_id);
		return $this->db->update('board', $data);
	}
}