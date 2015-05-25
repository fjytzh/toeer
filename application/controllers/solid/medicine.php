<?php defined('SYSPATH') OR die('No direct access allowed.');
	class Medicine_Controller extends Template_Controller 
	{
		private $medicine;
		public function __construct()
		{
			parent::__construct();
			comm::validUser();
			$this->medicine		= new Medicine_Model;	
		}
		
		public function add()
		{
			$this->template->content	= new View('solid/medicine/add_view');
		}
		
		public function listMedicine()
		{
			$this->template->content	= new View('solid/medicine/list_view');
		}		
		
		public function edit()
		{
			if ($this->uri->segment('edit')>0)
			{
				$data['row']	= $this->medicine->getOneMedicine($this->uri->segment('edit'));
			}
			$this->template->content = new View('solid/medicine/add_view',$data);				
		}
		
			
		public function getStore()
		{
			$total		= $this->medicine->getAllCount();
			$page		= $this->input->post('page');
			$size		= $this->input->post('rows');
			$start		= ($page-1)*$size;
			$str		= urldecode($this->input->get('str'));
			$rs			= $this->medicine->getStoreValue($start,$size,$str);
			$v			= array();
			foreach ($rs as $row)
			{
				$row->opt		= '<a href="#" onclick="return addStore('.$row->id.')">修改库存</a></a>';
				$v[]			= $row;
			}
			echo json_encode(array('total'=>$total,'rows'=>$v));
			exit;			
			
		}		
		
		/**
		 * 更新用户
		 * Enter description here ...
		 */
		public function update()
		{
			$id		= $this->input->post('hid');
			$name	= $this->input->post('name');
			$pinyin	= $this->input->post('pinyin');					
			if ($id>0 && $name && $pinyin)
			{
				$time		= time();
				$array		= array(
					'name'		=> $name,
					'pinyin'	=> $pinyin,
					'spec'		=> $this->input->post('spec'),
					'utime'		=> $time
				);
				$return 	= $this->medicine->update($array,$id);
				if ($return)
					echo json_encode(array('msg'=>'已更新该药品','success'=>1));
				else
					echo json_encode(array('msg'=>'更新药品失败','success'=>0));				
			}
			else
				echo json_encode(array('msg'=>'参数错误','success'=>0));
			exit;
		}
		
		public function getMedicine()
		{
			$str		= urldecode($this->input->get('str'));
			$total		= $this->medicine->getAllCount($str);
			$genres		= array();
			$page		= $this->input->post('page');
			$size		= $this->input->post('rows');
			$start		= ($page-1)*$size;
			$rs			= $this->medicine->getMedicine($start,$size,$str);
			$v			= array();
			foreach ($rs as $row)
			{
				$row->ctime		= date('Y-m-d',$row->ctime);
				$row->utime		= date('Y-m-d',$row->utime);
				$row->opt	= '<a href="#" onclick="return edit('.$row->id.');">编辑</a>&nbsp;<a href="#" onclick="return del('.$row->id.');">删除</a><input type="hidden" id="n'.$row->id.'" value="'.$row->name.'" /><input type="hidden" id="s'.$row->id.'" value="'.$row->spec.'" /><input type="hidden" id="p'.$row->id.'" value="'.$row->pinyin.'" />';
				$v[]	= $row;
			}
			echo json_encode(array('total'=>$total,'rows'=>$v));
			exit;
		}

		public function pinyin()
		{
			$values		= explode(' ',$this->input->post('pinyin'));
			$value		= $values[0];
			if ($value)
			{
				$return		= comm::getPinyin($value);
				$len		= mb_strlen($value);
				$len2		= strlen($return);
				if ($len != $len2)
					$equal		= false;
				else
					$equal		= true;
				echo json_encode(array('msg'=>$return,'success'=>1,'equal'=>$equal));			
			}
			else 
				echo json_encode(array('success'=>0));

			exit;
		}
		
		public function del()
		{
			$id		= $this->input->post('id');
			if ($id>0)
			{
				$return 	= $this->medicine->del($id);
				if ($return >0)
					echo json_encode(array('msg'=>'已删除该药品','success'=>1));
				else
					echo json_encode(array('msg'=>'删除药品失败','success'=>0));				
			}
			else
				echo json_encode(array('msg'=>'参数错误','success'=>0));
			exit;
		}			
		
		public function save()
		{
			$name	= $this->input->post('name');
			$pinyin	= $this->input->post('pinyin');
			if ($name && $pinyin)
			{
				$count		= $this->medicine->getMedicineCount($name);
				if ($count>0)
				{
					echo json_encode(array('msg'=>'保存失败，同名同规格的药品已存在','success'=>0));
				}
				else
				{				
					$time		= time();
					$array		= array(
						'name'		=> $name,
						'pinyin'	=> $pinyin,
						'spec'		=> $this->input->post('spec'),
						'ctime'		=> $time,
						'utime'		=> $time
					);
					$return 	= $this->medicine->save($array);
					if ($return >0)
						echo json_encode(array('msg'=>'药品保存成功','success'=>1));
					else
						echo json_encode(array('msg'=>'药品保存失败','success'=>0));				
				}		
			}
			else
				echo json_encode(array('msg'=>'参数错误','success'=>0));
			exit;
			
		}
	}