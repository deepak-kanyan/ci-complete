<?php
class Pages extends CI_Controller {

	function __construct()
	{	
		parent::__construct();
		
		$this->load->model('admin_model');
		$this->load->model('Pages_model');
		$this->load->library('session');
		
		if(!$this->session->userdata('admin_logged_in'))
		{
			redirect(base_url().'cdadmin/login');
		}
	}
	
	
	public function manage()
	{
		$data['page_title'] = 'Manage Pages';
        $data['page']='pages';
        $data['active']='manage_master';
        $admin_id=$this->session->userdata('admin_id');
        $data['admin_name']=$this->admin_model->get_admin_detail($admin_id);      
        $this->load->library('pagination');
		
		$config['base_url'] = base_url().'cdadmin/pages/manage';
		$config['total_rows'] = count($this->Pages_model->getAllPages());
		$config['per_page'] = 15;
		$config['uri_segment'] = 4;
		$config['num_links'] = 2;
		
		$config['use_page_numbers'] = TRUE; 
		
		
		$this->pagination->initialize($config);
		
		$limit = $config['per_page'];
		
		$page_number = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		if(empty($page_number)) $page_number = 1;        
		$offset = ($page_number-1) * $config['per_page'];
		
		$data['page_size'] = $config['per_page'];
		
		$data['all_pages'] = $this->Pages_model->getAllPages(null,$limit, $offset);
		
		   
       
 		$data['body'] = $this->load->view('cdadmin/manage_pages', $data , true);
        $this->load->view('cdadmin/template',$data);
	}
	
	public function edit()
	{
		//echo 'here';
		$data['page_title'] = 'Edit Page';
		$data['active']='manage_master';
        $data['page']='pages';
        
        $admin_id=$this->session->userdata('admin_id');
        
        $data['admin_name']=$this->admin_model->get_admin_detail($admin_id);
        
        $page_id = $this->uri->segment(4,'');
              
        $data['all_content'] = $this->Pages_model->getAllLanguagePagesContent($page_id);
    
		$this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title','title', 'trim|required');
        $this->form_validation->set_rules('content','content', 'trim|required');

		if ($this->form_validation->run() == true)
			{
				if($this->Pages_model->update_static_content($page_id)==1)
				{
					$this->session->set_flashdata('success',"Page content updated successfully.");
					redirect(base_url().'cdadmin/pages/manage');
					exit;
				}
				
				else
				{
					$this->session->set_flashdata('fail',"Error!, Page content not updated.");
					redirect(base_url().'cdadmin/pages/manage');
					exit;
				}
			}
       
        $data['body'] = $this->load->view('cdadmin/edit_pages', $data , true);
        $this->load->view('cdadmin/template',$data);
        
	}	
		
}
