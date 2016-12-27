
<?php 
	$ActionResults = $this->session->userdata('ActionResults');
	if(!empty($ActionResults))
	{
		echo '<script>alert("' . $ActionResults . '");</script>';
		$this->session->unset_userdata('ActionResults');
	}
?>
