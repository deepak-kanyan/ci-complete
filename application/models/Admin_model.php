<?php
class Admin_model extends CI_Model {
	
	private $from_email;
	private $from_name;
	
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');     
		$this->load->library('email');
		$this->from_email=$this->config->item('admin_email');
		$this->from_name=$this->config->item('admin_name');
	}
	public function login()
	{
		$this->load->library('session');
		$email=$this->input->post('email');
		$password=md5($this->input->post('password'));
		$this->db->select('*');
		$this->db->where('email', $email);
		$this->db->where('password', $password);
		$this->db->from('admin_credentials');
		$query = $this->db->get();
		$result=$query->result();
	
		if ($query->num_rows() > 0)
		{
			$newdata = array(
					'email'  => $result[0]->email,
                    'admin_id'  => $result[0]->id,
                    'admin_logged_in' => TRUE
             );
             $this->session->set_userdata($newdata);
			 return true;
		}
		else
		{
			return false;
		}
	
	}
	
	public function get_user_data($limit,$offset)
	{
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('users.deleted !=',1);
		$this->db->where('users.account_type !=','superadmin');
		if($limit)	
		{
			$this->db->limit($limit,$offset);
		}
		$query = $this->db->get();
		if($query->num_rows())
		{
			$result=$query->result();
		}
		else
		{
			$result=array();
		}
		return $result;
	}
	public function get_admin_detail($admin_id)
	{	
		$data = array();
	    $this->db->select('*');
	     $this->db->from('admin_credentials');
	    $this->db->where('id',$admin_id);
		$query = $this->db->get();
			if($query->num_rows()){
				$data = $query->row_array();
			}
			return $data;
	}
	public function check_password($admin_id)
	{
		$password=$this->input->post('old_pwd');
		$new_pwd=$this->input->post('new_pwd');
		$this->db->select('id');
		$this->db->where(array('password'=>md5($password),'id'=>$admin_id));
		$query=$this->db->get('admin_credentials');
		
		if($query->num_rows()>0)
		{
			  $data = array(
				   'password' => md5($new_pwd)
			   );
			$this->db->where('id', $admin_id);
			$res=$this->db->update('admin_credentials', $data);
			
			if($res)
			{
				return 1;
		    }
		}
		else
		{	
			return 0;
		}
	}
	
	
	/* return all user information, by id also
	 * */
	function get_user_info($offset, $limit, $search = '',$sort_name='',$order,$id='')
	{
		$data = array();
		$this->db->select('*');
		if($search !=''){
			$this->db->like('email',"$search");
			$this->db->or_like("CONCAT(first_name, ' ', last_name)","$search");	
		}
		if($id != '')
		{
			$this->db->where('user_id',$id);
		}
		if($sort_name != '') {
			if($sort_name == 'name') {
				$this->db->order_by("first_name $order , last_name $order");
			} else {
				$this->db->order_by($sort_name,$order);
			}
		}
		else
		{
			$this->db->order_by('user_id','desc');
		}
		$this->db->limit($limit,$offset);
		$query = $this->db->get('users');
		if($query->num_rows() > 0) {
			$data = $query->result();
		}
		//echo $this->db->last_query();
		return $data;
	}
	
	/* 
	 * @param string 
	 * return number of users */
	 
	function users_count($search= '')
	{
		if($search != '') {
			$this->db->like('email',"$search");
			$this->db->or_like("CONCAT(first_name, ' ', last_name)","$search");
		}
		$qry = $this->db->get('users');
		$count = $qry->num_rows();
		return $count;
	}
	/* delete user by id
	 * */
	function delete_user_byId($user_id)
	{
		if($user_id != '')
		{
			$this->db->delete('users',array('user_id' => $user_id));			
			return true;
		}
	}
	
	/* update user info for particular field
	 * */
	function update_user_byId($field,$user_id,$value)
	{
		$data = array($field => $value);
		$this->db->where('user_id', $user_id);
		$this->db->update('users', $data); 
		return true;
	}
	/*get detail of countries
	 * */
	function get_country($id='')
	{
		$this->db->select('*');
		if($id != '')
		{
			$this->db->where('item_id',$id);
		}
		$query = $this->db->get('countries');
		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
	}
	
	/*
	*@param int
	*@return user by id */
	function get_user_byId($id)
	{
		$data = array();
		if($id != '')
		{
			$where = array('user_id' => $id);
			$this->db->where($where);
			$qry =$this->db->get('users');
			if($qry->num_rows() > 0) 	{
				$data = $qry->row_array();
			}
		}
		return $data;
	}
	function update_user_info($user_id)
	{
		if(!empty($_FILES))
			{
				if($_FILES['profile_image']['name'])
				{
					$img_name=time().'_'.$_FILES['profile_image']['name'];
					$config['upload_path'] = 'uploads/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					$config['overwrite'] = TRUE;
					$config['file_name'] =$img_name;
					
					$this->load->library('upload', $config);
					if ($this->upload->do_upload('profile_image'))
					{
						
						$img_data = $this->upload->data();
						$image_name=$img_data['file_name'];
					}
					else
					{
						$image_name="";				
					}
				}
				else{
					$image_name="";
				}
				
			}
		
		$data=array(
		'first_name'=>$this->input->post('first_name'),
		'last_name'=>$this->input->post('last_name'),
		'gender'=>$this->input->post('gender'),
		'dob'=>$this->input->post('dob'),
		'address'=>$this->input->post('address'),
		'biography'=>$this->input->post('biography'),
		'city'=>$this->input->post('city'),
		'state'=>$this->input->post('state'),
		'country'=>$this->input->post('country'),
		'phone'=>$this->input->post('phone'),
		'zipcode'=>$this->input->post('zipcode')		
		);
		
	
		if($image_name)
		{
			$data['profile_image'] = $image_name;
			
		}
		
		$this->db->where('user_id',$user_id);
		$update = $this->db->update('users',$data);
		
		if($update){
			return true;
		}
		else{
			return false;
		}
	}
	
	public function getAllLanguages()
	{
		$this->db->select('*');
		$this->db->from('languages');
		$this->db->where('active',1);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$result=$query->result_array();
			return $result;	
		}
	}
	
	public function getAllAdminLanguages()
	{
		$this->db->select('*');
		$this->db->from('languages');
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$result=$query->result_array();
			return $result;	
		}
	}
	
	public function getLanguages($per_page,$offset)
	{
		$this->db->select('*');
		$this->db->from('languages');
		$this->db->limit($per_page,$offset);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$result=$query->result_array();
			return $result;	
		}
	}
	
	public function getLanguageByid($id)
	{
		$this->db->select('*');
		$this->db->from('languages');
		$this->db->where('id',$id);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$result=$query->row_array();
			return $result;	
		}
	}
	public function update_language($id)
	{
		$this->db->where('id',$id);
		$this->db->set('language',$this->input->post('langauge_name'));
		$res = $this->db->update('languages');
		if($res)
		{
			return 'TRUE';
		}
		else
		{
			return 'FALSE';
		}
	}
	public function check_language_exist($id=null,$name=null,$lshname=null)
	{
		if($name !=null)
		{
			$this->db->where('language',$name); 
		}
		
		if($id !=null)
		{
			$this->db->where('id !=',$id); 
		}	
		if($lshname !=null)
		{
			$this->db->where('sysname',$lshname); 
		}		
		$query = $this->db->get('languages');
		//echo $this->db->last_query();die;
		if ($query->num_rows() > 0)
		{
			return 'TRUE';
		}
		else
		{
			return 'FALSE';
		}
	}
	
	
	
	
	
	public function getAllActiveLanguages()
	{
		$this->db->select('*');
		$this->db->from('languages');
		$this->db->where('active',1);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$result=$query->result_array();
			return $result;	
		}
	}
	public function getLanguagesDetails($lang = 'en')
	{
		$this->db->select('*');
		$this->db->from('languages');
		$this->db->where('active',1);
		$this->db->where('sysname',$lang);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$result=$query->row_array();
			return $result;	
		}
	}
	public function add_new_langauge()
	{
		$language_name = $this->input->post('langauge_name');
		$language_short_name = $this->input->post('langaue_short_name');
		$insert_array = array(
			'language' => $language_name,
			'sysname' => $language_short_name,
			'active' => '1',
		);
		$this->db->insert('languages', $insert_array);
		$res = $this->db->insert_id();
		if($res)
		{
			
			$lang_en = APPPATH.'language/en/admin_lang.php';
			$langfolder = APPPATH.'language/'.$language_short_name;
			$langnew = APPPATH.'language/'.$language_short_name.'/admin_lang.php';
			$tmp_file_name=APPPATH.'language/'.'tmp'.$language_short_name.'.txt';
			if(!is_dir($langfolder))
			{
				mkdir($langfolder);
				chmod($langfolder,0777);
				if(!file_exists($langnew))
				{
					copy($lang_en, $langnew);
					chmod($langnew, 0777);
					$slang=array();
					$source_lang = file_get_contents($lang_en);
					$source_lang = str_replace('$lang','$slang', $source_lang);
					$fso = fopen($tmp_file_name, 'w+');
					fwrite($fso, $source_lang);
					fclose($fso);
					chmod($tmp_file_name, 0777);
					return 'TRUE';
				}
				else
				{
					return 'FALSE';
				}
				
				
			}
			else
			{
				return 'FALSE';
			}
		}
		else
		{
			return 'FALSE';
		}
	}
	public function changeLanguageStatus($id)
	{
		$this->db->select('active');
		$this->db->where('id', $id);
		$this->db->from('languages');
		$query = $this->db->get();
		$res = $query->row_array();	
		//echo $res['status'];die;
		if($res['active'] == 1)
		{
			$status = '0';
		}
		else
		{
			$status = '1';
		}
		$this->db->where('id',$id);
		$this->db->set('active',$status);
		$res = $this->db->update('languages');
		if($res)
		{
			return 'TRUE';
		}
		else
		{
			return 'FALSE';
		}
	}
	
	
}
?>
