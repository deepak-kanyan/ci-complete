<script>
    function add_plan()
    {
        window.location = "<?php echo base_url(); ?>cdadmin/subscription/add";
    }
    function deluser(delId)
    {
        if(confirm('Are you sure, you want to delete ?')) {
            $.ajax({url: '<?php echo base_url(); ?>cdadmin/delUser/deleteId/'+delId,
                success: function (result) {
                    location.reload();
                },
                error: function (request,error) {
                            //alert('Network error has occurred please try again!');
                        }
                    });
        }
    }
    function changeStatus(langId)
    {
		if(confirm('Are you sure, you want to change language status?'))
		{
			window.location = '<?php echo base_url();?>cdadmin/change_language_status/'+langId;			
		}
	}
   
function searchUser()
{
    var search=$('#getSearch').val();
    var searchUserEmail=$('#searchUserEmail').val();
      //alert(searchUserEmail);
     
      if(search!='')
      {
          window.location = "<?php echo base_url(); ?>cdadmin/manage_user/task/search/search/"+search;
      }
      else
      {
          window.location = "<?php echo base_url(); ?>cdadmin/manage_user/";
      }
    }   

  /* 
    function listUser(userId)
    {
      window.location = "<?php echo base_url(); ?>cdadmin/list_user/task/listUser/userId/"+userId;
    }
    */
    
    
</script>
<style>
	.my_table_div .action-main-block a{
	border-radius: 3px;
    width: 33px;}
    
    .wide > span {
    text-transform: capitalize;
}
</style>
<?php
//echo '<pre>';print_r($plan_data);

$sort_arrow_uname='fa fa-angle-down menu-down';
$sort_arrow_email='fa fa-angle-down menu-down';
$sort_arrow_accType='fa fa-angle-down menu-down';

$array = $this->uri->uri_to_assoc(3);
if(array_key_exists ('task' , $array)) {
    if($array['task']=='search')
    {
        $search=$array['search'];
        $sort='asc';
    }
    else if($array['task']=='sorting')
    {
        if($array['order']=='asc')
        {   
			if($sortBy == 'username')
            {
				$sort='desc';
				$search='';
            
				$sort_arrow_uname='fa fa-angle-up menu-down';
			}
			if($sortBy == 'email')
			{
				$sort='desc';
				$search='';
				
				$sort_arrow_email='fa fa-angle-up menu-down';
			}
            if($sortBy == 'account_type')
            {
				$sort='desc';
				$search='';
				
				$sort_arrow_accType='fa fa-angle-up menu-down';
			}
            
            
        }
        else
        {
            
            if($sortBy == 'username')
            {
				$sort='asc';
				$search='';
				
				$sort_arrow_uname='fa fa-angle-down menu-down';
			}
			if($sortBy =='email')
			{
				$sort='asc';
				$search='';
				
				$sort_arrow_email='fa fa-angle-down menu-down';
			}
            if($sortBy == 'account_type')
            {
				$sort='asc';
				$search='';
				
				$sort_arrow_accType='fa fa-angle-down menu-down';
			}
            
        }
    }
    else
    {
       
        if($sortBy == 'username')
		{
			$sort='asc';
			$search='';
			
			$sort_arrow_uname='fa fa-angle-down menu-down';
		}
		if($sortBy == 'email')
		{
			$sort='asc';
			$search='';
			
			$sort_arrow_email='fa fa-angle-down menu-down';
		}
		if($sortBy == 'account_type')
		{
			$sort='asc';
			$search='';
			
			$sort_arrow_accType='fa fa-angle-down menu-down';
		}
    }
}
else
{
    $sort='asc';
    $search='';
}


if(!empty($search_type)){
    $search = $search_type;
}

?>
    <!--ul style='float:right;'>
    <?php $i=0; if(count($user_data)) { $i++; ?>
   
    <li><a href=''><?php echo 1; ?></a></li>
    <li><a href=''><?php echo 2; ?></a></li>
    <li><a href=''><?php echo 3; ?></a></li>
    <li><a href=''><?php echo 4; ?></a></li>
   
    <?php } ?></ul-->
   
    <!--link rel="stylesheet" href="<?php echo base_url(); ?>assets/cdadmin/css/bootstrap.min.css"-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/cdadmin/js/bootstrap.min.js"></script>   
   
    <div class="dashboard-heading">
		<h2>
			<?php echo $page_title; ?>
		</h2>
		<a href="<?php echo base_url(); ?>cdadmin/add_language/" class="add-user" ><i></i><span>Add Language</span></a>
    </div>

    <div class="dashboard-inner">
        <div class="dash-search">
                       
        </div>

        <div class="main-dash-summry Edit-profile nopadding11">
            <!--table-->
            <div class="my_table_div">
                <table class="fixes_layout">
                    <thead>
                        <tr>
                            <th class="forWidthSno"> <h1 class=""> S.No. </h1> </th>
                            <th>
								
									<h1 class="">
										Language Name 
									</h1>
								
                            </th>
                             <th>
								
									<h1 class="">
										Short Name 
									</h1>
								
                            </th>
                            <th class="user-center"> <h1 class=""> Status </h1> </th>
                            <th> <h1 class=""> Actions </h1> </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                               
								$page  = (int) $this->uri->segment(3,1);	
								
								$sn=1;
								
								if(isset($page) && !empty($page) && $page !=1 )
								{ 
								 	$sn =($page-1)*$page_size+1;
								}
                        
                        if(!empty($all_languages)) { 
						
						foreach($all_languages as $language) { 
							if($language['active'] == 1)
							{
								$img = base_url().'assets/cdadmin/images/status-active.png';
								$title="Active";
							}
							else
							{
								$img = base_url().'assets/cdadmin/images/status-inactive.png';
								$title="Inactive";
							}
							?>
							<tr>
								<td>
									<?php echo $sn; $sn++;?>
								</td>
								<td class="wide">
									<span title="<?php echo $language['language']; ?>" ><?php echo $language['language']; ?>
									</span>
								</td>
								<td>
									<span title="<?php echo $language['sysname']; ?>" ><?php echo $language['sysname']; ?>
									</span>
								</td>
								<td class="user-center">
									<?php if($language['sysname']=='en') { echo 'Default'; } else {  ?>
									<a onclick="changeStatus(<?php echo $language['id']; ?>);"  href="#">
										<img src='<?php echo $img;?>' title='<?php echo $title; ?>' style="cursor:pointer"/>
									</a>
									<?php } ?>
								</td>
							   
								<td class="action-main-block">
									<a title="Edit Language" href='<?php echo base_url(); ?>cdadmin/edit_language/<?php echo $language['id']; ?>' class="edit">&nbsp;</a>
									<!--a title="Delete Plan" onclick="deluser(<?php echo $language['id']; ?>);" class="del">&nbsp;</a-->
								</td>
							</tr>
							<?php } } else { ?>
							<tr>
								<td colspan="4" style='text-align:center;'>No result found.</td>
							</tr>
							<?php } ?>
						</tbody>

					</table>
					<!--end-->
				</div>
				<div class='pagination'>
					<?php echo $this->pagination->create_links(); ?>
				</div>
			</div>
		</div>
		<script>
			$(document).ready(function(){
				$('[data-toggle="tooltip"]').tooltip();  
			});
		</script>

