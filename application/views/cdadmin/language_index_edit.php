<div class="account-right-div">
	<div class="dashboard-heading"><h2><?php echo $page_title; ?></h2></div>
	<?php echo $snbreadcrum; ?>
	<div class="dashboard-inner language_section">
		<div class="main-dash-summry Edit-profile">
		  <form name="frmEditGroup" id="frmEditGroup" action="<?php echo base_url(); ?>cdadmin/edit_language_translation/<?php echo $text_index; ?>" method="post">
			<input type="hidden" name="text_index" value="<?php print $text_index; ?>" />
			<?php
				$session_languages = $this->session->userdata('languages');
				//~ $session_translations = $this->session->userdata('translations');
				//echo '<pre>';print_r($session_languages);die;
				if(array_key_exists($text_index, $session_translations['en']))
				{
					if($session_languages)
					{
						foreach ($session_languages as $language)
						{
							
							?>	
						<div class="input-row full-input-width">
							<div class="full">
								<div class="input-block">
									<label class="required">
										<?php echo $language['folder'];?>:
									</label>
									<span class='reg_span'>
										<input type="text" name="field_<?php print $language['folder'];?>" id="field_<?php print $language['folder'];?>" class="inputbox-main" value="<?php echo @$session_translations[$language['folder']][$text_index];//$this->input->get_value('field_'.$language['folder'], @$session_translations[$language['folder']][$text_index], 'print');?>" required />
									</span>
								</div>
							</div>	
						</div>
					
							<?php
						}
					}
				}
				else
				{
					redirect( base_url(). 'cdadmin/manage_languages');
				}
				?>
			<div class="input-row">
				<div class="full">
					<div class="input-block">
						
							&nbsp;
					</div>
				</div>	
			</div>
			<div class="input-row full-input-width">
				<div class="full">
					<div class="input-block">
						<label></label>
						<span class='reg_span'><input type="submit" value="Submit" class="btn-submit btn">
						<input type="button" value="Cancel" onclick="cancelButton();" class="btn-submit btn"> </span>
					</div>
				</div>	
			</div>
			</form>
		</div>
	</div>
</div>
				
<script type="text/javascript">

	$(function()
		{
			$("#frmEditGroup").validate({
				rules: {
			
					//field_en: "required",					
				},
			   
				messages: {
			
					//field_en: "Please enter english language text",					
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
