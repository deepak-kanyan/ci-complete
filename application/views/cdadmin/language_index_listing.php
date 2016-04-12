<style>
	.my_table_div .action-main-block a{
	border-radius: 3px;
    width: 33px;
    margin-left: 95px;
    }
    .actions {
			  text-align: center !important;
			}
    
    .search_form {
	//  width: 75%;
	  float:left;
	  margin-bottom: -20px;
	}
    .right_btns {
	  width: 25%;float:right;
	}
	.input-block span {
		width: 100%;
	}
	.input-block span.reg_span {
    float: none;
	}
	.valid-error {
		margin-top: 0;
		text-align: left;
		width: 180px;
	}
	form{margin-right: -60px;}
	.add_lang_btn {
		float: left;
		margin-left: 20px;
	}
	.reg_span_btn{
		margin-left:83px;
	}
	.dashboard-inner{
		min-height:0px;	
	}
	.list-search {
	  margin-right: 5px;
	}
</style>
<script type="text/javascript">
	$(document).ready(function(){
		
		
		$("#getLanguage1").change(function(){
			//alert("text.");
			var lang = $(this).val();
			//document.cookie = "selected_admin_lang="+lang; 
			//alert(lang);
			window.location = '<?php echo base_url();?>cdadmin/manage_languages/language/name/'+lang;
		});
		
		
	});
	
	
</script>
<div class="dashboard-heading">
	<h2><?php echo $page_title; ?></h2> 
	
		
	
</div>
		
		<div class="dashboard-inner">
			<div class="dash-search">
				
				<form name="frm_search_lang" id="frm_search_lang" method="post" action="<?php echo base_url();?>cdadmin/manage_languages">
					<div class="choose_lang">
						<select name="getLanguage" id="getLanguage" class="list-search" >
							
							<?php foreach($all_languages as $language){ ?>
								<option value="<?php echo $language['sysname'] ?>" <?php if(@$lang_title ==$language['language']) { echo "selected"; } ?>><?php echo $language['language'] ?></option>
							<?php }?>
						</select>
					</div>
					
					<div class="search_form">
						
						<div class="input-block" style="width:26%;">
							<span class="reg_span">
								<input type="text" name="search_lang_text" id="search_lang_text" class="list-search" placeholder="Enter Language Index" value='<?php echo $txtToSearch; ?>' />
							</span>
						</div>
						<span class='reg_span reg_span_btn'>
							<button class="add-user search-icon">
								<i></i>
								<span>Search</span>
							</button>	
						</span>
					</div>
				</form>        
                
                <div class="right_btns">
					<a href="<?php echo base_url().'cdadmin/add_new_translation/'; ?>" class="add-user"><i></i> <span>Add Language Index</span></a>
				</div>
				
			</div>
			
			<?php 
			
				//echo $sortAs;
				if($sortAs == 'desc')
				{
					krsort($translations);
					$index_sort_arrow = 'fa fa-angle-up menu-down';
				}
				if($sortAs == 'asc')
				{
					ksort($translations);
					$index_sort_arrow = 'fa fa-angle-down menu-down';
				}
				if(!empty($txtToSearch))
				{
					$href_url = base_url().'/cdadmin/manage_languages/language/'.$selected_lang.'/search_index/'.$txtToSearch.'/sort/'.$sort.'/page';
				}
				else
				{
					$href_url = base_url().'/cdadmin/manage_languages/language/'.$selected_lang.'/sort/'.$sort.'/page';
				}
			?>
				<div class="main-dash-summry Edit-profile nopadding11">
					<!--table-->
				<div class="my_table_div">
					<table class="fixes_layout">
						<thead>
							<tr>
								<th > <h1 class=""> S.No. </h1> </th>
								<th><a class='underline_classs' href='<?php echo $href_url; ?>' >
									 <h1 class=""> 
										Language Index <i class="<?php echo $index_sort_arrow; ?>"></i>
									</h1>
								</th>
								<th > <?php echo $lang_title; ?></th>
							<!--	<th > Spanish </th>-->
								<!--th> <h1 class="">Manager</a></h1> </th-->
								 <th class="actions"> <h1 class=""> Actions </h1> </th>
							</tr>
						</thead>
						<tbody>
						<?php
							
							//echo '<pre>';print_r($translations); die;
								$page  = $page_number;	
								
								$sn=1;
								if(isset($page) && !empty($page) && $page !=1 )
								{ 
								 	$sn =($page-1)*$page_size+1;
								}
											
							if(count($translations) > 0)
							{
								$idx=0;
								$start_position = $page_number;
								$end_position = ($start_position + $page_size) - 1;
								//print $start_position.'|'.$end_position;
								foreach($translations as $index => $value)
								{
									if($idx >= $start_position && $idx <= $end_position)
									{
										$rowclass = (($idx % 2)==0) ? ' class="row1" ' : ' class="row2" ';
							?>
							<tr>
								<td><?php echo $sn; $sn++;?></td>
								<td><?php echo $index; ?></td>
								<td class="wide"><?php echo $value; ?></td>
							<!--	<td class="wide"><?php echo $translations_spanish[$index]; ?></td>-->
								<td class="action-main-block"><a title="Edit Language Translation" href="<?php echo base_url().'cdadmin/edit_language_translation/'.$index; ?>" class="edit">1</a></td>
								<!--td class="action-main-block">
									 <a data-toggle="tooltip" title="Edit User" href='<?php echo base_url(); ?>cdadmin/upd_user/editId/<?php echo $userInfo->user_id; ?>' class="edit">1</a>
									  <a data-toggle="tooltip" title="Delete User" onclick="deluser(<?php echo $userInfo->user_id; ?>);" class="del">1</a> 
								</td-->
							 </tr>
							<?php }
							$idx++;} } else { ?>
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
		<script type="text/javascript">

			
			$(function() {
				$("#frm_search_lang1").validate({
					rules: {
						search_lang_text: "required"		
					},
				   
					messages: {
						search_lang_text: "Please enter language index."
						},
					
					 errorElement:"div",
					errorClass:"valid-error",
					submitHandler: function(form) {
						form.submit();
					}
				});
			  });
			
		</script>
		<script type="text/javascript">
		 function cancelButton()
		  {
			location.assign("<?php echo base_url(); ?>cdadmin/manage_languages");
		  } 
		</script>	
