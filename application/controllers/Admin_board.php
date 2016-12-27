<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_board extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
			
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->model('Board');    //載入資料庫Board

		$this->form_validation->set_message('required', '請您填寫{field}!');
		$this->form_validation->set_message('min_length', '{field}不能少於{param}字數!');
		$this->form_validation->set_message('max_length', '{field}不能超過{param}字數!');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	
	
	public function index()
	{
		
		//未登入則轉到登入頁面
		if (!$this->session->userdata('logged_in')) {
			redirect('admin_member', 'location', 302);
		}
		
		$data = array();
		
		//將登入會員的資料庫board資料列出來 (左側列表)  
		$session = $this->session->all_userdata();
		$data['rows'] = $this->Board->all($session['m_id']);
		$this->form_validation->set_rules($this->config->item('board_rules'));
		
		//列出單個board資料 (右側內容)
		$b_id = $this->uri->segment(3, 0);
		$data['single']= $this->Board->get($session['m_id'], $b_id);
		
		$this->load->view ('admin_board/index', $data);
	}
		
	
	//更新board資料
	public function update()
	{
		//未登入則轉到登入頁面
		if (!$this->session->userdata('logged_in')) {
			redirect('admin_member', 'location', 302);
		}
	
		$post=$this->input->post();			//$_POST;
		if (!empty ($post))
		{
			$data['is_post'] = 1;
			$this->form_validation->set_rules($this->config->item('board_rules'));
		
			if ($this->form_validation->run())
			{
				$session = $this->session->all_userdata();
				$status=$this->Board->update($post['b_id'],$session['m_id'], $post['b_subject'], $post['b_content']);
				if ($status) {
					$this->session->set_userdata('ActionResults', '修改成功!');		//update success
					redirect('/admin_board/index/'. $post['b_id'], 'location', 302);
				} else {
					$this->session->set_userdata('ActionResults', '修改失敗!');		//update fail
					redirect('/admin_board/index/'.$post['b_id'], 'location', 302);
				} //end of status
			} //end of form_validation
		}	//end of post
	}	//end of update
	
	
	//刪除board資料
  	public function del()
  	{
  		//未登入則轉到登入頁面
  		if (!$this->session->userdata('logged_in')) {
  			redirect('admin_member', 'location', 302);
  		}
  		
  		$b_id=$this->uri->segment(3);
  		$status=$this->Board->del($b_id);
  		if ($status) {
  			$this->session->set_userdata('ActionResults', '刪除成功!');		// del success
  			redirect('/admin_board/index', 'location', 302);  			
  		}else {
  			$this->session->set_userdata('ActionResults', '刪除失敗!');		// del fail
  		}
  	}
  	
  	
  	//新增board資料
  	public function add()
  	{
  		//未登入則轉到登入頁面
  		if (!$this->session->userdata('logged_in')) {
  			redirect('admin_member', 'location', 302);
  		}
  	
  		$post=$this->input->post();			//$_POST;
  		if (!empty ($post)) {
  			$this->form_validation->set_rules($this->config->item('board_rules'));
  			
  			if ($this->form_validation->run()) {
  				$session = $this->session->all_userdata();
  				$status=$this->Board->add ($session['m_id'],$post['b_subject'],$post['b_content']); 	//add data
  				if ($status) {
  					$this->session->set_userdata('ActionResults', '新增成功!');
  					redirect('/admin_board/index', 'location', 302);  		// add success
  				}else {
  					$this->session->set_userdata('ActionResults', '新增失敗!');
  					redirect('/admin_baord/add', 'location', 302);			// add fail
  				} //end of status
  			}	// end of form_validation
  		}  $this->load->view('admin_board/add'); //end of post
  	} // end of add
}

