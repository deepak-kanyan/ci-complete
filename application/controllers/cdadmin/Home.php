<?php

class Home extends CI_Controller {

	function __construct()
	{		
		parent::__construct();		
		$this->load->model('admin_model');
		$this->load->library('session');
	}
	
	public function index()
	{
		
		if(!$this->session->userdata('admin_logged_in'))
		{
			redirect(base_url().'cdadmin/login');
		}else{
			
			redirect(base_url().'cdadmin/dashboard');
		}

	}
	public function login()
	{
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('email','email', 'trim|required');
		if ($this->form_validation->run() == true)
			{
				 if($this->admin_model->login()== true)
					{
						
						$this->session->set_flashdata('success',"");
						redirect(base_url().'cdadmin/dashboard');
						exit;
					}
					else
					{
						$this->session->set_flashdata('fail',"Login Failed: Invalid E-mail / Password.");
						redirect(base_url().'cdadmin/login');
						exit;
					}
			}
		$data['page_title'] = 'Login';
		
		$this->load->view('cdadmin/login');
	}
	
	public function logout()
	{ 
		
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('admin_id');
		$this->session->unset_userdata('admin_logged_in');
		$this->session->set_flashdata('success',"You have logged out securely.");
		redirect(base_url().'cdadmin/login');
	}	
	
}

