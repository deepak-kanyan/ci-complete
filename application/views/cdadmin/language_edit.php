

	<style>
		.input-block label{		  
			width: 181px !important;
		}
	</style>


	<script src="<?php echo base_url(); ?>assets/js/jquery-1.9.0.min.js"></script>
	<!--script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script-->
	<script src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>
	<div class="account-right-div">
					<div class="dashboard-heading"><h2><?php echo $page_title; ?></h2></div>
					<?php echo $snbreadcrum; ?>
					<div class="dashboard-inner language_section">
						<div class="main-dash-summry Edit-profile">
							<form name="frmEditGroup" id="frmEditGroup" action="<?php echo base_url(); ?>cdadmin/edit_language/<?php echo $language['id']; ?>" method="post">
											<div class="input-row full-input-width">
												<div class="full">
													<div class="input-block">
														<label class="required">Langauge Name :</label>
														<span class='reg_span'>
															<input type="text" name="langauge_name" id="langauge_name" class="inputbox-main specialChar" value="<?php echo $language['language']; ?>"   />
															
														</span>
													</div>
												</div>
											</div>
											<div class="input-row full-input-width">
												<div class="full">
													<div class="input-block">
														<label class="required">Langauge Short Name :</label>
														<span class='reg_span'>
															<input type="text" readonly="true" name="langaue_short_name" id="langaue_short_name" class="inputbox-main specialChar" value="<?php echo $language['sysname']; ?>"   />
														</span>
													</div>
												</div>
											</div>
											
											
											<div class="input-row full-input-width">
												<div class="full">
													<div class="input-block">
														<label></label>
														<span class='reg_span'>
															<input type="submit" value="Submit" class="btn-submit btn">
															<input type="button" value="Cancel" onclick="cancelButton()" class="btn-submit btn cancel_popup"> </span>
													</div>
												</div>	
											</div>
										</form>
						</div>
					</div>
				</div>

	<script type="text/javascript">
		
		$(document).ready(function(){
		  //$("#myform").validate();
		  jQuery.validator.addMethod("specialChar", function(value, element) {
				var fn = $("#text_index").val();
				var regex = /^[0-9a-zA-Z\_]+$/
				//alert(regex.test(fn));
				if(regex.test(fn) == 1)
				{
					return true;
				}
				else
				{
					return false;
				}
		  });
		});
		
		$(function()
		{
			$("#frmEditGroup").validate({
				rules: {				
				langauge_name:{
								required:true,
								remote: {
									url: "<?php echo base_url().'cdadmin/check_language/'.$language['id'];  ?>",
									type: "post",
									data: {
									langauge_name: function() {
										return $( "#langauge_name" ).val();
									  }
									}
								}
							}
						},	
			   
				messages: {
					langauge_name:{						
						required : "Please enter language name.",
						remote:"Language already exist, try another."
					},
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
		location.assign("<?php echo base_url(); ?>cdadmin/languages");
	  } 
	</script>
	
