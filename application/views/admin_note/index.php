<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>管理介面-旅遊雜記</title>

<?php 
	$this->load->view('templates/admin_js');
	$this->load->view('templates/admin_css');
	$this->load->view('templates/action_results');
?>

<!-- 判斷Form內容格式-->
<script>
$(document).ready (function(){
	$('#myform').submit (function(){
		if (!$('#n_title').val() ) { 
			alert('請您填寫旅遊主題!'); 
			$('#n_title').focus(); 
		} else { // success
			return true;
		}
		return false;
	});	
});
</script>

</head>

<body>

<div class="body_top" > 
<h3>管理介面-旅遊雜記</h3>
 <?php $this->load->view('templates/admin_header'); ?>
</div>

<div class="body" style="clear:both; height: 450px;">

<div class="body_left" style="float:left">
	<a href='/admin_note/add' target='_self'>新增旅遊雜記</a><br>
	
	<div class="body_title">
		<i class="fa fa-cloud" style="font-size:30px;float:left; "></i>旅遊雜記列表
	</div>
	<div class="body_content" style="max-height: 300px; overflow:auto">
		<?php echo form_label('旅遊主題:', 'n_title');?>
		<br>
		<?php foreach ($rows as $row){?>
		<a href='/admin_note/index/<?php echo $row['n_id'];?> 'target='_self'><?php echo $row['n_title']; ?></a><br>
		<?php } ?>
	</div>
</div>


<div class=" body_right" style="float:left">
<?php 
if ($single['n_id'] == 0) {
	echo '';
}else {
?>

	<div class=" body_content_c">
	<div class="body_content_t">
		<?php 
		$attributes = array('class' => 'myform', 'id' => 'myform');
		echo form_open_multipart('admin_note/update',$attributes);
		echo form_hidden('n_id', $single['n_id']);
		echo form_hidden('n_photo_origin', $single['n_photo']);
		echo form_label('旅遊主題:', 'n_title');
		?>
	</div>

	<div class="body_content_c" >
		<?php 
		$data = array(
			'name'        => 'n_title',
			'id'          => 'n_title',
			'value'       =>  ((!empty($is_post)) ? set_value ('n_title') : $single['n_title']),
			'maxlength'   => '50',
			'size'        => '20',
			'style'       => '',
		);
		echo form_input($data);
		?>
	</div>
	</div>

	<div class="body_content_c">
	<div class="body_content_t">
		<?php echo form_label('旅遊照片:', 'n_title');?> <br>
		<img style='max-width:100px' src='/images/<?php echo $single['n_photo']?>'>
	</div>

	<div class="body_content_c">
		<?php 
		$data = array(
			'name'        => 'n_photo',
			'id'          => 'n_photo',
			'value'       =>  ((!empty($is_post)) ? set_value ('n_photo') : $single['n_photo']),
		);
		echo form_upload($data);?>	
	</div>
 	</div>

	<div class="body_content_c" >
		<button id='del_btn' onClick='window.location="/admin_note/del/<?php echo $single['n_id'];?>"; return false;'>刪除</button>
	</div>

	<div class="body_content_c">
		<button id='update_btn'>修改</button>
	</div>
</div>
	<?php echo form_close();?>
</div>

<?php }?>

</body>
</html>

