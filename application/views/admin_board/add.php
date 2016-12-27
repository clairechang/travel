<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>管理介面-留言版</title>

<?php 
	$this->load->view('templates/admin_js');
	$this->load->view('templates/admin_css');
	$this->load->view('templates/action_results');
?>

<!-- 判斷Form內容格式-->
<script>
$(document).ready (function(){
	$('#myform').submit (function(){
		if (!$('#b_subject').val() ) { alert('請您填寫留言主題!'); $('#b_subject').focus(); } 	
		else if(!$('#b_content').val() ) { alert('請您填寫留言內容!'); $('#b_content').focus(); }		
		else {
			return true;
		} return false;
	});	
});
</script>

</head>

<body>
<div class="body_top" > 
	<h3>管理介面-留言版</h3>
 	<?php $this->load->view('templates/admin_header'); ?>
</div>

<div class="body">
	<a href='/admin_note/index' target='_self'>留言列表</a><br>
	<div class="body_title">
		<i class="fa fa-cloud" style="font-size:30px; float:left; "></i>新增留言
	</div>
	
<div class="body_content">
		<div class="body_content_t">
			<?php 
			$attributes = array('class' => 'myform', 'id' => 'myform');
			echo form_open ('admin_board/add', $attributes);
			echo form_label('留言主題:', 'b_subject');
			?>
		</div>
		<div class="body_content_c">
			<?php 
			$data = array(
				'name'        => 'b_subject',
				'id'          => 'b_subject',
				'value'       =>  set_value ('b_subject'),
				'maxlength'   => '100',
				'size'        => '45',
				'style'       => '',
			);
			echo form_input($data);
			echo form_error ('b_subject');
			?>
			<br>
		</div>
	</div>

	<div class="body_content">
		<div class="body_content_t">
			<?php echo form_label('留言內容:', 'b_content');;?>
		</div>
		<div class="body_content_c">
		<?php 
		$data = array(
			'name'        => 'b_content',
			'id'          => 'b_content',
			'value'       =>  set_value ('b_content'),
			'cols'        => '67',
			'rows'        => '5',
			'style'       => '',
		);
		echo form_textarea($data);
		echo form_error ('b_content');
		?>
		</div>
	</div>			
	<br>
	<div class="body_content">
		<?php echo form_submit('submit', '確定新增');?>
	<br>
	<div class="body_content">
		<?php echo form_reset('reset','重設資料');?>
	</div>
</div>
	<?php echo form_close();?>
</div>
</body>
</html>
