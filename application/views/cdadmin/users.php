<?php 
	$sort_arrow_uname='fa fa-angle-down menu-down';
	$sort_arrow_email='fa fa-angle-down menu-down';
	$sort_arrow_accType='fa fa-angle-down menu-down';
	$page  = isset($page) && $page != 0 ? $page : 0;
	$srno = isset($offset) ? $offset+1 : 1;
	if(isset($search))
	{
		if (strpos($search,'_') !== false)
		{
			$search = explode('_',$search);
			if(count($search) > 0)
			{
				$search = $search[0].' '.$search[1];
			}
		}
		else
		{
			$search = $search;
		}
	}
	else
	{
		$search = '';
	}
	$order = isset($order) && $order == 'asc' ? 'desc' : 'asc';
	$sort_arrow_email = isset($sort) && $sort=='email' ? ($order == 'asc' ? 'fa fa-angle-down menu-down' : 'fa fa-angle-up menu-down'): 'fa fa-angle-down menu-down';
	$sort_arrow_uname = isset($sort) && $sort=='name' ? ($order == 'asc' ? 'fa fa-angle-down menu-down' : 'fa fa-angle-up menu-down'): 'fa fa-angle-down menu-down';
	
?>
<div class="dashboard-heading">
	<h2><?php echo $title; ?></h2>
</div>
<div class="dashboard-inner">
	<div class="dash-search">
		<input type='text' name='search' id='search' value='<?php echo $search; ?>' class='list-search' placeholder='Name or Email' />
		<button class="btn-submit btn" onclick='search()'>
			<span> <i class="fa fa-search search-icon"></i></span>
			Search
		</button>
	</div>

<div class="main-dash-summry Edit-profile nopadding11">
	<div class="my_table_div">
		<table class="fixes_layout" id="users_table">
			<thead>
				<tr>
					<th style="width:6%;"> <h1 class=""> S. No. </h1> </th>
					<th style="width:12%;"> <h1 class=""> Image </h1> </th>
					<th>
						<a class='underline_classs' href='<?php echo base_url(); ?>cdadmin/users/0/<?php echo $order; ?>/<?php echo $search; ?>/sort/name/'>
						<h1 class="">
							Name <i class="<?php echo $sort_arrow_uname; ?>"></i>
						</h1>
						</a>
					</th>
					<th style="width:28%;">
						<a class='underline_classs' href='<?php echo base_url(); ?>cdadmin/users/0/<?php echo $order; ?>/<?php echo $search; ?>/sort/email/'>
						<h1 class=""> 
							Email <i class="<?php echo $sort_arrow_email; ?>"></i>
						</h1>
						</a>
					</th>
					
					<th style="width:6%;"><h1 class="" > Status </h1> </th>
					<th> <h1 class=""> Actions </h1> </th>
				</tr>
			</thead>
			<tbody>
				<?php 
					if(isset($user_info) && count($user_info) > 0) {
						foreach($user_info as $user){
							if($user->status  == 1) {
								$img = base_url().'assets/cdadmin/images/status-active.png';
								$img_title="Active";
							} else {
								$img = base_url().'assets/cdadmin/images/status-inactive.png';
								$img_title="Inactive";
							}
							if($user->status  == 1) {
								$img_ver = base_url().'assets/cdadmin/images/status-active.png';
								$img_ver_title="Verified";
							} else {
								$img_ver = base_url().'assets/cdadmin/images/status-inactive.png';
								$img_ver_title="Not verified";
							}
					?>
							<tr>
								<td><?php echo $srno; ?></td>
								<td>
									<?php 
									if($user->profile_image != '') {
										$path = dirname(dirname(dirname(__DIR__))).'/uploads/'.$user->profile_image;
										if( file_exists($path) ) {
											$imgpath = base_url().'uploads/'.$user->profile_image;
										} else {
											$imgpath = base_url().'assets/frontend/images/default-profile.png';
										}
									} else {
										$imgpath = base_url().'assets/frontend/images/default-profile.png';										
									}
									echo "<div class='image-popup' id='image-popup".$user->user_id."' title='View Image'><img src='".$imgpath."' class='talent-hover'></div>";
								?>
								</td>
								<td class="wide">
									<span data-toggle="tooltip" title="<?php echo $user->first_name.' '.$user->last_name; ?>" >
										<?php echo $user->first_name.' '.$user->last_name; ?>
									</span>
								</td>
								<td class="email_word"><?php echo $user->email; ?></td>
								
								<td id="user_status<?php echo $user->user_id; ?>">
									<a  href="javascript:void(0)"  onclick="change_status(<?php echo $user->user_id; ?>)">
										<img src='<?php echo $img;?>' title='<?php echo $img_title; ?>' style="cursor:pointer"/>
									</a>
								</td>
								<td class="action-main-block">
									
									<a title="Edit User" class="edit" href='<?php echo base_url(); ?>cdadmin/users_edit/<?php echo $user->user_id; ?>'>&nbsp;</a>
									
									<a title="Delete User" onclick='return confirm("Are you sure to delete this user?")' href='<?php echo base_url(); ?>cdadmin/users_edit/<?php echo $user->user_id; ?>/delete' class="del" >&nbsp;</a>
								</td>
							</tr>
					<?php $srno++; } } else { ?>
					<tr>
						<td colspan="7" style='text-align:center;'>No result found.</td>
					</tr>
					<?php } ?>
			</tbody>
		</table>
			<!--end-->
	</div><!-- my_table_div -->
	<div class='pagination' style='text-align:center'>
		<?php echo $this->pagination->create_links(); ?>
	</div>
</div>
</div>
<script type="text/javascript">
function change_status(id)
{
	$.ajax(
	{
		type:'POST',
		url:'<?php echo base_url(); ?>cdadmin/change_status',
		data:{'id':id},
		success : function(data)
		{
			if(data == 'Inactive') {
				$('#user_status'+id+' a').html('<img src="<?php echo base_url();?>assets/cdadmin/images/status-inactive.png" title="Inactive" style="cursor:pointer"/>');
				
			} else if(data == 'Active')	{
				$('#user_status'+id+' a').html('<img src="<?php echo base_url();?>assets/cdadmin/images/status-active.png" title="Active" style="cursor:pointer"/>');
			}
			
			$('.messages').html('<div class="alert alert-success" id="succ_flash"><img src="<?php echo base_url(); ?>assets/cdadmin/images/img_1.png">Status Updated Successfully</div>');
			//setTimeout(function(){ $('#succ_flash').fadeOut('slow'); }, 4000);
		}
	});
}
function change_verified(id)
{
	$.ajax(
	{
		type:'POST',
		url:'<?php echo base_url(); ?>cdadmin/change_verification',
		data:{'id':id},
		success : function(data)
		{
			if(data == 'notverified') {
				$('#user_verified'+id+' a').html('<img src="<?php echo base_url();?>assets/cdadmin/images/status-inactive.png" title="Not verified" style="cursor:pointer"/>');
				
			} else if(data == 'verified')	{
				$('#user_verified'+id+' a').html('<img src="<?php echo base_url();?>assets/cdadmin/images/status-active.png" title="Verified" style="cursor:pointer"/>');
			}
			
			$('.messages').html('<div class="alert alert-success" id="succ_flash"><img src="<?php echo base_url(); ?>assets/cdadmin/images/img_1.png">Status Updated Successfully</div>');
			//setTimeout(function(){ $('#succ_flash').fadeOut('slow'); }, 4000);
			
		}
	});
}
function search()
{
	var search = $('#search').val();
	document.location.href = '<?php echo base_url(); ?>cdadmin/users/0/<?php echo $order ;?>/'+search;
}
</script>
