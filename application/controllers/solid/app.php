<?php defined('SYSPATH') or die('No direct access allowed.');
class App_Controller extends Template_Controller
{
	private $app;

	public function __construct()
	{
		parent::__construct();
		comm::validUser();
		$this->app = new App_Model();
	}
	
	public function listApp()
	{
		$this->template->js			= array('solid/app_listapp.js');
		$this->template->content	= new View('solid/app/list_view');
	}
	
	public function add()
	{
		$this->template->content	= new View('solid/app/add_view');
	}
	
	/**
	 * 编辑项目
	 */
	public function edit()
	{
		if ($this->uri->segment('edit')>0)
		{
			$id				= $this->uri->segment('edit');
			$data['row']	= $this->app->getOneData("id='$id'");
		}
		$this->template->content = new View('solid/app/add_view',$data);
	}
	
	public function updateApp()
	{
		$id		= $this->uri->segment('updateApp');
		if ($id>0)
		{
			$upd	= array(
				'name'			=> $this->input->post('name'),
				'path'			=> $this->input->post('path'),
			);
			$return		= $this->app->update($upd,array('id'=>$id));
			if ($return)
				echo json_encode(array('msg'=>'已更新项目','success'=>1));
			else
				echo json_encode(array('msg'=>'更新项目失败','success'=>0));				
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
			$return 	= $this->app->delete(array('id'=>$id));
			if ($return >0)
				echo json_encode(array('msg'=>'已删除项目','success'=>1));
			else
				echo json_encode(array('msg'=>'删除项目失败','success'=>0));				
		}
		else
			echo json_encode(array('msg'=>'参数错误','success'=>0));
		exit;
	}
	
	public function getApp()
	{
		$total		= $this->app->getAllCount();
		$page		= $this->input->post('page');
		$size		= $this->input->post('rows');
		$start		= ($page-1)*$size;
		$rs			= $this->app->getData($start,$size);
		$v			= array();
		foreach ($rs as $row)
		{
			$row->ctime	= date('Y-m-d',$row->ctime);
			$v[]	= $row;
		}
		echo json_encode(array('total'=>$total,'rows'=>$v));
		exit;			
	}	
	
	/**
	 * 取得组数据，用于app.php
	 * Enter description here ...
	 */
	public function getAllApp()
	{
		$rs		= $this->app->getData(0,100);
		echo json_encode($rs);
		exit;
	}	
	
	public function saveApp()
	{
		if ($this->input->post('name'))
		{
			$time		= time();
			$array = array(
				'name' 		=> $this->input->post('name'),
				'path' 		=> $this->input->post('path'),
				'ctime' 	=> $time,
			);
			$return 	= $this->app->save($array);
			if ($return >0)
			{
				echo json_encode(array('msg'=>'已保存项目','success'=>1));
			}
			else
				echo json_encode(array('msg'=>'保存项目失败','success'=>0));
		}
		else
			echo json_encode(array('msg'=>'参数错误','success'=>0));
		exit;			
	}	
}
