<div class="my-account-breadcrum">
	<ul class="breadcrum">
		<li>
			<a href="<?php echo base_url(); ?>cdadmin/dashboard" >Dashboard </a>
			<span><i class="fa fa-angle-double-right bread-icon"></i> </span>
		</li>

		<li>
			<a href="<?php echo base_url().'cdadmin/'.$parent_link; ?>" ><?php echo $parent_li; ?></a>
			<span> <i class="fa fa-angle-double-right bread-icon"></i> </span>
		</li>


		<li class="investment" id="investments">
			<?php echo $page_title; ?>
		</li>

	</ul>
</div>

