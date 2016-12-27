<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_member extends CI_Controller 
{
		public function __construct()
		{
			parent::__construct();
			$this->load->helper(array('form', 'url'));
			$this->load->library('session');
			$this->load->library('form_validation');
			$this->load->model('Member');
	//		$this->session->unset_userdata('logged_in');
	
			$this->form_validation->set_message('required', '請您填寫{field}!');
			$this->form_validation->set_message('min_length', '{field}不能少於{param}字數!');
			$this->form_validation->set_message('max_length', '{field}不能超過{param}字數!');
			$this->form_validation->set_message('valid_email', '您的Email格式錯誤!');
			$this->form_validation->set_message('is_unique', '您的Email己經有人使用過!');
			$this->form_validation->set_message('matches', '輸入錯誤，請重新輸入!');
			$this->form_validation->set_message('numeric','您輸入的字非數字，請重新輸入!');
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
		
	
	//管理介面登入首頁
	public function index()
	{	
		$data=[];
		
		//己登入則轉到登入完成頁面
		if ($this->session->userdata('logged_in')) {
			redirect('admin_member/get', 'location', 302);
		}
		
		//captcha
		$this->load->helper('captcha');
		$cap=create_captcha($this->Member->get_captcha_config());
		if (!empty ($cap['word'])){
			$data['cpt_image']=$cap['image'];
			$data_cpt = array(
					'captcha_time'  => $cap['time'],
					'ip_address'    => $this->input->ip_address(),
					'word'          => $cap['word']
			);
			$this->Member->add_captcha($data_cpt);		
		}
		
		//確認是否登入成功 
		$post = $this->input->post();		// $_POST;
		if (!empty($post)) {
			$this->form_validation->set_rules($this->config->item('member_index_rules'));
			
			if ($this->form_validation->run()) {		//form_validation success
				//check captcha input
				$row=$this->Member->check_captcha ($post['captcha'], $this->input->ip_address());
				if ($row['cnt'] == 0) {		//captch fail
					$uri='admin_member/index';
					$action_results='您輸入的認證碼有錯誤';
				} else {			//captch success
					$result=$this->Member->login($post['m_email'],$post['m_password']);
					if(!empty ($result['m_id'])) {  //login success
						$this->session->set_userdata('logged_in', TRUE);
						$this->session->set_userdata('m_id', $result['m_id']);
						$this->session->set_userdata('m_email', $post['m_email']);
						$uri='admin_member/get';
//						$action_results='登入管理介面成功';				
					} else {	//login fail
						$uri='admin_member/index';
						$action_results='您輸入的帳號或密碼錯誤';
					} //end of login
				}	//end of captch
				$this->session->set_userdata('ActionResults', $action_results);
			 	redirect ($uri, 'location', 302);  // redirect single member page
			} //end of form_validation
		} //end of post
		$this->load->view('admin_member/index', $data);
	} //end of index
	
	
	//登出管理介面
	public function logout()
	{
		$this->session->unset_userdata('logged_in');
		redirect('admin_member', 'location', 302);	
	} //end of logout
	
	
	//註冊新會員資料
	public function join()
	{
		$this->session->unset_userdata('logged_in');
		$post=$this->input->post();	
		if (!empty ($post)) {
			$this->form_validation->set_rules($this->config->item('member_join_rules'));
				
			if ($this->form_validation->run()) {
				$status=$this->Member->join($post['m_email'],$post['m_password'],$post['m_password_check'],$post['m_name'],$post['m_sex'],$post['m_birthday'],$post['m_phone']);  //新增資料
				
				if ($status) {
					$this->session->set_userdata('ActionResults', '註冊成功!');    // 新增success
				} else {
					$this->session->set_userdata('ActionResults','註冊失敗!');    // 新增fail
				}	//end of status	
			}	//end of form_validation
		}	//end of post
		$this->load->view('admin_member/join');
	} //end of join
	
	
	//列出 single 及修改會員資料 
	public function get()
	{
		//未登入則轉到登入頁面
		if (!$this->session->userdata('logged_in')) {
			redirect('admin_member', 'location', 302);
		}
		
		//列出single會員資料
		$data = array();
		
		$session = $this->session->all_userdata();
		$member_data = $this->Member->get($session['m_id']);	//get single member
		
		//修改會員資料
		$post = $this->input->post();
		if (!empty ($post)) { 	// post success
			$data['is_post'] = 1;
			$data['m_email'] = $member_data['m_email'];
			$this->form_validation->set_rules($this->config->item('member_update_rules'));
			
			if ($this->form_validation->run()) { 	// form vaildation success
				$status = $this->Member->update($session['m_id'],$post['m_name'], $post['m_password'],$post['m_password_check'],$post['m_sex'],$post['m_birthday'],$post['m_phone']);  //修改資料
			
				if($status) {	//update success
					$this->session->set_userdata('ActionResults', '修改成功!');
					redirect('/admin_member/get', 'location', 302);
				} else {		//update fail
					$this->session->set_userdata('ActionResults', '修改失敗!');
				}
			}
		} else { // post fail for get
			$data = $member_data;
		}
		$this->load->view('admin_member/get', $data);
	}
	
	
	//忘記密碼
	public function passmail()
	{	
		$post=$this->input->post();
		if (!empty ($post)) {	//post success
			$this->form_validation->set_rules($this->config->item('member_email_rules'));
			
			if ($this->form_validation->run()) { 	// form vaildation success
				$data=$this->Member->passmail($post['m_email']); 
				$new_password=md5($data['m_password']);		//產生新密碼
				$status=$this->Member->update_password($post['m_email'], $new_password, $new_password);  	//更新DB為新密碼
			
				if ($status) {		//補寄密碼信
					$this->load->library ('email');
					$this->email->from ('a3002369@ms57.hinet.net', 'Travel');
					$this->email->to ($data['m_email']);
					$this->email->subject ('補寄密碼信');
					$this->email->message ('您的新密碼為'.$new_password);
					
					if ($this->email->send()) {	//send mail success
						$this->session->set_userdata('ActionResults', '新密碼己成功寄到您的電子信箱');
					} else {	//send mail fail
						$this->session->set_userdata('ActionResults','新密碼寄送失敗');
					}
				}	//end of status
			}	//end of form_validation
		} $this->load->view('admin_member/passmail');
	} //end of passmail
}
