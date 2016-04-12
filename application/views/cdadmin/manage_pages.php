<?php //echo '<pre>';print_r($all_pages);die;  ?>    
    <div class="dashboard-heading">
		<h2>
			<?php echo $page_title; ?>
		</h2>
		<!--a href="#" class="add-user" onclick='add_plan()'><i></i><span>Add Subscription Plan</span></a-->
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
                            <!--th>
								
									<h1 class="">
										Page Title 
									</h1>
								
                            </th-->
                            <th >
								
									<h1 class=""> 
										Title 
									</h1>
								
							</th>
							<th >
								
									<h1 class=""> 
										Page Title
									</h1>
								
							</th>
							
                            <!--th>
								
									<h1 class=""> 
										Content
									</h1>
								
							</th-->
							<th class="actions">  
									<h1 class=""> 
										Actions 
									</h1> 
							</th>
							                           
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                            //echo '<pre>';print_r($user_data);
								$page  = (int) $this->uri->segment(4,1);	
								
								$sn=1;
								if(isset($page) && !empty($page) && $page !=1 )
								{ 
								 	$sn =($page-1)*$page_size+1;
								}
                        if(!empty($all_pages)) { foreach($all_pages as $page) 
                        { 													
							?>
							<tr>
								<td>
									<?php echo $sn; $sn++;?>
								</td>
								<!--td class="">
									
										<span ><?php echo $page['title']; ?>
									</span>
									
								</td-->
								<td class="">									
										<?php echo $page['title']; ?>									
								</td>
								<td class="">
									<?php echo substr($page['page_title'],0,80); ?>																	
								</td>									
								<!--td class="type_case">
									<?php echo substr($page['page_content'],0,40); ?>
								</td-->								
								<td class="action-main-block">
									<a title="Edit Page" href='<?php echo base_url(); ?>cdadmin/pages/edit/<?php echo $page['page_id']; ?>' class="edit">&nbsp;</a>									
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
		<style>
			.my_table_div .action-main-block a{
			border-radius: 3px;
			width: 33px;
			margin-left: 127px;
			}
			
			.wide > span {
			text-transform: capitalize;
		}
		.actions {
			  text-align: center !important;
			}
		</style> 
