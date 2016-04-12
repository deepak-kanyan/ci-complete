<form method="post" id="add-hospital-form" enctype="multipart/form-data"> 
	<input type="hidden" id="hidden_image_interpreter" name="hidden_image_interpreter" value="">
			<div class="account-right-div contact-page">
					<div class="dashboard-heading"><h2><?php echo $page_title; ?></h2></div>
					<div class="dashboard-inner change_password">
						<div class="main-dash-summry Edit-profile">
							<div class="input-row full-input-width">
								<div class="full">
									<div class="input-block">
										<label class="required">Current Password:</label>
										<span class='reg_span'><input type="password" name="old_pwd" value="" class="inputbox-main"></span>
									</div>
								</div>
							</div>
							<div class="input-row full-input-width">
								<div class="full">
									<div class="input-block">
										<label class="required">New Password:</label>
										<span class='reg_span'><input type="password" id="password" class="inputbox-main" name="new_pwd" value=""></span>
									</div>
								</div>
							</div>
							<div class="input-row full-input-width">
								<div class="full">
									<div class="input-block">
										<label class="required">Confirm Password:  </label>
										<span class='reg_span'><input type="password" id="con_pwd" class="inputbox-main" name="con_pwd" value=""></span>
									</div>
								</div>
							</div>
							
							<div class="input-row full-input-width">
								<div class="full">
									<div class="input-block">
										<label> &nbsp;	 </label>
										<span class='reg_span change-pass-btn'><input type="submit" value="Submit" class="btn-submit btn">
										<input type="button" value="Cancel" onclick="cancelButton()" class="btn-submit btn">
										 </span>
									</div>
								</div>	
							</div>
							
						</div>
					</div>
		</div>
</form>
	
<script type="text/javascript">
	
	  $(function() {
		$("#add-hospital-form").validate({
			rules: {
				old_pwd: "required",
				new_pwd: {
					  required: true,
					  minlength: 5
			    },
				con_pwd: {
						equalTo: "#password"
					},
			},
		   
			messages: {
				old_pwd: "Please enter current password.",
				new_pwd: {
					  required: "Please enter new password.",
					  minlength: "Your password must be at least 5 characters long."
			    },
				con_pwd:"New password and confirm password should be same.",
				},
			
			 errorElement:"div",
			errorClass:"valid-error",
			submitHandler: function(form) {
				form.submit();
			}
		});
	  });
	  
	  function cancelButton()
	  {
		location.assign("<?php echo base_url(); ?>cdadmin/dashboard");
	  } 
	</script>
	
	<style>
	.radio_btn {
         width: 26% !important;
     }
	</style>
