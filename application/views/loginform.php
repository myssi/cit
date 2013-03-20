<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Login Form</title>
</head>
<link rel="stylesheet" href="<?php echo base_url('css/loginstyle.css'); ?>" type="text/css" title="style" />
<script type="text/javascript" src="<?php echo base_url('js/jquery-1.7.1.min.js'); ?>"></script>
<script type="text/javascript">
$(document).ready(function(){
	$(".username").focus();
});
</script>
<body>
<div id="message">
<?php 
	$message= $this->session->userdata('message_error');
	$this->session->unset_userdata('message_error');
	
	echo isset($message) ? $message : '';
?>
</div>
<?php echo form_open('loginonline/process_login'); ?>
<div id="login_box">
	<br />
	<label>Login CIT</label>
	<br />
	<br />
	<div id="name_field" style="margin-top:15px">Username</div><div id="box_field"><input type="text" size="25" name="username" class="form_login username" maxlength="50"/></div><br />
	<div id="name_field" style="margin-top:15px" >Password</div><div id="box_field"><input type="password" size="25" name="password" class="form_login" maxlength="35"/></div>
	<br />
	<br />
	<br />

	<input type="image" src="<?php echo base_url('images/btlogin.gif'); ?>" alt="Submit button" class="submit"/>
</div>
</form>
</body>
</html>
