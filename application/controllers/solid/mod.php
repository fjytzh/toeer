<?php defined('SYSPATH') OR die('No direct access allowed.');
	class Mod_Controller extends Template_Controller 
	{
		private $mod;
		public function __construct()
		{
			parent::__construct();
			comm::validUser();
			$this->mod	= new Mod_Model;	
		}
		
		public function index()
		{
			
		}
		
		/**
		 * 
		 *添加模块
		 */
		public function add()
		{
			$this->template->content = new View('solid/mod/add_view');
		}
		
		/**
		 * 展示模块
		 */
		public function listMod()
		{	
			$this->template->js			= array('solid/mod_listmod.js');
			$this->template->content	= new View('solid/mod/list_view');
		}	
		
		/**
		 * 删除模块
		 */
		public function delMod()
		{
			$id		= $this->input->post("nid");
			if ( $id < 195 )
			{
				echo json_encode( array( "msg" => "无法删除核心模块", "success" => 0 ) );
				exit;
			}			
			$count	= $this->mod->getAllCount("bid='$id'");
			if ($count >0)
			{
				echo json_encode(array('msg'=>'该模块为父级模块不能直接删除','success'=>0));
			}
			else 
			{
				$return		= $this->mod->delete("id='$id'");
				if ($return)
				{
					echo json_encode(array('msg'=>'模块已删除','success'=>1));
				}
				else 
					echo json_encode(array('msg'=>'无法删除模块','success'=>0));
			}
			exit;
		}
		
		/**
		 * 取得所有二级以上模块，用于添加模块列表
		 */
		public function getPreMod()
		{
			$rs		= $this->mod->getMod();
			$mods	= array();
			foreach ($rs as $row)
			{
				$rs2	= $this->mod->getMod($row->id);
				$array2	= array();
				foreach ($rs2 as $row2)
				{
					if ($row2->leaf >0 || $row2->url=='')
					{
						
						$array2[]	= array('id'=>$row2->id,'attributes'=>array('bid'=>$row->id),'text'=>$row2->modName);
					}
					else//如果没有下级则不记录
					{
						continue;
					}
				}
				$array[]		= array('id'=>$row->id,'attributes'=>array('bid'=>0),'text'=>$row->modName,'children'=>$array2);
			}
			echo json_encode($array);
			exit;
		}

		/**
		 * 取得所有模块
		 *
		 */
		public function getParentMod()
		{
			$rs		= $this->mod->getMod();
			if ($this->uri->segment(4)>0)
			{
				$group	= new Group_Model;
				$mods	= $group->getModPower($this->uri->segment(4));
			}
			else
				$mods	= '';
			$ids	= array();
			if ($mods)
			{
				$ids	= explode(',',$mods);
			}
			$array	= array();
			foreach ($rs as $row)
			{
				$rs2	= $this->mod->getMod($row->id);
				$array2	= array();
				foreach ($rs2 as $row2)
				{
					if ($_SESSION['gid']>1 && $row2->id==5)//只有管理员才能进行模块管理分配
					{
						continue;
					}
					$array3		= array();
					if ($row2->leaf >0)//如果还有下一级
					{
						$rs3		= $this->mod->getMod($row2->id);
						foreach ($rs3 as $row3)
						{
							$str		= $this->getChecked($row3->id, $ids);
							$array3[]	= array('id'=>$row3->id,'attributes'=>array('bid'=>$row2->id.','.$row->id),'text'=>$row3->modName,'checked'=>$str);//bid多一个逗号，解决顶级模块可能数据无法记录
						}
					}
					$str		= $this->getChecked($row2->id, $ids);
					$array2[]	= array('id'=>$row2->id,'attributes'=>array('bid'=>$row->id),'text'=>$row2->modName,'children'=>$array3,'checked'=>$str);
				}
				$str		= $this->getChecked($row->id, $ids);
				$array[]		= array('id'=>$row->id,'attributes'=>array('bid'=>0),'text'=>$row->modName,'children'=>$array2,'checked'=>$str);
			}
			echo json_encode($array);
			exit;
		}				

		/**
		 * 取得模块Treegrid
		 *
		 */
		public function getModTree()
		{
			$rs		= $this->mod->getData();
			$total	= $this->mod->getAllCount();
			$mods	= array();
			foreach ($rs as $row)
			{
				if ($row->bid == 0)
					$mods[]	= array('id'=>$row->id,'text'=>$row->modName);
				else
					$mods[]	= array('id'=>$row->id,'text'=>$row->modName,'_parentId'=>$row->bid,'checked'=>'');
			}
			echo json_encode(array('total'=>$total,'rows'=>$mods));
			exit;
		}	
		
		private function getChecked($id,$ids)
		{
			if (in_array($id,$ids))
				return true;
			else
				return false;
		}

		/**
		 * 
		 * 保存模块
		 */
		public function saveMod()
		{
			if ($this->input->post('modName'))
			{
				if ($this->input->post('class') && $this->input->post('function'))
					$url	= $this->input->post('class').'/'.$this->input->post('function');
				else
					$url	= '';
				$data		= array(
					'url'		=> $url,
					'modName'	=> $this->input->post('modName'),
					'bid'		=> $this->input->post('cvalue'),
					'visible'	=> $this->input->post('visible'),
					'app'		=> $this->input->post('app')
				);
				$return		= $this->mod->saveValue($data,$this->input->post('cvalue'));
				if ($return)
				{
					if ($_SESSION['gid'] ==1)//如果是管理员，新生成所有权限
					{
						$mod			= new Mod_Model;
						$powers			= $mod->getAllId();
						$_SESSION['powers'] = $powers;	
					}
					echo json_encode(array('success'=>1,'msg'=>'模块已保存'));
				}
				else
					echo json_encode(array('success'=>0,'msg'=>'模块保存失败'));
			}
			else 
				echo json_encode(array('success'=>0,'msg'=>'参数错误'));
			exit;
		}
		
		/**
		 * 更新模块
		 * Enter description here ...
		 */
		public function edit()
		{
			$id				= $this->uri->segment('edit');
			$data['row']	= $this->mod->getOneData("id='$id'");
			$this->template->content = new View('solid/mod/add_view',$data);
		}
		
		/**
		 * 保存更新的模块
		 * Enter description here ...
		 */
		public function updateMod()
		{
			$updid		= $this->uri->segment('updateMod');
			if ($this->input->post('class') && $this->input->post('function'))
				$url	= $this->input->post('class').'/'.$this->input->post('function');
			else
				$url	= '';			
			$upd		= array(
				'modName'	=> $this->input->post('modName'),
				'url'		=> $url,
				'bid'		=> $this->input->post('cvalue'),
				'visible'	=> $this->input->post('visible'),
				'app'		=> $this->input->post('app')
			);
			$return		= $this->mod->updateValue($upd,"id='$updid'");
			if ($return)
			{
				echo json_encode(array('success'=>1,'msg'=>'模块已更新'));
			}
			else
				echo json_encode(array('success'=>0,'msg'=>'模块更新失败'));	
			exit;		
		}
	}