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
		if(!$('#m_email').val() ) { alert('請您填寫電子郵件地圵!'); $('#m_email').focus();} 
		else if(!isEmail($('#m_email').val())) { alert('您的Email格式錯誤!'); $('#m_email').focus();}
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
<div class="body_top" >
	<h3>管理介面-會員系統</h3>
</div>	

<div class="body">
	<div class="body_title">
		<i class="fa fa-cloud" style="font-size:30px;float:left; "></i>忘記密碼？
	</div>

	<div class="body_content">
	<div class="body_content_c">
		<P> 請輸入您申請的帳號，系統將自動產生一個十位數的密碼寄到您註冊的信箱。</P>
	</div>
	<div class="body_content_t">
		<?php 
		$attributes = array('class' => 'myform', 'id' => 'myform');
		echo form_open('admin_member/passmail', $attributes);
		echo form_hidden('action', 'join');
		echo form_label('會員帳號:', 'm_email');
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
		<?php echo form_submit('submit', '寄密碼信');?>
	</div>

	<div class="body_content">
		<button id='update_btn' onClick='window.location="/admin_member";'>回會員登入</button>
	</div>
	<?php echo form_close();?>
</div>

</body>
</html>