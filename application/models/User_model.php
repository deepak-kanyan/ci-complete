<?php
class User_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('email');
		$this->load->helper('url');
	}
	
	public function login_user()
	{
		$this->db->select('*');
		$this->db->where('email',$this->input->post('email'));
		$this->db->where('password',md5($this->input->post('password')));
		$query= $this->db->get('users');
		
		if($query->num_rows() > 0 )
		{
			$result = $query->row_array();
			return array('status'=>'success','user_data'=>$result);
			
		}
		else
		{
			return array('status'=>'fail');;
		}
	
	}
	
	public function check_token($user_id,$token)
	{
		$this->db->select('*');
		$this->db->where('user_id', $user_id);
		$this->db->where('token',$token);
		$this->db->from('users');
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			$result=$query->row_array();
			return array('status'=>'success','user_data'=>$result);
			
		}
		else
		{
			return array('status'=>'fail');
		}
	}
	
	public function check_mail_exists()
	{
		$this->db->select('user_id');
		$this->db->where('email',$this->input->post('email'));	
		$query=$this->db->get('users');
		if($query->num_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
		
	}
	public function save_token($user_id,$remember_token)
	{
		$this->db->set('token',$remember_token);
		$this->db->where('user_id',$user_id);
		$this->db->update('users');
		return $this->db->affected_rows();
		
	}
	
	public function signup_user()
	{
		$code=$this->random_number(10);
		$email=$this->input->post('email'); 
		$data=array(
		'email'=>$email,
		'password'=>md5($this->input->post('password')),
		'activation_key'=>$code,
		'create_date'=>date('Y-m-d H:i:s')
		);
		$result = $this->db->insert('users',$data);
		if($result > 0)
		{		
				$config['protocol'] = 'sendmail';
				$config['mailpath'] = '/usr/sbin/sendmail';
				$config['charset'] = 'iso-8859-1';
				$config['mailtype'] = 'html';
				$config['wordwrap'] = TRUE;
					
				$first_name="User";
				$this->email->initialize($config);
				$this->email->from('admin@site.com', 'Admin');
				$this->email->to($email);
				$this->email->subject('Please Confirm Your Email Address For SITENAME');
				$b_code=base64_encode($email.'&'.$code);  
				$url=base_url().'verify/'.$b_code;  
				$message = '<p>Hello '.$first_name.',</p>
					<p>Greetings for the day!! </p>
					<p>Thank You for registering with the SITENAME. For any kind of support you can contact site admin at admin@site.com. Our executve will be happy to assist you.</p>
					<p>Please click here to <a href="'.$url.'">verify email</a>. </p>
					<p></p><br/>
					<p>Regards & Thanks,</p>
					<p>Team SITENAME</p>';
				$this->email->message($message);
				$this->email->send();
			
				return true;
		}
		else
		{
			return false;
		}
		
	}
	public function verify_user($email,$code)
	{
		$this->db->set('status','1');
		$this->db->where('email',$email);
		$this->db->where('activation_key',$code);
		$this->db->update('users');
		return $this->db->affected_rows();
	}
	
	private function random_number($num)
	{
		$alphabet = 'abcdefghijklmnopqrstuvwx#yzABCDEFGH$IJKLMNOPQRST@UVWXYZ1234567890';
		$pass = array();
		$alphaLength = strlen($alphabet) - 1;
		for ($i = 0; $i < $num; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass);
		
	}
	public function forgotPassword()
	{
		$email=$this->input->post('email'); 
		$this->db->select('user_id');
		$this->db->where('email',$email);
		$query = $this->db->get('users');
		if($query->num_rows() > 0)
		{
			
			$code=$this->random_number(10);
			$this->db->set('activation_key',$code);
			$this->db->where('email',$email);
			$result = $this->db->update('users');	
			if($result==1)
			{		
				
					$config['protocol'] = 'sendmail';
					$config['mailpath'] = '/usr/sbin/sendmail';
					$config['charset'] = 'iso-8859-1';
					$config['mailtype'] = 'html';
					$config['wordwrap'] = TRUE;
					
					$first_name="User";
					$this->email->initialize($config);
					$this->email->from('admin@site.com', 'Admin');
					$this->email->to($email);
					$this->email->subject('Password Reset || SITENAME');
					$b_code=base64_encode($email.'&'.$code);  
					$url=base_url().'reset_password/'.$b_code;  
					$message ='<p>Hello User </p>
					<p><a href="'.$url.'">Click here to reset your password</a> or copy and paste the below text into your internet browser address bar:</p>
					<p>'.$url.'</p>
					<p> Please reach out to us on '.$admin_email.' with any of your questions about our service.</p>
					<p>Kind Regards</p>
					<p>	The SITENAME</p>';
				
					$this->email->message($message);
					$this->email->send();
					
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}	
	}
	public function check_old_password($user_id)
	{
		$old_password = $this->input->post('old_password');
		if($old_password)
		{
			$this->db->where('password',md5($old_password));
			$this->db->where('user_id',$user_id);
			$query = $this->db->get('users');
			if($query -> num_rows())
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else{
			return false;
		}
	}
	public function change_password($user_id=null)
	{
		$data = array();
		$this->db->set('password',md5($this->input->post('password')));
		if($user_id !=null)
		{
			$this->db->where('user_id',$user_id);
		}
		$update = $this->db->update('users');
		if($update)
		{
			return true;
		}	
		else{
			return false;
		}
	}
	
	public function reset_password($email,$code)
	{
		$data = array();
		$this->db->set('password',md5($this->input->post('password')));
		$this->db->set('activation_key','');
		
		$this->db->where('email',$email);
		
		$this->db->where('activation_key',$code);
		
		$update = $this->db->update('users');
		$no_updated = $this->db->affected_rows(); 
		if($no_updated)
		{
			return true;
		}	
		else{
			return false;
		}
	}
	
	public function is_user_logged_in()
	{
		if($this->session->userdata('logged_in') == true)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
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
	function updateUser($user_id)
	{
		$data=array(
		'first_name'=>$this->input->post('first_name'),
		'last_name'=>$this->input->post('last_name'),
		'dob'=>$this->input->post('dob'),
		'phone'=>$this->input->post('phone'),
		'address'=>$this->input->post('address'),
		'city'=>$this->input->post('city'),
		'state'=>$this->input->post('state'),
		'country'=>$this->input->post('country'),
		'biography'=>$this->input->post('biography')		
		);
	
		$this->db->where('user_id',$user_id);
		$update = $this->db->update('users',$data);
		
		if($update){
			return true;
		}
		else{
			return false;
		}
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
	
	public function change_profile_image($user_id)
	{		
		if($_FILES['p_image']['name']) 
			{
				$img_name=time().'_'.$_FILES['p_image']['name'];
				$config['upload_path'] = 'uploads/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['overwrite']	= TRUE;
				$config['file_name'] =$img_name;

				$this->load->library('upload', $config);

				if ($this->upload->do_upload('p_image'))
				{
					$img_data = $this->upload->data();	
					$image_name=$img_data['file_name'];
					$this->db->where('user_id',$user_id);
					$this->db->set('profile_image',$image_name);
					$this->db->update('users');
					return $image_name;
				}
				else
				{
					return false;
				}
				
			}
			else
			{
				return false;
			} 
	}
}
?>
