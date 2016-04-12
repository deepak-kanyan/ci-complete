<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Dashboard</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/cdadmin/css/style.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/cdadmin/css/font-awesome.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/cdadmin/css/font-awesome.min.css"/>
<script src="<?php echo base_url(); ?>assets/js/jquery-1.9.0.min.js"></script>
<script>
	
$(document).on('click','.slide-menu',function(){
   
		$('.sub-menu').not($(this).find(".sub-menu")).hide();
        
        $(this).find(".sub-menu").slideToggle();
        $(this).find(".sub-menu-inner").hide();
        $(this).find('.fa-angle-down, .fa-angle-up').toggleClass('fa-angle-down fa-angle-up');        
   
});

</script>

</head>

<body>
	
	<header>
		
		<div id="wrapper2">
			
			<div class="header-base">
				
				
				<div class="logo-div">
					<a href ="<?php echo base_url();?>cdadmin/dashboard"><img src="<?php echo base_url(); ?>assets/cdadmin/images/logo.png"/></a>
				</div>
				
				<div class="header-right-main">
				<nav  class="dashboard-nav">
					
					<div class="welcometxt"> <h2>Welcome <span><?php echo $admin_name['username']; ?></span></h2></div>
					<ul><li ><a href="<?php echo base_url()?>cdadmin/logout" class="active sign-out">Logout</a></li>
						
					</ul>
				</nav>
				
				
					<div class="navi-outer">
					<ul>
						<li> 
							<a class="<?php if(isset($active) && $active=='dashboard') echo 'active'; ?>" href="<?php echo base_url(); ?>cdadmin/dashboard"> Dashboard </a> 
						</li>	
						<li> 
							<a class="<?php if(isset($active) && $active=='users') echo 'active'; ?>" href="<?php echo base_url(); ?>cdadmin/users"> Users </a> 
						</li>
						<li class="slide-menu"> 
							<a class="" href="#">Manage Master Data <i class="fa fa-angle-down menu-down"></i> </a> 
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
				
			</div>
			
		</div>
		
	</header>
	
	
<div class="border-div"></div>	

<div class="clr"></div>


<div class="regi-main dashboard-main-outer">
	
	<div id="wrapper2">
		<!--dashboard-->
		<div class="dashboard-outer">
			
			<div class="one-third-block">
				<a href="<?php echo base_url(); ?>cdadmin/users"><div class="dashboard-icon-block">
					<div class="icon-dash user"></div>
					<div class="dash-content"><h2>Users</h2></div>
				</div></a>
			</div>			
			<div class="one-third-block">
				<a href="<?php echo base_url(); ?>cdadmin/changepassword"><div class="dashboard-icon-block">
					<div class="icon-dash interpreter"></div>
					<div class="dash-content"><h2>Change Password</h2></div>
				</div></a>
			</div>

		</div>
		<!--dashboard end-->
	</div>
	
</div>

<footer>
	<div class="wrapper footer-base">
		<p>&copy; Copyright <?php echo date('Y'); ?> deepakkanyan.com. All rights reserved. </p>
	</div>
</footer>
</body>

</html>
