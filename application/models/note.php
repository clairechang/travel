<?php
/**
 * 
 * @author Claire 
 *2016/11
 */

//模型(model)類別的基本原型, 類別名稱必須第一個字母大寫其餘的字母小寫。 確認你的類別繼承(extends)基本的Model類別。檔案名稱是全部小寫的類別名稱

class Note extends CI_Model {       

	public function __construct()
	{
		parent::__construct();
	}
	
	
	//列出登入會員的note的所有n_id, n_title,n_photo
	public function all($m_id)            
	{
		$this->db->select('n_id, n_title, n_photo');
		$query = $this->db->get_where('note', array('m_id' => $m_id));
		return $query->result_array();
	}
	
	
	//列出單個note資料
	public function get($m_id, $n_id)
	{
		$this->db->select('n_id, n_title, n_photo');
		$this->db->from('note');
		$condition = array('m_id'=> $m_id,'n_id'=> $n_id);
		$this->db->where($condition);
		$query= $this->db->get();
		return $query->row_array();
	}
	
	
	//新增資料
	public function add($m_id,$n_id, $n_title, $n_photo)			
	{
		$data = array(
				'm_id' => $m_id,
				'n_id' => $n_id,
				'n_title' => $n_title,
				'n_photo' => $n_photo,
				'created' => date ('Y-m-d H:i:s')  // date 是php原生函數
		);
		return $this->db->insert('note', $data);
	}
	
	
	//刪除資料
	public function del($n_id)
	{
		return $this->db->delete('note', array('n_id' => $n_id));	
	}
	
	
	//更新資料
	public function update($n_id, $m_id, $n_title, $n_photo)
	{
		$data = array(
				'n_title' => $n_title,
				'n_photo' => $n_photo
		);	
		$condition = array('m_id'=> $m_id,'n_id'=> $n_id);
		$this->db->where($condition);
		
		return $this->db->update('note', $data);
	}
}

?>