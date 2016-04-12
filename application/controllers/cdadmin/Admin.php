<?php
class Admin extends CI_Controller {

	function __construct()
	{	
		parent::__construct();	
		$this->load->model('admin_model');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('form_validation');
		if(!$this->session->userdata('admin_logged_in'))
		{
			redirect(base_url().'cdadmin/login');
		}
	}
	
	public function index()
	{
		$this->dashboard();
	}
	
	public function dashboard()
	{
		
		$data=array();
		$data['page_title'] = 'Dashboard';
		$data['page']='Dashboard';
		$data['active']='dashboard';
		$admin_id=$this->session->userdata('admin_id'); 
		$data['admin_name']=$this->admin_model->get_admin_detail($admin_id);
		$this->load->view('cdadmin/dashboard', $data , false);
	}
	
	public function config()
	{
		
		$data['page_title'] = 'Edit Admin Details';
         $data['active']='manage_settings';      
        $admin_id=$this->session->userdata('admin_id');
        
        $data['admin_name']=$this->admin_model->get_admin_detail($admin_id);      
        
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('admin_email','admin_email', 'trim|required');        
		if ($this->form_validation->run() == true)
		{
			if($this->admin_model->update_admin_config($admin_id)==1)
			{
				$this->session->set_flashdata('success',"Admin Details updated successfully.");
				redirect(base_url().'cdadmin/config');
				exit;
			}
			
			else
			{
				$this->session->set_flashdata('fail',"Error!, Admin Details not updated.");
				redirect(base_url().'cdadmin/config');
				exit;
			}
		}
        $data['all_config'] = $this->admin_model->getAllConfig($admin_id);
		
		//echo '<pre>';print_r($data['all_config']);die;            
       
 		$data['body'] = $this->load->view('cdadmin/admin_config', $data , true);
 		
        $this->load->view('cdadmin/template',$data);
	}
	public function changepassword()
	{
		$data=array();
		$admin_id=$this->session->userdata('admin_id');
		//$data['admin_role']=$this->admin_model->get_admin_role($admin_id);
		
		$data['admin_name']=$this->admin_model->get_admin_detail($admin_id);
		$data['page_title']='Change Password';	
		$data['page']='chg_pwd';	
		$data['active']='manage_settings';
		
		$this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('new_pwd','new_pwd', 'trim|required');
		if ($this->form_validation->run() == true)
			{
				 if($this->admin_model->check_password($admin_id)==1)
					{
						$this->session->set_flashdata('success',"Password updated successfully.");
						redirect(base_url().'cdadmin/changepassword');
						exit;
					}
					
					else
					{
						$this->session->set_flashdata('fail',"Current password is incorrect. Please try again.");
						redirect(base_url().'cdadmin/changepassword');
						exit;
					}
			}
			
			
			$data['body'] = $this->load->view('cdadmin/change_pwd',$data, true);
			$this->load->view('cdadmin/template',$data);
			
	}
	
	/**
	 * List Site users
	 * */
	function users()
	{
			$data['title'] = 'Manage users';
			$data['active'] = 'users';
			$admin_id=$this->session->userdata('admin_id'); 
			$data['admin_name']=$this->admin_model->get_admin_detail($admin_id);
		
			$config['per_page']  = $limit = 10;
			$data['page'] = $page = $this->uri->segment(3) && $this->uri->segment(3) != 0 ? $this->uri->segment(3) : 0;
			$data['offset'] = $offset = $page;
			$order = $data['order'] = $this->uri->segment(4,'desc');
		 	$data['search'] = $search = $this->uri->segment(5,'');
			$config['base_url'] = base_url().'cdadmin/users/';
			if($search == '' || $search == 'sort')
			{
				$data['search'] = $search = '';
				$data['sort'] = $sort = $this->uri->segment(6);
			} else {
				$data['sort'] = $sort = $this->uri->segment(7);
			}
			if (strpos($search,'_') !== false)
			{
				$search = explode('_',$search);
				if(count($search) > 0)
				{
					$search = $search[0].' '.$search[1];
				}
			}
		//	$config['postfix_string'] = '/'.$order.'/'.$search.'/sort/'.$sort;
			$config['suffix'] = '/'.$order.'/'.$search.'/sort/'.$sort;
			//$config['prefix'] = '/'.$order.'/'.$search.'/sort/'.$sort;
			$data['user_info'] = $this->admin_model->get_user_info($offset,$limit,$search,$sort,$order);
			$config['total_rows'] = $this->admin_model->users_count($search);
			$config['uri_segment'] = 3;
			$config['display_pages'] = TRUE; 
			$this->pagination->initialize($config);
			$data['page_title'] = 'Manage Users';
			$data['body'] = $this->load->view('cdadmin/users',$data,true);
			$this->load->view('cdadmin/template',$data);
	}
	
	/*
	 * Manage users operation (edit/delete )
	 * */
	function users_edit()
	{
			$admin_id=$this->session->userdata('admin_id'); 
			$data['admin_name']=$this->admin_model->get_admin_detail($admin_id);
			$user_id = $this->uri->segment(3,'');
			$mode = $this->uri->segment(4);
			if($mode == 'delete' && is_numeric($user_id)) {
				$this->admin_model->delete_user_byId($user_id);
				$this->session->set_flashdata('success','User has been deleted successfully.');
				redirect(base_url().'cdadmin/users');
			} else {
					$this->form_validation->set_rules('first_name','first_name', 'trim|required');
					if($this->form_validation->run() == true)
					{
						if($this->admin_model->update_user_info($user_id))
						{
							$this->session->set_flashdata('success','User has been updated successfully.');
							redirect(base_url().'cdadmin/users');
						}
						else
						{
							$this->session->set_flashdata('fail','User failed to be updated.');
							redirect(base_url().'cdadmin/users');
						}
					}
					//~ $res = $this->admin->update_user_info($user_data,$id);
					//~ $this->session->set_flashdata('success_msg','User has been updated successfully.');
					//~ redirect(base_url().'admin/home/users');
				}
				$data['active'] = 'users';				
				//$data['countries']  = $this->admin_model->get_country();
				$data['user_info'] = $this->admin_model->get_user_byId($user_id);
				if(empty($data['user_info'])) {
					redirect(base_url().'cdadmin/users');
				}
				$data['countries']=$this->admin_model->get_country();
				$data['page_title'] = $page_title['title'] = 'Edit user';
				$data['nav_menu'] = 'users';
				$data_breadcrum = array('parent_link'=> 'users', 'parent_li'=> 'Users', 'title' =>$data['page_title']);
				$data['breadcrum'] = $this->load->view('cdadmin/breadcrum',$data_breadcrum,true);
				$data['body'] = $this->load->view('cdadmin/edit_user',$data,true);
				$this->load->view('cdadmin/template',$data);
			
	}
	/*
	 * @change status of user
	 * */
	function change_status()
	{
			$id = $this->input->post('id');
			$user_info = $this->admin_model->get_user_info('','','','','',$id);
			if($user_info[0]->status == 1) 	{
				$res = $this->admin_model->update_user_byId('status',$id,'0');
				$val = 'Inactive';
			} else 	{
				$res = $this->admin_model->update_user_byId('status',$id,'1');
				$val = 'Active';
			}
			if($res) {
				$this->session->set_flashdata('success','User has been updated successfully.');
				echo $val;
			}
			die;
		
	}
	
	/*
	 *  Language Management Start Here
	 */
	
	public function manage_languages()
	{	
		$url_array = $this->uri->uri_to_assoc(3);
				
		$searchLanguage = $this->input->post("getLanguage");
		$txtSearch = $this->input->post("search_lang_text");
		//print_r($_POST);
		
			$data=array();
			$admin_id=$this->session->userdata('admin_id');
					
			$data['admin_name']=$this->admin_model->get_admin_detail($admin_id);
			$data['page_title']='Manage Languages Index';	
			$data['page']='manage_lang';
			$all_languages = $this->admin_model->getAllAdminLanguages();
			$data['all_languages'] = $all_languages;
			
			foreach($all_languages as $all_lang)
			{
				$languages[] = $all_lang['sysname'];
			}
			//print_r($languages);die;
			
			if(count($url_array))
			{
				$selected_lang = $url_array['language'];
				if(isset($url_array['search_index']))
				{
					$txtSearch = $url_array['search_index'];
				}
				else
				{
					$txtSearch='';
				}
			}
			else
			{
				if($searchLanguage)
				{
					$selected_lang = $searchLanguage ;			
					$txtSearch = $txtSearch;
				}
				else			
				{
					$selected_lang = 'en';								
				}
			}			
			
			$data['selected_lang'] = $selected_lang;
			$lang_details = $this->admin_model->getLanguagesDetails($selected_lang);
			
			$ln = $selected_lang;
			
			$data['lang_title'] = $lang_details['language'];
			
			$this->session->set_userdata('current_language', $lang_details);		
			
			$data['languages'] = $languages;		
			
			$data['txtToSearch'] = $txtSearch;		
			if(isset($url_array['sort']))
			{
				$txtSort = $url_array['sort'];
			}
			else
			{
				$txtSort = 'asc';
			}
			
			if($txtSort == 'desc')
			{
				$data['sortAs'] = 'desc';
				$data['sort'] = 'asc';
			}
			else
			{
				$data['sortAs'] = 'asc';
				$data['sort'] = 'desc';
			}
			
			
			$session_languages = array();
			$session_languages_translations = array();
			
			foreach($data['languages'] as $ln)
			{
				$session_languages['languages'][$ln]['folder']= $ln;
				$session_languages['languages'][$ln]['filename']= $ln.'/admin_lang.php';
			}
			//~ $session_languages['folder']= $ln;
			//~ $session_languages['filename']= $ln.'/admin_lang.php';
			
			
			$session_languages = $session_languages['languages'];
			$this->session->set_userdata('languages', $session_languages);
			
			//foreach($session_languages as $slangs)
			//{
			//	echo '<pre>';
			//	print_r($session_languages);
				
				 $langfile = APPPATH.'language/'.$session_languages[$selected_lang]['filename']; 
				//echo $langfile;die;
				if (file_exists($langfile))
				{
					//echo 'here_22here';
					$slang=array();
					$source_lang = file_get_contents($langfile);
					$source_lang = str_replace('$lang','$slang', $source_lang);
					
					$fso = fopen(APPPATH.'language/tmp'.$session_languages[$selected_lang]['folder'].'.txt', 'w+');
					fwrite($fso, $source_lang);
					fclose($fso);
					include(APPPATH.'language/tmp'.$session_languages[$selected_lang]['folder'].'.txt');
					foreach($slang as $key => $value)
					{
						$slang[$key] = html_entity_decode($value, ENT_QUOTES);
					}
					$session_languages_translations['translations'][$session_languages[$selected_lang]['folder']] = $slang;
				}
			//}
			
			//$this->session->set_userdata('translations', $session_languages_translations['translations']);
			$translations = array();
			$translations = $session_languages_translations['translations'];
			
			$data['translations'] = $translations[$selected_lang];
			//echo '<pre>';print_r($data['translations']); die;
			
			
			$this->load->library('pagination');
			
			if($txtSearch)
			{
				$tarr = array();
				foreach($data['translations'] as $tidx => $tval)
				{
					if(stristr($tval, $txtSearch) || stristr($tidx, $txtSearch))
						$tarr[$tidx] = $tval;
				}
				$data['translations'] = $tarr;		
				
				$config['base_url'] = base_url().'cdadmin/manage_languages/language/'.$selected_lang.'/search_index/'.$txtSearch.'/page';
			}
			else
			{
				$config['base_url'] = base_url().'cdadmin/manage_languages/language/'.$selected_lang.'/page';
			}
				
			
			
			
			$config['total_rows'] = count($data['translations']);
			//$config['uri_segment'] = 6; 
			$config['num_links'] = 2;
			if($txtSearch)
			$config['postfix_string'] = '/'.$txtSearch;
			//start here
			$config['per_page'] = 15;
			$config['use_page_numbers'] = TRUE; 
			$this->pagination->initialize($config); 
			
			//$data['page_number'] = $this->uri->segment(6,0);
			if(isset($url_array['page']))
			{
				$data['page_number'] = $url_array['page'];
			}
			else
			{
				$data['page_number'] = '';
			}
			$data['page_size'] = 15;
			
			if ($this->session->flashdata('success'))
			{
				$data['success'] = $this->session->flashdata('success'); 
			}		
			if ($this->session->flashdata('message'))
			{
				$data['message'] = $this->session->flashdata('message');
			}
			if ($this->session->flashdata('error'))
			{
				$data['error'] = $this->session->flashdata('error');
			}
			
			$all_languages = $this->admin_model->getAllAdminLanguages();
			$data['all_languages'] = $all_languages;
			
			$data['body'] = $this->load->view('cdadmin/language_index_listing',$data, true);
			
			$this->load->view('cdadmin/template',$data);
			
	}
	
	function add_new_translation()
	{
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('text_index', $this->lang->line('admin_translation_name', 'en'), 'trim|required');
		//$this->form_validation->set_rules('text_index', 'text_index', 'callback_index_check');
		$admin_id=$this->session->userdata('admin_id');
		$data['admin_name']=$this->admin_model->get_admin_detail($admin_id);
		$session_languages = $this->session->userdata('languages');

//		$session_languages = $this->admin_model->getAllLanguages();
		
		// echo '<pre>';print_r($session_languages);die;
		foreach($session_languages as $slangs)
		{
			$langfile = APPPATH.'language/'.$slangs['filename']; 
			if (file_exists($langfile))
			{ 
				//include(APPPATH.'language/tmp'.$slangs['folder'].'.txt');
				include(APPPATH.'language/'.$slangs['folder'].'/admin_lang.php');
				foreach($lang as $key => $value)
				{
					$lang[$key] = html_entity_decode($value, ENT_QUOTES);
				}
				//~ echo '<pre>';print_r($slang); die;
				$session_languages_translations['translations'][$slangs['folder']] = $lang; 
			}
		}
		
		$session_language_translations = $session_languages_translations['translations'];
		//~ echo '<pre>';echo count($session_languages_translations['translations']['en']);echo count($session_languages_translations['translations']['sp']);print_r( $session_languages_translations); die;
		$all_languages = $this->admin_model->getAllAdminLanguages();
		$data['all_languages'] = $all_languages;
		$data['page']='manage_lang';
		$data['parent_li'] = 'Manage Languages';
		$data['parent_link'] = 'manage_languages';
		
		if ($this->form_validation->run() == TRUE) // form submitted
		{
			
			//~ print_r($session_language_translations); die;
			if(isset($_POST['text_index']) && $_POST['text_index'])
			{
				$text_index = $_POST['text_index'];
				foreach($_POST as $key => $val)
				{
				
					if(substr($key, 0, 6) == "field_")
					{
						$tarr = explode("_", $key);
						$lang_folder = $tarr[1]; 
						$session_language_translations[$lang_folder][$text_index] = $val;
					}
				}
				
				$this->session->set_userdata('translations', $session_language_translations);
				//~ echo '<pre>';echo count($session_language_translations['en']);echo count($session_language_translations['sp']);print_r( $session_language_translations); die;
				$session_languages = $this->session->userdata('languages');
				
				foreach($session_languages as $slangs)
				{
					$folder = $slangs['folder'];
					$strlang = '<?php '. PHP_EOL;
					foreach($session_language_translations[$folder] as $tkey => $tval)
					{
						$strlang .= '$lang[\''.$tkey.'\'] = \''.htmlspecialchars($tval, ENT_QUOTES).'\'; '. PHP_EOL;
					}
					$strlang .= '?>';
					
					$langfile = APPPATH.'language/'.$slangs['filename']; 
					$fso = fopen($langfile, 'w+');
					fwrite($fso, $strlang);
					fclose($fso);
					
					$backup_file=APPPATH.'language/tmp_bk_'.$slangs['folder'].'.txt';
					copy($langfile, $backup_file);
				}
					$this->session->set_flashdata('success', "Language index added successfully."); 
					redirect( base_url(). 'cdadmin/manage_languages');
					
					
			}
			else
			{
				$this->session->set_flashdata('error', "Language index not added.");
				redirect( base_url(). 'cdadmin/manage_languages');
			}
		}
		
		$data['page_title'] = 'Add Language Index';
		$data['section_heading'] = 'Add Language Index';
		$data['snbreadcrum'] = $this->load->view('cdadmin/snbreadcrum', $data , true);
		$data['body'] = $this->load->view('cdadmin/language_index_add',$data, true);
		
		$this->load->view('cdadmin/template',$data);
	}
	function edit_language_translation()
	{
		$text_index = $this->uri->segment(3, '');
		
		if($text_index)
		{
			//~ echo $text_index;die;
			$data['text_index'] = $text_index;
			$this->load->library('form_validation');
			$this->form_validation->set_rules('text_index', $this->lang->line('admin_translation_name', 'en'), 'trim|required');
			$session_languages = $this->session->userdata('languages');
			foreach($session_languages as $slangs)
			{
				$langfile = APPPATH.'language/'.$slangs['filename'];
				if (file_exists($langfile))
				{
					include($langfile);
				//	include(APPPATH.'language/tmp'.$slangs['folder'].'.txt');
					foreach($lang as $key => $value)
					{
						$lang[$key] = html_entity_decode($value, ENT_QUOTES);
					}
					$session_languages_translations['translations'][$slangs['folder']] = $lang;
				}
				
				/*
				 * 
				 * $langfile = APPPATH.'language/'.$slangs['filename'];
				if (file_exists($langfile))
				{
					include(APPPATH.'language/tmp'.$slangs['folder'].'.txt');
					foreach($slang as $key => $value)
					{
						$slang[$key] = html_entity_decode($value, ENT_QUOTES);
					}
					$session_languages_translations['translations'][$slangs['folder']] = $slang;
				}
				 * */
			} 
			$session_language_translations = $session_languages_translations['translations'];
			
			$data['session_translations'] = $session_language_translations;
			
			$all_languages = $this->admin_model->getAllAdminLanguages();
			$data['all_languages'] = $all_languages;
			
			$admin_id=$this->session->userdata('admin_id');
			$data['admin_name']=$this->admin_model->get_admin_detail($admin_id);
			$data['page']='manage_lang';
			$data['parent_li'] = 'Manage Languages';
			$data['parent_link'] = 'manage_languages';	
			if ($this->form_validation->run() == TRUE) // form submitted
			{
				
				if(isset($_POST['text_index']) && $_POST['text_index'])
				{
					$text_index = $_POST['text_index'];
					foreach($_POST as $key => $val)
					{
						if(substr($key, 0, 6) == "field_")
						{
							$tarr = explode("_", $key);
							$lang_folder = $tarr[1];
							$session_language_translations[$lang_folder][$text_index] = $val;
						}
					}
					
					foreach($session_languages as $slangs)
					{
						$folder = $slangs['folder'];
						$strlang = '<?php'. PHP_EOL;
						//~ echo '<pre>'; print_r($session_languages	); die;
						foreach($session_language_translations[$folder] as $tkey => $tval)
						{
							$strlang .= '$lang[\''.$tkey.'\'] = \''.htmlspecialchars($tval, ENT_QUOTES).'\'; '. PHP_EOL;
						}
						$strlang .= '?>';
						
						$langfile = APPPATH.'language/'.$slangs['filename'];
						$fso = fopen($langfile, 'w+');
						if(!fwrite($fso, $strlang)){
							
							$old_file=APPPATH.'language/tmp'.$slangs['folder'].'.txt';
							$backup_file=APPPATH.'language/tmp'.$slangs['folder'].date('m-d-Y_hia').'.txt';
							copy($old_file, $backup_file);
						}
						else
						{
							$old_file = APPPATH.'language/'.$slangs['filename'];
							$backup_file=APPPATH.'language/tmp_bk_'.$slangs['folder'].'.txt';
							copy($old_file, $backup_file);
						}
						fclose($fso);
						//exec('/usr/bin/svn commit '.APPPATH.'language/'.$slangs['filename'].' -m "Commit Static Text" --username svn@ebaviator.com  --password svnuser');
					}
					$this->session->set_flashdata('success', "Language index has been updated successfully."); 
					redirect( base_url(). 'cdadmin/manage_languages');
				}
				else
				{
					
					$this->session->set_flashdata('error', "Language index updation failed.");
					redirect( base_url(). 'cdadmin/manage_languages');
				}
			}
			//~ die('adsas');
			$data['page_title'] = 'Edit Language Index';
			$data['section_heading'] = 'Edit Language Text';
			//~ die('adsas');
			$data['snbreadcrum'] = $this->load->view('cdadmin/snbreadcrum', $data , true);
			//~ die('adsas');
			$data['body'] = $this->load->view('cdadmin/language_index_edit',$data, true);
		//~ die('adsdfsas');
			$this->load->view('cdadmin/template',$data);
		}
		else
		{
			redirect( base_url(). 'cdadmin/manage_languages');
		}
	}
	
	public function add_new_langauge()
	{
		//echo '<pre>';print_r($_POST);die;
		if($this->admin_model->add_new_langauge() == 'TRUE')
		{
			$this->session->set_flashdata('success', "Language added successfully.");
			redirect( base_url(). 'cdadmin/languages');
		}
		else
		{
			$this->session->set_flashdata('error', "Language not added.");
			redirect( base_url(). 'cdadmin/languages');
		}
	}
	
	public function change_language_status()
	{
		$language_id = $this->uri->segment('3');
		if($this->admin_model->changeLanguageStatus($language_id) == 'TRUE')
		{
			$this->session->set_flashdata('success',"Language Status Changed successfully.");
			redirect(base_url().'cdadmin/languages');
			exit;

		}
		else
		{
			$this->session->set_flashdata('fail',"Failed! Language Status Not Changed.");
			redirect(base_url().'cdadmin/languages');
			exit;
		}
		
	}
	
	
	public function languages()
	{
		
		$data['page_title'] = 'Manage Languages';
        
        $admin_id=$this->session->userdata('admin_id');
        
        $data['admin_name']=$this->admin_model->get_admin_detail($admin_id);
        
        $config['base_url'] = base_url() . "cdadmin/languages/";        
	
		$config['per_page'] = 15;
	
		$config['uri_segment'] = 3;
	
		$config['use_page_numbers'] = TRUE; 
		
		$config['reuse_query_string'] = TRUE; 
		
		$page_number = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
	
		if(empty($page_number)) $page_number = 1;        
	
		$offset = ($page_number-1) * $config['per_page'];		 
	
		$config['total_rows'] = count($this->admin_model->getAllAdminLanguages());  
			
		$this->pagination->cur_page = $offset;
	
		$this->pagination->initialize($config); 
	
		$data ['all_languages']=$this->admin_model->getLanguages($config['per_page'], $offset);
		
		$data['page_size'] = $config['per_page'];
		
        $data['body'] = $this->load->view('cdadmin/languages', $data , true);
        
        $this->load->view('cdadmin/template',$data);
	}
	
	
	public function add_language()
	{
		$admin_id=$this->session->userdata('admin_id');
		
		$data['admin_name']=$this->admin_model->get_admin_detail($admin_id);
		
		$data['page_title'] = 'Add Language';
		
		$data['parent_li'] = 'Languages';
		
		$data['parent_link'] = 'languages';
		
		$data['snbreadcrum'] = $this->load->view('cdadmin/snbreadcrum', $data , true);
		
		$data['body'] = $this->load->view('cdadmin/language_add', $data , true);
        
        $this->load->view('cdadmin/template',$data);
		
	}
	
	public function edit_language($id)
	{
		$language_id = (int) $id;
		if(empty($language_id) || $language_id==0)
		{
			redirect(base_url().'cdadmin/languages');
		} 
		else
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('langauge_name','Language Name', 'trim|required');
			if ($this->form_validation->run() == true)
			{
				if($this->admin_model->update_language($language_id))
				{
					$this->session->set_flashdata('success',"Language updated successfully.");
					redirect(base_url().'cdadmin/languages');
					exit;
				}
				else
				{
					$this->session->set_flashdata('fail',"Language not updated");
					redirect(base_url().'cdadmin/languages');
					exit;
				}
			}
			else
			{
				$data['language']=$this->admin_model->getLanguageByid($language_id);
				
				$admin_id=$this->session->userdata('admin_id');
			
				$data['admin_name']=$this->admin_model->get_admin_detail($admin_id);
				
				$data['page_title'] = 'Edit Language';
				
				$data['parent_li'] = 'Languages';
				
				$data['parent_link'] = 'languages';
				
				$data['snbreadcrum'] = $this->load->view('cdadmin/snbreadcrum', $data , true);
				
				$data['body'] = $this->load->view('cdadmin/language_edit', $data , true);
				
				$this->load->view('cdadmin/template',$data);
			}
			
        
        }
		
	}
	
	public function check_language($id=null)
	{
		
		$lname=$this->input->post('langauge_name');
		$lshname=$this->input->post('langaue_short_name');
		if(!empty($lshname))
		{
			if(!empty($lname))
			{
				$IsLanguage=$this->admin_model->check_language_exist($id,$lname,$lshname);
			}
			else
			{
				$IsLanguage=$this->admin_model->check_language_exist($id,null,$lshname);
			}
			
		}
		else
		{
			$IsLanguage=$this->admin_model->check_language_exist($id,$lname);
		}		
		
		
		if($IsLanguage == "TRUE")
		{
			echo json_encode(false);
		}
		else
		{
			echo json_encode(true);
		}
	}
	
	/*
	 * Language Management End Here 
	 */
	
	
}

