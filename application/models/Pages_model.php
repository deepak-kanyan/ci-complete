<?php
class Pages_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');     
	}
	
	public function getAllPages($page_id='',$limit=0, $offset=0)
	{
		$this->db->select('*');
		if($page_id)
		{
			$this->db->where('page_id',$page_id);	
		}
		if($limit != 0)
		{
			$this->db->limit($limit, $offset);
		}
		$this->db->from('page as pg');			
		$this->db->join('page_content as pc','pc.page_id = pg.page_id');			
	//	$this->db->join('languages as ln','ln.id = pc.language_id');			
		$this->db->group_by('pc.page_id'); 
		$data = $this->db->get();
		
		//echo $this->db->last_query();die;
		if($data->num_rows() > 0)
		{
			if($page_id)
			{
				$res = $data->row_array();
				return $res;
			}
			else
			{
				$res = $data->result_array();
				return $res;
			}
		}
		else
		{
			$res = '';
			return $res;
		}
		
	}

	
	public function getAllLanguagePagesContent($page_id)
	{
		$data = array();
		$this->db->select('*');
		$this->db->where('pg.page_id',$page_id);	
		
		$this->db->from('page as pg');			
		$this->db->join('page_content as pc','pc.page_id = pg.page_id');			
		//$this->db->join('page_content as pc','pc.page_id = pg.id');			
		
		$query = $this->db->get();
		//echo '<pre>'; print_r($query->row_array()); die;
		//echo $this->db->last_query();die;
		if($query->num_rows() > 0)
		{			
			$data = $query->row_array();				 			
		}
		return $data;
	}
	
	public function update_static_content($page_id)
	{	
			//echo '<pre>';print_r($_FILES);die;
		if(!empty($_FILES)){
			if($_FILES['title_image']['name'])
			{
				$img_name=time().'_'.$_FILES['title_image']['name'];
				$config['upload_path'] = 'uploads/pages';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['overwrite'] = TRUE;
				$config['file_name'] =$img_name;

				$this->load->library('upload', $config);

				if ($this->upload->do_upload('title_image'))
				{
					$img_data = $this->upload->data();
					$image_name=$img_data['file_name'];
				}
				else
				{
					$image_name="";
								
				}

			}
			
		}
		else
		{
			$image_name="";
							
		}
		
		
		$this->db->where('page_id',$page_id);
		if(isset($image_name))
		{		
			$this->db->set('image',$image_name);	
			$this->db->update('page');		
		}
					
		$insert_array = array();
		foreach($_POST as $key => $val)
		{			
			$column_explode = explode('_', $key);
			$language_id = $column_explode[1];
			$insert_array[$language_id]['page_'.$column_explode[0]] = $val;
			
			/*if(strstr($key,'content_'))
			{
				$lan=explode('_',$key);
				$lan_id=$lan[1];				
			}
			if(strstr($key,'title_'))
			{
				$lan=explode('_',$key);
				$lan_id=$lan[1];				
			}
				
				$this->db->select('id');
				$this->db->where('page_id',$page_id);
				$this->db->where('language_id',$lan_id);
				$query =  $this->db->get('page_content');			
				
				if($query->num_rows() > 0)
				{
					$data = array(				
					'page_content'=>$val
					);
					$this->db->where('page_id',$page_id);
					$this->db->where('language_id',$lan_id);
					$this->db->update('page_content',$data);					
				}
				else
				{
					$data = array(				
					'page_id'=>$page_id,
					'language_id'=>$lan_id,
					'page_content'=>$val
					);					
					$this->db->insert('page_content',$data);								
				}*/			
		}
		foreach($insert_array as $language_id => $ins_array)
		{
			$this->db->select('id');
			$this->db->where('page_id',$page_id);
			//$this->db->where('language_id',$language_id);
			$query =  $this->db->get('page_content');	
			if($query->num_rows() > 0)
			{
				$this->db->where('page_id',$page_id);
				//$this->db->where('language_id',$language_id);
				$this->db->update('page_content',$ins_array);	
			}
			else
			{
				//$ins_array['language_id'] = $language_id;
				$ins_array['page_id'] = $page_id;
				$this->db->insert('page_content', $ins_array);	
			}
		}
		//echo '<pre>';print_r($insert_array); die;
		return 1;
	} 	
}
