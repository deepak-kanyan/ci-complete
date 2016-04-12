<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title><?php echo $page_title; ?></title>
<link href="<?php echo base_url(); ?>assets/cdadmin/css/style.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/cdadmin/css/jquery-ui.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/cdadmin/css/font-awesome.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/cdadmin/css/font-awesome.min.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/js/jquery-1.9.0.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.sumoselect.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/additional-methods.min.js"></script>

<!--script src="<?php echo base_url(); ?>assets/cdadmin/sweetalert/dist/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); 
?>assets/cdadmin/sweetalert/dist/sweetalert.css"-->
</head>



<script>
	
$(document).on('click','.slide-menu',function(){
   
		$('.sub-menu').not($(this).find(".sub-menu")).hide();
        
        $(this).find(".sub-menu").slideToggle();
        $(this).find(".sub-menu-inner").hide();
        $(this).find('.fa-angle-down, .fa-angle-up').toggleClass('fa-angle-down fa-angle-up');        
   
});

</script>

<body>
	
	<header>
		
		<div id="wrapper2">
			
			<div class="header-base">
				
				<div class="logo-div">
					<a href ="<?php echo base_url();?>cdadmin/dashboard"><img src="<?php echo base_url(); ?>assets/cdadmin/images/logo.png"/></a>
				</div>
				
				<div class="header-right-main">
				<nav  class="dashboard-nav">
					<div class="welcometxt"> <h2>Welcome <span><?php echo @$admin_name['username']; ?></span></h2></div>
					<ul><li ><a href="<?php echo base_url()?>cdadmin/logout" class="active sign-out">Logout</a></li>
						
					</ul>
				</nav>
				
				<div class="navi-outer">
					<ul>
						<li> 
							<a  class="<?php if(isset($active) && $active=='dashboard') echo 'active'; ?>" href="<?php echo base_url(); ?>cdadmin/dashboard"> Dashboard </a> 
						</li>	
						<li> 
							<a class="<?php if(isset($active) && $active=='users') echo 'active'; ?>" href="<?php echo base_url(); ?>cdadmin/users"> Users </a> 
						</li>							
						
						<li class="slide-menu"> 
							<a class="<?php if(isset($active) && $active=='manage_master') echo 'active'; ?>" href="#">Manage Master Data <i class="fa fa-angle-down menu-down"></i> </a> 
							<ul class="sub-menu">
								<li>
									<a href="<?php echo base_url();?>cdadmin/pages/manage"> Content pages</a>		
								</li>	
								<li>
									<a href="<?php echo base_url();?>cdadmin/languages"> Manage Languages</a>		
								</li>	
								<li>
									<a href="<?php echo base_url();?>cdadmin/manage_languages"> Manage Languages Index</a>		
								</li>	
							</ul>
						</li>
						<li class="slide-menu"> 
							<a class="<?php if(isset($active) && $active=='manage_settings') echo 'active'; ?>" href="#"> Settings <i class="fa fa-angle-down menu-down"></i> </a> 
							<ul class="sub-menu">
								<li> 
									<a href="<?php echo base_url(); ?>cdadmin/changepassword"> Change Password  </a> 
								</li>
								
							</ul>
						</li>
						
					</ul>
				</div>
				</div>
			</div>
		
		</div>
		
	</header>
	
	
<div class="border-div"></div>	
<div class="clr"></div>
<script >
	setTimeout(function(){ $('#succ_flash').fadeOut('slow'); }, 5000);
</script>
<div class="hotel-listing">
	<div class="regi-main">
		
		<div id="wrapper2">
			<div class="my-account">
				<div class="messages"> 

					<?php 
						if($this->session->flashdata('success'))
					{?> 
					<div class="alert alert-success" id="succ_flash"><img src="<?php echo base_url(); ?>assets/cdadmin/images/img_1.png">
					<?php echo $this->session->flashdata('success'); ?><!--img style="float:right" src="<?php echo base_url(); ?>assets/cdadmin/images/close_icon.jpeg"--></div>
					<?php } ?>	
					
					<?php if($this->session->flashdata('fail'))
					{?> 
					<div class="alert alert-error" id="succ_flash"><?php echo $this->session->flashdata('fail');?></div>
					<?php } ?>
				</div>
				<div class="myaccount-outer">
					<!--div class="my-account-left">
						<ul class="dashboard-listing">
							<!--li class="manage-hosptial <?php  if($page=='hospital') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>cdadmin/manage_user">Manage Users </a></li-->
							<!--li class="manage-hosptial <?php  if($page=='hospital') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>cdadmin/manage_languages">Manage Languages </a></li-->
							<!--li class="dashboard <?php  if($page=='dashboard') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>cdadmin/dashboard">Dashboard</a></li>
							<li class="change_pwd <?php  if($page=='chg_pwd') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>cdadmin/changepassword">Change Password </a></li>
							<li class="manage_user <?php  if($page=='users') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>cdadmin/manage_user/task/search/search/all">Manage Users </a></li>
							<li class="manage_user <?php  if($page=='manage_lang') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>cdadmin/manage_languages">Manage Languages </a></li>
						</ul-->
					</div-->
					<div class="account-right-div">
						<?php echo $body; ?>
				</div>
			
			</div>
			
		</div>
		
	</div>

</div>
<footer>
	<div class="wrapper">
		<p>&copy; Copyright <?php echo date('Y'); ?> Cars2udirect.com. All rights reserved. </p>
	</div>
	<span style="display: none;" class="loader" id="loading">
					<img src="<?php echo base_url(); ?>assets/cdadmin/images/loading.gif">
	</span>
</footer>
</body>

</html>

