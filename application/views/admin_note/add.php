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
		if(!$('#n_title').val() ) { alert('請您填寫旅遊主題 !'); $('#n_title').focus();}
    	else if(!$('#n_photo').val() ) { alert('請您上傳照片!'); $('#n_photo').focus(); }		
		else {
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

<div class="body">
	<a href='/admin_note/index' target='_self'>旅遊雜記列表</a><br>
	<div class="body_title">
		<i class="fa fa-cloud" style="font-size:30px; float:left; "></i>新增旅遊雜記
	</div>

	<div class="body_content">
		<div class="body_content_t">
			<?php 
			$attributes = array('class' => 'myform', 'id' => 'myform');
			echo form_open_multipart('admin_note/add', $attributes);
			echo form_label('旅遊主題:', 'n_title');
			?>
		</div>
		<div class="body_content_c">
			<?php 
			$data = array(
				'name'        => 'n_title',
				'id'          => 'n_title',
				'value'       => set_value ('n_title'),
				'maxlength'   => '50',
				'size'        => '20',
				'style'       => '',
			);
			echo form_input($data);
			echo form_error ('n_title');
			?>
			<br>
		</div>
	</div>

	<div class="body_content">
		<div class="body_content_t">
			<?php echo form_label('上傳照片:', 'n_photo');?>
		</div>
		<div class="body_content_c">
			<?php 
			$data = array(
				'name'        => 'n_photo',
				'id'          => 'n_photo',
			);
			echo form_upload($data);
			echo form_error ('n_photo');
			?>
		</div>
	</div>			
	<br>
	<div class="body_content">
		<?php echo form_submit('submit', '確定新增');?>
	</div>
	<br>	
	<div class="body_content">
		<?php echo form_reset('reset','重設資料');?>
		<?php echo form_close();?>
	</div>
</div>

</body>
</html> 