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
$(document).ready(function(){
	$('#myform').submit (function(){
		if(!$('#m_email').val() ) {alert('請您輸入電子郵件地址!!'); $('#m_email').focus();}
		else if(!$('#m_password').val() ) {alert('請您填寫密碼!!'); $('#m_password').focus();}
		else {
			return true; 
		}
		return false;
		});
});

function isEmail(email) {
	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	return regex.test(email);
}

$( document ).ready(function() {

	$('#mysumit').click(function() {
		var m_email = $('#m_email').val();

 		$.admin_member({
 			method: "POST", // GET or POST
 			url: "/admin_member/get",
 			data: { 'm_email': m_email}
 		})
		.done(function( msg ) {
 			alert( msg + "登入成功" );
 		});


</script>
</head>

<body>

<div class="body_top" >
<h3>管理介面-會員系統</h3>
</div>	

<div class="body">
	<div class="body_title">
		<i class="fa fa-cloud" style="font-size:30px;float:left; "></i>會員登入
	</div>

	<div class="body_content">
	<div class="body_content_t">
	<?php 
		$attributes = array('class' => 'myform', 'id' => 'myform');
		echo form_open('admin_member', $attributes);
		echo form_label('會員帳號：', 'm_email');
		?>
	</div>
	<div class="body_content_c">
		<?php 
		$data = array(
				'name'        => 'm_email',
				'id'          => 'm_email',
				'value'       => set_value ('m_email'),
				'placeholder' => '請輸入電子郵件地址',
				'maxlength'   => '50',
				'size'        => '50',
				'style'       => '',
		);
		echo form_input($data);
		echo form_error ('m_email');
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
		'value'       =>  set_value ('m_password'),
		'placeholder' => '請輸入密碼',
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
		<?php echo form_label('圖形認證：', 'captcha');?>
	</div>
	<div class="body_content_c">
		<?php
		$data = array(
				'name'        => 'captcha',
				'id'          => 'captcha',
				'value'       => '',
				'placeholder' => '請輸入圖形認證碼',
				'maxlength'   => '50',
				'size'        => '50',
				'style'       => '',
		);
		echo form_input($data);
		echo form_error ('captcha');
		?>
	</div>
	<div class="body_content_c">
		<?php echo $cpt_image;?>
	</div>
	</div>

	<div class="body_content">
		<?php 
		$attributes = array('class' => 'mysumit', 'id' => 'mysumit');
		echo form_submit($attributes, '登入系統');
		?>
	</div>

	<div class="body_content">
		<?php echo form_reset('reset', '重設資料');?>
	</div>

	<div class="body_content">
		<button id='password_btn' onClick='window.location="/admin_member/passmail";'>忘記密碼?</button>
	</div>
	
	<div class="body_content">
		<button id='join_btn' onClick='window.location="/admin_member/join";'>註冊新帳號</button>
	</div>
	
	<?php echo form_close();?>		
</div>

</body>
</html>


