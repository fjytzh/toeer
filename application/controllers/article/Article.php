<?php defined('SYSPATH') OR die('No direct access allowed.');
	class Article_Controller extends Template_Controller 
	{
		private $_model;
		public function __construct()
		{
			parent::__construct();
			comm::validUser();
			$this->_model	= new Article_Model;	
		}
		
		public function add()
		{
			$this->template->content	= new View('article/article/add_view');
		}	
			
		public function listForm()
		{
			$this->template->js			= array('article/article/list.js');
			$this->template->content	= new View('article/article/list_view');
		}
		
		/**
		 * 获取所有用户
		 * Enter description here ...
		 */
		public function getListJson()
		{
			$total		= $this->_model->getAllCount();
			$page		= $this->input->post('page');
			$size		= $this->input->post('rows');
			$start		= ($page-1)*$size;
			$rs			= $this->_model->getData($start,$size,'article_id,title,fname,create_time,create_user_id');
			
			$v			= array();
			foreach ($rs as $row)
			{
				$v[]	= $row;
			}
			echo json_encode(array('total'=>$total,'rows'=>$v));
			exit;
		}		
		
		public function edit()
		{
			if ($this->uri->segment('edit')>0)
			{
				$id		= $this->uri->segment('edit');
				$data['row']	= $this->_model->getOneData("id='$id'");
			}
			$this->template->content = new View('article/article/add_view',$data);			
		}
		
		/**
		 * 更新用户
		 * Enter description here ...
		 */
		public function update()
		{
			$id		= $this->uri->segment('update');
			if ($id>0)
			{
				if ($id ==1)//如果更新管理员，直接输出错误
				{
					echo json_encode(array('msg'=>'admin用户不能被修改','success'=>0));
					exit;
				}
				
				$upd	= array(
					'gid'		=> $this->input->post('gid'),
					'realName'	=> $this->input->post('realName')
				);
				$return		= $this->_model->update($upd,array('id'=>$id));
				if ($return)
					echo json_encode(array('msg'=>'已更新用户组','success'=>1));
				else
					echo json_encode(array('msg'=>'更新用户组失败','success'=>0));				
			}
			else
				echo json_encode(array('msg'=>'参数错误','success'=>0));
			exit;
		}	
		
		public function del()
		{
			$id		= $this->input->post('id');
			if ($id>0)
			{
				if ($id ==1)//如果删除管理员，直接输出错误
				{
					echo json_encode(array('msg'=>'admin用户不能被删除','success'=>0));
					exit;
				}				
				
				$return 	= $this->_model->delete("id='$id'");
				if ($return >0)
					echo json_encode(array('msg'=>'已删除该用户','success'=>1));
				else
					echo json_encode(array('msg'=>'删除用户失败','success'=>0));				
			}
			else
				echo json_encode(array('msg'=>'参数错误','success'=>0));
			exit;
		}		

		/**
		 * 保存用户
		 * Enter description here ...
		 */
		public function save()
		{
			$userName	= $this->input->post('userName');
			$passwd		= md5( Kohana::config('config.md5key').$this->input->post('newPasswd'));
			$gid		= $this->input->post('gid');
			$realName	= $this->input->post('realName');
			if ($userName && $passwd && $gid)
			{
				$count		= $this->_model->getAllCount("userName='$userName'");
				if ($count>0)
				{
					echo json_encode(array('msg'=>'保存失败，该帐号已存在','success'=>0));
					exit;
				}
				else
				{
					$time		= time();
					$array		= array(
						'userName'	=> $userName,
						'passwd'	=> $passwd,
						'gid'		=> $gid,
						'realName'	=> $realName,
						'ctime'		=> $time
					);
					$return 	= $this->_model->save($array);
					if ($return >0)
						echo json_encode(array('msg'=>'已保存该用户','success'=>1));
					else
						echo json_encode(array('msg'=>'保存用户失败','success'=>0));				
				}
			}
			else
				echo json_encode(array('msg'=>'参数错误','success'=>0));
			exit;
		}
	}
