<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>assets/cdadmin/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/cdadmin/js/ckeditor/ckeditor.js"></script>
<script src="<?php echo base_url(); ?>assets/cdadmin/js/adapters/jquery.js"></script>


 <?php 	//echo '<pre>';print_r($all_content);
		//echo $all_content[$all_languages[0]['id']]['image'];
		//die; 
 ?>
	<form onSubmit="return check_image()" method="post" name="frmEmailTemplate" id="frmEmailTemplate" enctype="multipart/form-data"> 
		<div class="account-right-div">
			<div class="dashboard-heading">
				<h2>
					<?php echo $page_title; ?>
				</h2>
				<!--a href="#" class="add-user" onclick='add_template()'><i></i><span>Add New Template</span></a-->
			</div>
			<?php
				$from_name = $from_email = $template_body = $id = '';
				if(isset($template_detail['id'])) $id = $template_detail['id'];
				if(isset($template_detail['from_name'])) $from_name = $template_detail['from_name'];
				if(isset($template_detail['from_email'])) $from_email = $template_detail['from_email'];
				if(isset($template_detail['template_body'])) $template_body = htmlspecialchars_decode($template_detail['template_body']);
			?>
			<div class="dashboard-inner">
				<div class="main-dash-summry Edit-profile">								
						
						<div class="input-row full-input-width">
							<div class="full">
								<div class="input-block">
									<label>Page Image :  </label>
									<span class='reg_span'>
										<input type="file" id="title_image" class="" name="title_image" value="">			
										<?php if($all_content['image'])
										{											 
											$src=base_url().'/uploads/pages/'.$all_content['image'];	
										
										?>
											<img src="<?php echo $src; ?>" style="top:-10px;" height="60" width="60">
										<?php 
										}
										?>			
										
									</span>
								</div>
							</div>
						</div>			
					
						<div class="input-row full-input-width">
							<div class="full">
								<div class="input-block">
									<label class="">Title : </label>
									<span class='reg_span'>
										<input type="text" id="title" class="inputbox-main" name="title" value="<?php if(!isset($all_content['page_title'])) echo $all_content['page_title']; else echo $all_content['page_title']; ?>" placeholder="Enter Page Title">
									</span>
								</div>
							</div>
						</div>
						<div class="input-row full-input-width">
						<div class="full">
							<div class="input-block">
								<label class="">Content : </label>
								<span class='reg_span' style="height:auto;">
									
									<textarea id="content" class="" name="content">
									
									<?php  
										if(!isset($all_content['page_content']))
											echo $all_content['page_content'];
										else
											echo $all_content['page_content'];
									?>
									
									</textarea></br>
									
								</span>
							</div>
						</div>
					</div>
					<script>
						$(function(){
							
							CKEDITOR.replace( 'content', {
								width :547,
								height: 200,
								toolbarGroups: [	
									{"name":"document","groups":["mode"]},
									{"name":"basicstyles","groups":["basicstyles"]},
									
									{"name":"paragraph","groups":["list","blocks"]},
									
									{"name":"insert","groups":["insert"]},
									{"name":"styles","groups":["styles"]},
									{"name":"links","groups":["links"]},
									
								],
								// Remove the redundant buttons from toolbar groups defined above.
								removeButtons: 'Anchor'
							});
							
						});

					</script>
				
					<div class="input-row">
						<div class="full">
							<div class="input-block">
								<label> &nbsp; </label>
								<span class='reg_span reg_span_btn'><input type="submit" value="Submit" class="btn-submit btn">
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
		 
		$("#frmEmailTemplate").validate({
			ignore: [],  	
			rules: {			
				title: "required",					
			    content: 
				{
					required: function() 
					{
						CKEDITOR.instances.content.updateElement();
					}
				},               
			},
		   
			messages: {
				title: "Please enter page title",							
			    content: "Please enter content",				    	    
			},
			errorPlacement: function(error, element) 
			{
				console.log(element);
				if (element.attr("name") == "content") 
				{
					error.insertAfter("#cke_content");
				}
				else 
				{
					error.insertAfter(element);
				}
			},
			errorElement:"div",
			errorClass:"valid-error",
			submitHandler: function(form) 
			{		
				form.submit();						
			}
		});				
	  });	  	  
	  function cancelButton()
	  {
		location.assign("<?php echo base_url(); ?>cdadmin/pages/manage");
	  } 
	</script>
	
	<style>
		.list_mrgn{ margin-bottom:13px; width:245px;}
		#sel_template {
	  width: 100%;
	}
	</style>
