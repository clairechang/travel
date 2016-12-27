<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>管理介面-會員系統</title>

<?php 
	$this->load->view('templates/admin_js');
	$this->load->view('templates/admin_css');
	$this->load->view('templates/action_results');
?>

<!-- 判斷Form內容格式-->
<script>
$(document).ready (function(){
	$('#myform').submit (function(){
		if(!$('#m_password').val() ) { alert('請您填寫密碼!'); $('#m_password').focus();}
		else if($('#m_password').val().length > 25 || $('#m_password').val().length < 8 ) { alert('您的密碼長度只能8至25個字元!'); $('#m_password').focus();}
		else if(!$('#m_password_check').val() ) { alert('請您再次填寫密碼!'); $('#m_password_check').focus();}
		else if($('#m_password_check').val() != $('#m_password').val() ) { alert('密碼二次輸入不一樣，請重新輸入!'); $('#m_password_check').focus();}
		else if(!$('#m_name').val() ) { alert('請您填寫姓名 !'); $('#m_name').focus();}
		else if($('input[name=m_sex]:checked').val() == undefined) {alert('請您選擇性別');}
		else if(!$('#m_birthday').val() ) { alert('請您填寫生日!'); $('#m_birthday').focus(); } 
		else if(!$('#m_phone').val() ) { alert('請您填寫手機號碼!'); $('#m_phone').focus(); }
		else 
		{
			return true;
		}	
		return false;
	});
});

function isEmail(email) {
	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	return regex.test(email);
}	
</script>
</head>
<body>

<div class="body_top"> 
	<h3>管理介面-會員系統</h3>
 	<?php $this->load->view('templates/admin_header'); ?>
</div>

<div class="body">
	<div class="body_title">
	<i class="fa fa-cloud" style="font-size:30px;float:left; "></i>修改會員帳號   
	</div>

	<div class="body_content">
	<div class="body_content_c">
		<p style="color:red;">*若有修改密碼，則需登出，再重新登入。</p>
		<?php 
		$attributes = array('class' => 'myform', 'id' => 'myform');
		echo form_open('admin_member/get', $attributes);
		echo form_hidden('action', 'update'); 
		echo form_label('會員帳號：', 'm_email');
		echo form_label($m_email, 'm_email');
		?>
	</div>
	</div>

	<div class="body_content">
	<div class="body_content_t">
		<?php echo form_label('會員密碼：', 'm_password');?>
	</div>
	<div class="body_content_c">
		<?php 
		$data = array(
				'name'        => 'm_password',
				'id'          => 'm_password',
				'value'       =>  ((!empty($is_post)) ? set_value ('m_password') : $m_password),
				'placeholder' => '請輸入8-25個字元',
				'maxlength'   => '50',
				'size'        => '50',
				'style'       => '',
		);
		echo form_password($data);
		echo form_error ('m_password');
		?>
	</div>
	</div>

	<div class="body_content">
	<div class="body_content_t">
		<?php echo form_label('確認密碼：', 'm_password_check');?>
	</div>
	<div class="body_content_c">
		<?php 
		$data = array(
				'name'        => 'm_password_check',
				'id'          => 'm_password_check',
				'value'       =>  ((!empty($is_post)) ? set_value ('m_password_check') : $m_password_check),
				'placeholder' => '請再次輸入密碼',
				'maxlength'   => '50',
				'size'        => '50',
				'style'       => '',
		);
		echo form_password($data);
		echo form_error ('m_password_check');
		?>
	</div>
	</div>

	<div class="body_content">
	<div class="body_content_t">
		<?php echo form_label('姓    名：', 'm_name');?>
	</div>
	<div class="body_content_c">
		<?php 
		$data = array(
				'name'        => 'm_name',
				'id'          => 'm_name',
				'value'       => ((!empty($is_post)) ? set_value ('m_name') : $m_name),
				'maxlength'   => '50',
				'size'        => '50',
				'style'       => '',
		);
		echo form_input($data);
		echo form_error ('m_name');
		?>
	</div>
	</div>

	<div class="body_content">
	<div class="body_content_c">
		<?php
		if(!empty($is_post)) {
			$m_sex = set_value ('m_sex');
		}

		$is_mail = ($m_sex == 'Male') ? TRUE : FALSE;
		$is_femail = ($m_sex == 'Female') ? TRUE : FALSE;

		echo form_label('性    別：', 'm_sex');
		echo form_label('Female', 'm_sex');
		echo form_radio('m_sex', 'Female', $is_femail);
		echo form_label('Male', 'm_sex');
		echo form_radio('m_sex', 'Male', $is_mail);
		echo form_error ('m_sex');
		?>
	</div>
	</div>

	<div class="body_content">
	<div class="body_content_t">
		<?php echo form_label('生    日：', 'm_birthday'); ?>
	</div>
	<div class="body_content_c">
		<?php 
		$data = array(
				'name'        => 'm_birthday',
				'id'          => 'm_birthday',
				'value'       => ((!empty($is_post)) ? set_value ('m_birthday') : $m_birthday),
				'placeholder' => '請輸入西元格式 YYYY-MM-DD',
				'maxlength'   => '50',
				'size'        => '50',
				'style'       => '',
		);
		echo form_input($data);
		echo form_error ('m_birthday');
		?>
	</div>
	</div>

	<div class="body_content">
	<div class="body_content_t">
		<?php echo form_label('手機號碼：', 'm_phone');?>
	</div>
	<div class="body_content_c">
		<?php 
		$data = array(
				'name'        => 'm_phone',
				'id'          => 'm_phone',
				'value'       => ((!empty($is_post)) ? set_value ('m_phone') : $m_phone),
				'placeholder' => '請輸入格式為 0919123456',
				'maxlength'   => '50',
				'size'        => '50',
				'style'       => '',
		);
		echo form_input($data);
		echo form_error ('m_phone');
		?>
	</div>
	</div>

	<div class="body_content">
		<?php echo form_submit('submit', '修改資料');?>
	</div>
	
	<?php echo form_close();?>
</div>
</body>
</html>