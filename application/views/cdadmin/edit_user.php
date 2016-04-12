<?php //echo '<pre>';print_r($user_list);
$role='';
if(is_array($user_info) && count($user_info) > 0)
{
	$id = $user_info['user_id'];
	//$user_name = $user_info['user_name'];
	$email = $user_info['email'];
	$first_name = $user_info['first_name'];
	$last_name = $user_info['last_name'];
	$address = $user_info['address'];
	$biography = $user_info['biography'];
	$gender = $user_info['gender'];
	$dob = $user_info['dob'];
	if($dob=='0000-00-00')
		$dob='';
	$city = $user_info['city'];
	$state = $user_info['state'];
	$phone = $user_info['phone'];
	$zipcode = $user_info['zipcode'];
	$country_id = $user_info['country']?$user_info['country']:0;
	if(!empty($user_info['profile_image']))
	{
			$profile_image = base_url().'uploads/'.$user_info['profile_image'];
	}
	else
	{
			$profile_image = base_url().'assets/frontend/images/default-profile.png';
	}
	
	$active = $user_info['status'];
}
else
{
	$id = '';
	$user_name = '';
	$email = '';
	$first_name = '';
	$last_name = '';
	$gender = '';
	$dob = '';
	$address = '';
	$biography = '';
	$city = '';
	$state = '';
	$phone = '';
	$zipcode = '';
	$biography = '';
	$country_id = '';
	$profile_image = base_url().'assets/frontend/images/default-profile.png';
	$active = '';
}


?>

<form method="post" id="edit_user_form" name='edit_user_form' enctype="multipart/form-data"> 
	<div class="account-right-div">
		<div class="dashboard-heading"><h2><?php echo $page_title; ?></h2></div>
		<?php echo $breadcrum; ?>
		<div class="dashboard-inner">
			<div class="main-dash-summry Edit-profile">
				<input type="hidden" name="id" value="<?php echo $id; ?>" id="id">
				<div class="input-row">
					<div class="full">
						<div class="input-block">
							<label class="required">First Name :</label>
							<span class='reg_span'><input type="text" id='first_name' name="first_name" value="<?php echo $first_name; ?>" class="inputbox-main"></span>
						</div>
					</div>
				</div>
				<div class="input-row pull-right">
					<div class="full">
						<div class="input-block">
							<label class="required">Last Name :</label>
							<span class='reg_span'><input type="text" id='last_name' class="inputbox-main" type="text" name="last_name" value="<?php echo $last_name; ?>"></span>
						</div>
					</div>
				</div>
				<div class="input-row ">
					<div class="full">
						<div class="input-block">
							<label class="required">Email :</label>
							<span class='reg_span'><input type="text" id='email' readonly class="inputbox-main" type="text" value="<?php echo $email; ?>"></span>
						</div>
					</div>
				</div>
				<div class="input-row pull-right">
					<div class="full">
						<div class="input-block">
							<label>Phone :</label>
							<span class='reg_span'>
								<input class="inputbox-main" type="text" id="phone" name="phone" value="<?php echo $phone; ?>"/>
							</span>
						</div>
					</div>
				</div>
				<div class="input-row ">
					<div class="full">
						<div class="input-block">
							<label>Address :</label>
							<span class='reg_span'>
								<input type="text" id='address' class="inputbox-main" type="text" name="address" value="<?php echo $address; ?>">
							</span>
						</div>
					</div>
				</div>
				<div class="input-row pull-right">
					<div class="full">
						<div class="input-block">
							<label>City :</label>
							<span class='reg_span'>
								<input type="text" id='city' class="inputbox-main" type="text" name="city" value="<?php echo $city; ?>">
							</span>
						</div>
					</div>
				</div>
				<div class="input-row">
					<div class="full">
						<div class="input-block">
							<label>State :</label>
							<span class='reg_span'>
								<input type="text" id='state' class="inputbox-main" type="text" name="state" value="<?php echo $state; ?>">
							</span>
						</div>
					</div>
				</div>
				<div class="input-row pull-right">
					<div class="full">
						<div class="input-block">
							<label>Country :</label>
							<span class='reg_span'>
								
								<?php
								if(is_array($countries) && count($countries) > 0)
								{
									echo '<select class="inputbox-main input_select valid" name="country">';
									echo '<option value="">Select</option>';
									foreach($countries as $country)
									{
										if($country['item_id']==$user_info['country'])
										{
											$selected="selected";
										}
										else
										{
											$selected="";
										}
										echo '<option '.$selected.' value="'.$country['item_id'].'">';
										echo $country['country'];
										echo '</option>';
										
									}
									echo '</select>';
								}
								 ?>
							</span>
						</div>
					</div>
				</div>
				<div class="input-row ">
					<div class="full">
						<div class="input-block">
							<label>Date Of Birth :</label>
							<span class='reg_span'>
								<input class="inputbox-main" type="text" id="dob" name="dob" value="<?php echo $dob; ?>"/>
							</span>
						</div>
					</div>
				</div>
				<div class="input-row pull-right">
					<div class="full">
						<div class="input-block">
							<label>Brief description :</label>
							<span class='reg_span'>
								<textarea name="biography"><?php echo $biography; ?></textarea>
							</span>
						</div>
					</div>
				</div>
				
				<div class="input-row ">
					<div class="full">
						<div class="input-block">
							<label>Image :</label>
							<span class='reg_span reg_span-auto'>
								<input type="file" id='profile_image'  name="profile_image">
								<div class="user-pic">
									<img src="<?php echo $profile_image; ?>"/>
								</div>
							</span>
							
						</div>
					</div>
				</div>
				
					
				<div class="input-row full-width">
					<div class="full">
						<div class="input-block">
							<label> &nbsp; </label>
							<span class='reg_span reg_span_btn'>
								<input type="submit" value="Submit" name='edit_user' id='edit_user' class="btn-submit btn"> 
								<input type="button" value="Cancel" onclick="cancel()" class="btn-submit btn"> 
							</span>
						</div>
					</div>	
				</div>
			</div>
		</div>
	</div>
</form>
<script type='text/javascript'>
	
	$(function() {
		$('#edit_user_form').validate({
			rules:{
				first_name:'required',
				last_name:'required',
				email:'required'
			},
			messages:{
				first_name:'Please enter first name.',
				last_name:'Please enter last name.',
				email:'Please enter email.',
			},
			errorElement:"div",
			errorClass:"valid-error",
			submitHandler: function(form) {
				form.submit();
			}
		});
		
		$("#dob").datepicker({ 
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd',
			yearRange: '-100:+0'
		});
	});
  function cancel()
  {
	  window.location.href = '<?php echo base_url(); ?>cdadmin/users';
  }
</script>
