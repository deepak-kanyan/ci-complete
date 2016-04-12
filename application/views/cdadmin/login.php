<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<title>Login</title>
	<script src="<?php echo base_url(); ?>assets/js/jquery-1.9.1.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>
	<script>
	  
	  
	  $(function() {
		
		$("#email").focus();
		
		$("#login-form").validate({
		
			
			rules: {
			   
				email: {
					required: true,
					email: true
				},
				password: {
					required: true,
					
				},
			   
			},
			
		   
			messages: {
			   
				password: {
					required: "Please enter password.",
					
				},
				email: {
					required: "Please enter an email address.",
					email: "Please enter a valid email address."
				},
			   
			},
			 errorElement:"div",
			errorClass:"login-error",
			submitHandler: function(form) {
				form.submit();
			}
		});


	  });
	</script>
	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/cdadmin/css/style.css"/>
	<script >
		setTimeout(function(){ $('#succ_flash').fadeOut('slow'); }, 4000);
	</script>
</head>

<body class="admin_body">
	
	<header>
		
		<div id="wrapper2">
			
			<div class="header-base">
				
				<div class="logo-div">
					<a href ="<?php echo base_url();?>"><img src="<?php echo base_url(); ?>assets/cdadmin/images/logo.png"/></a>
				</div>
				
			</div>
			
		</div>
		
	</header>
	
	
<div class="border-div"></div>	




			<div class="regi-main <?php if($this->session->flashdata('success')!='' || $this->session->flashdata('fail')!='') { echo 'lognMsg';} ?>">
	
	
		
		<div class="regi-base login_main">
					<div class="messages">
					<?php if($this->session->flashdata('success'))
					{?> 
					<div class="alert alert-success" id="succ_flash"><?php echo $this->session->flashdata('success');?></div>
					<?php } ?>	</div>
					<div class="message">
					<?php if($this->session->flashdata('fail'))
					{?> 
					<div class="alert alert-error" id="succ_flash"><?php echo $this->session->flashdata('fail');?></div>
					<?php } ?>
					</div>	
						<div class="login-box">
						<h2><img src="<?php echo base_url(); ?>assets/cdadmin/images/login_icon.png"/><div class="login_title"><span>LOGIN</span><p>to your account</p></div></h2>
						<form method="post" action="" class="form-horizontal" id="login-form">
								<fieldset>
							
								<div class="input-prepend">
									<label>E-mail:</label>
									<input type="text"  name="email" id="email"  value=""/>
								</div>
								<div class="clearfix"></div>

								<div class="input-prepend">
									<label>Password:</label>
									<input type="password" name="password" id="password" />
								</div>

								<div class="button-login" >	
									<button class="btn login" type="submit">Login</button>
								</div>
								
								</fieldset>
							</form>
					</div>			
		</div>	
		
	
	
</div>


<footer>
	<div class="wrapper">
		<p>&copy; Copyright <?php echo date('Y'); ?> Cars2udirect.com. All rights reserved. </p>
	</div>
</footer>
	
	
</body>

</html>
