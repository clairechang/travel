<?php 

class Member extends CI_Model {
	
	//captcha config
	private $config=[
	//		'word'	      => 'Random word',
			'img_path'    => './images/captcha/',
			'img_url'	  => 'http://travel.com/images/captcha/',
			'img_width'   => 150,
			'img_height'  => 35,
			'expiration'  => 300,
			'word_length' => 4,
			'font_size'   => 20,
			'img_id'      => 'captcha_img',
			'pool'        => '0123456789AaBb',
			
			// White background and border, black text and red grid
			'colors'      => array(
					'background' => array(255, 255, 255),
					'border' => array(255, 255, 255),
					'text' => array(0, 0, 0),
					'grid' => array(255, 40, 40)
			)
	];
	

    public function __construct()
    {
        parent::__construct();
    }
    
    
    //get captcha config
    public function get_captcha_config()
    {
    	return $this->config;
    }
    
    
    //新增captcha資料
    public function add_captcha($data)
    {
    	$query = $this->db->insert_string('captcha', $data);
    	$this->db->query($query);
    }
    
    
    //刪除舊的驗證碼，確認驗證碼是否存在
    public function check_captcha($word, $ip)
    {
    	$expiration = time() - 300; //  five mins limit
    	$this->db->where('captcha_time < ', $expiration);
    	$this->db->delete('captcha');
    	
    	$this->db->select('count(1) as cnt');
    	$this->db->from('captcha');
    	$this->db->where('word', $word);
    	$this->db->where('ip_address', $ip);
    	$this->db->where('captcha_time >', $expiration);
    	$query = $this->db->get();
    	return $query->row_array();
    }
    
    
    //新增會員資料
    public function join( $m_email, $m_password, $m_password_check,$m_name, $m_sex, $m_birthday, $m_phone)
    {
    	$data = array(
    			'm_email' => $m_email,
    			'm_password' => $m_password,
    			'm_password_check' => $m_password_check,
    			'm_name' => $m_name ,
    			'm_sex' => $m_sex ,
    			'm_birthday' => $m_birthday,
    			'm_phone' => $m_phone,
    			'created' => date ('Y-m-d H:i:s')
    	);
    	return $this->db->insert('member', $data);    	 
    }
    
    
    //登入會員系統
    public function login($m_email, $m_password)
    {
    	$this->db->select('m_id');
    	$query = $this->db->get_where('member', array('m_email' => $m_email, 'm_password' =>$m_password));
    	return $query->row_array();
    }
   
    
    //列出單個會員資料
    public function get($m_id)
    {
    	$this->db->select('m_name, m_password, m_password_check, m_sex, m_birthday, m_email, m_phone');
    	$query = $this->db->get_where('member', array('m_id'=> $m_id));
    	return $query->row_array();  	 
    }
    
    
    //修改會員資料
    public function update($m_id, $m_name, $m_password, $m_password_check, $m_sex, $m_birthday, $m_phone)
    {
    	$data = array(
    			'm_name' => $m_name ,
    			'm_password' => $m_password,
    			'm_password_check' => $m_password_check, 
    			'm_sex' => $m_sex ,
    			'm_birthday' => $m_birthday,
    			'm_phone' => $m_phone,
    			'lastmod' => date ('Y-m-d H:i:s')
    	);
		$this->db->where('m_id', $m_id);
		return $this->db->update('member', $data); 
    }
    
    
    //忘記密碼寄密碼信
    public function passmail($m_email)
    {
    	$this->db->select('m_password, m_email, m_name');
    	$query = $this->db->get_where('member', array('m_email' => $m_email));
    	return $query->row_array();
    }   
    
    
    //更新新密碼至DB
    public function update_password($m_email, $m_password, $m_password_check)
    {
    	$data = array(
    			'm_password' => $m_password,
    			'm_password_check' => $m_password_check,
    			'lastmod' => date ('Y-m-d H:i:s')
    	);
    	$this->db->where('m_email', $m_email);
    	return $this->db->update('member', $data);
    }
}

?>