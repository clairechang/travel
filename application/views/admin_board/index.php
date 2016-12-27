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


<div class="body" style="clear:both; height: 450px;">

<div class="body_left" style="float:left">
	<a href='/admin_board/add' target='_self'>新增留言</a><br>
	
	<div class="body_title">
		<i class="fa fa-cloud" style="font-size:30px;float:left; "></i>留言列表
	</div>
	<div class="body_content" style="max-height: 300px; overflow:auto">
		<?php echo form_label('留言主題:', 'b_subject');?>
		<br>
		<?php foreach ($rows as $row){?>
		<a href='/admin_board/index/<?php echo $row['b_id'];?> 'target='_self'><?php echo $row['b_subject']; ?></a><br>
		<?php } ?>
	</div>
</div>


<div class=" body_right" style="float:left">

<?php 
if ($single['b_id'] == 0) {
	echo '';
}else {
?>

	<div class=" body_content_c">
	<div class="body_content_t">
		<?php 
		echo form_open('admin_board/update');
		echo form_hidden('b_id', $single['b_id']);
		echo form_label('留言主題:', 'b_subject');
		?>
	</div>

	<div class="body_content_c" >
		<?php 
		$data = array(
			'name'        => 'b_subject',
			'id'          => 'b_subject',
			'value'       => ((!empty($is_post)) ? set_value ('b_subject') : $single['b_subject']),  
			'maxlength'   => '100',
			'size'        => '45',
			'style'       => '',
		);
		echo form_input($data);
		echo form_error ('b_subject');
		?>
	</div>
	</div>

	<div class="body_content_c">
	<div class="body_content_t">
		<?php echo form_label('留言內容:', 'b_content');?>
	</div>

	<div class="body_content_c">
		<?php 
		$data = array(
			'name'        => 'b_content',
			'id'          => 'b_content',
			'value'       => ((!empty($is_post)) ? set_value ('b_content') : $single['b_content']), 
			'cols'        => '53',
			'rows'        => '5',
			'style'       => '',
		);
		echo form_textarea($data);
		echo form_error ('b_content');
		?>
	</div>
 	</div>

	<div class="body_content_c" >
	<button id='del_btn' onClick='window.location="/admin_board/del/<?php echo $single['b_id'];?>"; return false;'>刪除</button>
	</div>
	
	<div class="body_content_c" >
	<button id='update_btn'>修改</button>
	</div>
</div>
	<?php echo form_close();?>
	<?php } ?>
</div>
</body>
</html>
