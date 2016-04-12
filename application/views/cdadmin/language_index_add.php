
	<script src="<?php echo base_url(); ?>assets/js/jquery-1.9.0.min.js"></script>
	<!--script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script-->
	<script src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>
	<div class="account-right-div">
					<div class="dashboard-heading"><h2><?php echo $page_title; ?></h2></div>
					<?php echo $snbreadcrum; ?>
					<div class="dashboard-inner language_section">
						<div class="main-dash-summry Edit-profile">
						  <form name="frmEditGroup" id="frmEditGroup" action="<?php echo base_url(); ?>cdadmin/add_new_translation" method="post">
							<div class="input-row full-input-width">
								<div class="full">
									<div class="input-block">
										<label class="required">Langauge Index:</label>
										<span class='reg_span'>
											<input type="text" name="text_index" id="text_index" class="inputbox-main specialChar" value=""  />
											
										</span>
									</div>
								</div>
							</div>
							<?php
							//$languages = $this->session->userdata('languages');
							//	echo '<pre>';print_r($languages); die;
							if($all_languages)
							{
								foreach ($all_languages as $language)
								{
									?>	
								<div class="input-row full-input-width">
								<div class="full">
									<div class="input-block">
										<label class="required">
											<?php print $language['language'];?>:
										</label>
										<span class='reg_span'>
											<input type="text" name="field_<?php print $language['sysname'];?>" id="field_<?php print $language['sysname'];?>" class="inputbox-main" required />
										</span>
								</div>	</div>	
							</div>

									<?php
								}
							}
							?>

							
							<div class="input-row full-input-width">
								<div class="full">
									<div class="input-block">
										<label></label>
										<span class='reg_span'><input type="submit" value="Submit" class="btn-submit btn"> <input type="button" value="Cancel" onclick="cancelButton();" class="btn-submit btn"> </span>
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
					text_index: { 	required:true,
									specialChar:true
								},	
				},
			   
				messages: {
					text_index: { required: "Please enter language index.",
								specialChar: "Only special character underscore'_' is allowed."
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
		location.assign("<?php echo base_url(); ?>cdadmin/manage_languages");
	  } 
	</script>
