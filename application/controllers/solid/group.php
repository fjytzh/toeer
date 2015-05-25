<?php defined('SYSPATH') OR die('No direct access allowed.');
	class Group_Controller extends Template_Controller 
	{
		private $group;
		public function __construct()
		{
			parent::__construct();
			comm::validUser();
			$this->group	= new Group_Model;	
		}
		
		/**
		 * 用户组列表
		 * Enter description here ...
		 */
		public function setGroup()
		{
			$this->template->js		= array('solid/group_setgroup.js');
			$this->template->content = new View('solid/group/group_view');
		}
		
		/**
		 * 取得用户组json
		 * Enter description here ...
		 */
		public function getGroup()
		{
			$total		= $this->group->getAllCount()-1;//扣除管理员用户组
			$page		= $this->input->post('page');
			$size		= $this->input->post('rows');
			$start		= ($page-1)*$size;
			$rs			= $this->group->getData($start,$size,'',array('id>'=>1));	
			$v			= array();
			foreach ($rs as $row)
			{
				$row->ctime	= date('Y-m-d',$row->ctime);
				$row->utime	= date('Y-m-d',$row->utime);
				if ($row->id ==1)
				{
					$row->modPower	= '全部';
				}
				$v[]	= $row;
			}
			echo json_encode(array('total'=>$total,'rows'=>$v));
			exit;
		}
		
		/**
		 * 取得组数据，用于user.php
		 * Enter description here ...
		 */
		public function getGroup2()
		{
			$rs		= $this->group->getData(0,100,'id,groupName',array('id>'=>1));
			echo json_encode($rs);
			exit;
		}
		
		/**
		 * 添加用户组
		 * Enter description here ...
		 */
		public function add()
		{
			$this->template->content = new View('solid/group/add_view');
		}
		
		/**
		 * 保存用户组
		 * Enter description here ...
		 */
		public function save()
		{
			if ($this->input->post('groupName') && $this->input->post('modPower'))
			{
				$time		= time();
				$count		= $this->group->getAllCount("groupName='{$this->input->post('groupName')}'");
				if ($count>0)
				{
					echo json_encode( array('msg' => '该用户组已存在','success' => 1));
					exit;
				}	
				if ($this->input->post('modPrePower'))	
				{
					$prePowers		= explode(',',$this->input->post('modPrePower'));	
					$prePowers		= array_unique($prePowers);
					$modPrePower	= implode(',',$prePowers);
				}
				else
					$modPrePower	= '';
						
				$array = array(
					'groupName' 	=> $this->input->post('groupName'),
					'modPower' 		=> $this->input->post('modPower'),
					'modPrePower' 	=> $modPrePower,
					'ctime' 		=> $time,
					'utime' 		=> $time
				);
				$return 	= $this->group->save($array);
				if ($return >0)
				{
					echo json_encode(array('msg'=>'已保存用户组','success'=>1));
				}
				else
					echo json_encode(array('msg'=>'保存用户组失败','success'=>0));
			}
			else
				echo json_encode(array('msg'=>'参数错误','success'=>0));
			exit;
		}
		
		/**
		 * 编辑 用户组
		 */
		public function edit()
		{
			if ($this->uri->segment('edit')>0)
			{
				$id 	= $this->uri->segment('edit');
				if ($id ==1)//强制编辑管理员，直接退出 
				{
					exit;
				}				
				$data['row']	= $this->group->getOneData("id='$id'");
			}
			$this->template->content = new View('solid/group/add_view',$data);
		}
		
		/**
		 * 更新用户组
		 * Enter description here ...
		 */
		public function update()
		{
			$id		= $this->uri->segment('update');
			if ($id>0)
			{
				if ($id==1)//强制更新管理员，直接退出 
				{
					exit;
				}
				$time		= time();
				$modPower	= explode(',',$this->input->post('modPower'));
				if ($this->input->post('modPrePower'))	
				{
					$prePowers	= explode(',',$this->input->post('modPrePower'));	
					$prePowers	= array_unique($prePowers);
					$modPrePower	= implode(',',$prePowers);
					if ($modPrePower)
					{
						$result = array_diff($modPower,$prePowers);	//解决treegrid父级节点选中后全部选中问题		
					}					
				}
				else
				{
					$modPrePower	= '';	
					$result			= $modPower;
				}
				$upd	= array(
					'groupName'		=> $this->input->post('groupName'),
					'modPower'		=> implode(',',$result),
					'modPrePower'	=> $modPrePower,
					'utime'			=> $time
				);
				$return		= $this->group->update($upd,array('id'=>$id));
				if ($return)
				{
					echo json_encode(array('msg'=>'已更新用户组','success'=>1));
				}
				else
				{
					echo json_encode(array('msg'=>'更新用户组失败','success'=>0));	
				}			
			}
			else
			{
				echo json_encode(array('msg'=>'参数错误','success'=>0));
			}
			exit;
		}
		
		public function del()
		{
			$id		= $this->input->post('id');
			if ($id>0)
			{
				if ($id ==1)//强制删除管理员，直接退出
				{
					exit;
				}
				else 
				{
					$return 	= $this->group->del($id);
					if ($return >0)
					{
						echo json_encode(array('msg'=>'已删除用户组','success'=>1));
					}
					else
					{
						echo json_encode(array('msg'=>'删除用户组失败','success'=>0));
					}						
				}
			}
			else
				echo json_encode(array('msg'=>'参数错误','success'=>0));
			exit;
		}
	}
?>