<?php
//檔案上傳設定
$config['upload'] = array(	
		'upload_path' => './images/',
		'allowed_types' => 'gif|jpg|png',
		'max_size'	=> 1000,
		'max_width'  => 1024,
		'max_height'  => 768,
		'encrypt_name'  => true
	);
	

//表單驗證規則

$config['member_index_rules']=array(
		array(
				'field' => 'm_email',
				'label' => '會員帳號',
				'rules' => 'trim|required|valid_email|min_length[8]|max_length[20]'
		),
		array(
				'field' => 'm_password',
				'label' => '會員密碼',
				'rules' => 'trim|required|min_length[8]'
		),
		array(
				'field' => 'captcha',
				'label' => '圖形認證',
				'rules' => 'trim|required|min_length[4]|max_length[4]'
		),
);

$config['member_join_rules']=array(
		array(
				'field' => 'm_email',
				'label' => '會員帳號',
				'rules' => 'trim|required|valid_email|min_length[8]|max_length[20]|is_unique[m_email]'
		),
		array(
				'field' => 'm_password',
				'label' => '會員密碼',
				'rules' => 'trim|required|min_length[8]|max_length[25]'
		),
		array(
				'field' => 'm_password_check',
				'label' => '確認密碼',
				'rules' => 'trim|required|min_length[8]|max_length[25]|matches[m_password]'
		),
		array(
				'field' => 'm_name',
				'label' => '姓名',
				'rules' => 'trim|required|min_length[2]|max_length[20]'
		),
		array(
				'field' => 'm_sex',
				'label' => '性別',
				'rules' => 'trim|required'
		),
		array(
				'field' => 'm_birthday',
				'label' => '生日',
				'rules' => 'trim|required|min_length[10]|max_length[10]'
		),
		array(
				'field' => 'm_phone',
				'label' => '手機號碼',
				'rules' => 'trim|required|min_length[10]|max_length[20]|numeric'
		),
);

$config['member_update_rules']=array(
				array(
						'field' => 'm_password',
						'label' => '會員密碼',
						'rules' => 'trim|required|min_length[8]|max_length[25]'
				),
				array(
 						'field' => 'm_password_check',
 						'label' => '確認密碼',
 						'rules' => 'trim|required|min_length[8]|max_length[25]|matches[m_password]'
 				),
 				array(
 						'field' => 'm_name',
 						'label' => '姓名',
 						'rules' => 'trim|required|min_length[2]|max_length[20]'
 				),
 				array(
 						'field' => 'm_sex',
 						'label' => '性別',
 						'rules' => 'trim|required'
 				),
 				array(
 						'field' => 'm_birthday',
 						'label' => '生日',
 						'rules' => 'trim|required|min_length[10]|max_length[10]'
 				),
 				array(
						'field' => 'm_phone',
 						'label' => '手機號碼',
 						'rules' => 'trim|required|min_length[10]|max_length[20]|numeric'
 				),									
);

$config['member_email_rules']=array(
		array(
				'field' => 'm_email',
				'label' => '會員帳號',
				'rules' => 'trim|required|valid_email|min_length[8]|max_length[20]'
		),
);


$config['board_rules']=array(
		array(
				'field' => 'b_subject',
				'label' => '留言主題',
				'rules' => 'trim|required'
		),
		array(
				'field' => 'b_content',
				'label' => '留言內容',
				'rules' => 'trim|required'
		),
);

$config['note_rules']=array(
		array(
				'field' => 'n_title',
				'label' => '旅遊主題',
				'rules' => 'trim|required'
		),
//		array(
//				'field' => 'n_photo',
//				'label' => '上傳照片',
//				'rules' => 'required'
//	    ),
);
?>
	
	