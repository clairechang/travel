<?php

/**
 * @author Claire
 * 2016/11/
 * 路徑application/config/autoload.php更改設定 
   $autoload['libraries'] = array('database', 'session');
   $autoload['helper'] = array('url','file','form');
   $autoload['config'] = array('common');    
   $autoload['model'] = array('Note','Board',Member);
 * 路徑application/config/database.php 更改設定：$db['default'] 
 *
 */


defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_note extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
			
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->model('Note');      
	//	$this->session->unset_userdata('logged_in');
	
		$this->form_validation->set_message('required', '請您填寫{field}');
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
		
		//將登入會員的資料庫note資料列出來 (左側列表)
		$session = $this->session->all_userdata();
		$data['rows'] = $this->Note->all($session['m_id']);
				
		//列出單個note資料 (右側內容)
		$n_id = $this->uri->segment(3, 0);
	    $data['single']= $this->Note->get($session['m_id'], $n_id); 
	    
	    $this->load->view('admin_note/index', $data);  
	}
	
	
	//更新資料庫note資料
	 public function update()
	 {
	 	//未登入則轉到登入頁面
	 	if (!$this->session->userdata('logged_in')) {
	 		redirect('admin_member', 'location', 302);
	 	}
	 	
	 	$data = array();
	 	
	 	$post=$this->input->post();
		if (!empty ($post)) {	//post success
			$data['is_post'] = 1;
			$this->form_validation->set_rules($this->config->item('note_rules'));
			
			if ($this->form_validation->run()) {    	        //form_validation success
				
				print("<pre>");
				print_r($_FILES);
				print("</pre>");
				
				if(!empty($_FILES['n_photo']['tmp_name'])) { // if upload file , then do_upload
					
					$config = $this->config->item('upload'); //此'upload'為common.php檔案中的索引名稱
					$this->load->library('upload', $config);
					//		$config['upload_path'] = './images/';   //設定上傳檔案的格式, 也可在config/中建一個通用的config, 如common.php
					//		$config['allowed_types'] = 'gif|jpg|png';
					//		$config['max_size']	= '1000';    //k
					//		$config['max_width']  = '1024';
					//		$config['max_height']  = '768';
					
					if (!$this->upload->do_upload('n_photo')) {	// upload fail
						$error = $this->upload->display_errors();
						$this->session->set_userdata('ActionResults', $error);
						redirect('/admin_note/index', 'location', 302);
					} else { // upload success
						$data = $this->upload->data();
						$file_name = $data['file_name'];
					}
				} else {
					$file_name = $post['n_photo_origin'];
				}
				
				$session = $this->session->all_userdata();
				$status = $this->Note->update( $post['n_id'],$session['m_id'], $post['n_title'], $file_name);  //更新資料,$data為陣列內容資料
				if($status) {	// update success
					$this->session->set_userdata('ActionResults', '修改成功!');
					redirect('/admin_note/index/' . $post['n_id'], 'location', 302);
				} else  {      // update fail
					$this->session->set_userdata('ActionResults', '修改失敗!');
				} 
				 
			} //end of form_validation
		}  //end of post
	}  //end of update
	
	
	//刪除資料庫note資料
	public function del()
	{
		$n_id = $this->uri->segment(3, 0);
		$status = $this->Note->del($n_id);
		if($status)	{	 // del success
			$this->session->set_userdata('ActionResults', '刪除成功!');
			redirect('/admin_note', 'location', 302);
		} else { 	     // del fail
			$this->session->set_userdata('ActionResults', '刪除失敗!');
		}
	}
	
	
	//新增note資料
	public function add()
	{		
		//未登入則轉到登入頁面
		if (!$this->session->userdata('logged_in')) {
			redirect('admin_member', 'location', 302);
		}
			
		$post=$this->input->post();
		if (!empty ($post)) {      //$_POST;
		
			$this->form_validation->set_rules($this->config->item('note_rules'));
			
			if ($this->form_validation->run()) {  //form_validation success
				$config = $this->config->item('upload');        //此'upload'為common.php檔案中的索引名稱
				$this->load->library('upload', $config);			

				if (!$this->upload->do_upload('n_photo')) {	 // upload fail
					$error = $this->upload->display_errors();
					$this->session->set_userdata('ActionResults', $error);
          	    } else	{									    // upload success
          	    	$session = $this->session->all_userdata();
					$data = $this->upload->data();
					$status = $this->Note->add($session['m_id'], $post['n_id'], $post['n_title'], $data['file_name']);  //新增資料
          	    }
					if($status) {	// add success
						$this->session->set_userdata('ActionResults', '新增成功!');
 						redirect('/admin_note', 'location', 302); 
					} else {   	   // add fail
						$this->session->set_userdata('ActionResults', '新增失敗!');
						redirect('/admin_note/add', 'location', 302);
					} 
			}  //end of for_validation
		}  $this->load->view('admin_note/add');  //end of post
	}  //end of add
}
