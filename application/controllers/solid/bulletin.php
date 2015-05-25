<?php defined('SYSPATH') or die('No direct access allowed.');
class Bulletin_Controller extends Template_Controller
{
	private $bulletin;

	public function __construct()
	{
		parent::__construct();
		comm::validUser();
		$this->bulletin = new Bulletin_Model();
	}
	
	public function listBulletin()
	{
		$this->template->js			= array('solid/bulletin_listbulletin.js');
		$this->template->content	= new View('solid/bulletin/list_view');
	}
	
	public function edit()
	{
		if ($this->uri->segment('edit')>0)
		{
			$id				= $this->uri->segment('edit');
			$data['row']	= $this->bulletin->getOneData("id='$id'");
		}		
		$this->template->content	= new View('solid/bulletin/add_view',$data);		
	}
	
	public function show()
	{
		if ($this->uri->segment('show')>0)
		{
			$id				= $this->uri->segment('show');
			$data['row']	= $this->bulletin->getOneData("id='$id'");
			$data['show']	= true;
		}		
		$this->template->content	= new View('solid/bulletin/show_view',$data);
	}
	
	public function getBulletin()
	{
		$total		= $this->bulletin->getAllCount();
		$page		= $this->input->post('page');
		$size		= $this->input->post('rows');
		$start		= ($page-1)*$size;
		$rs			= $this->bulletin->getData($start,$size);
		$v			= array();
		foreach ($rs as $row)
		{
			$row->ctime	= date('Y-m-d',$row->ctime);
			$row->opt	= '<a href="javascript:void(0);" onclick="return showBulletin('.$row->id.')">查看</a>&nbsp;<a href="javascript:void(0);" onclick="return editBulletin('.$row->id.')">编辑</a>&nbsp;<a href="javascript:void(0);" onclick="return delBulletin('.$row->id.')">删除</a>';
			$v[]	= $row;
		}
		echo json_encode(array('total'=>$total,'rows'=>$v));
		exit;	
	}
	
	public function saveBulletin()
	{
		if ($this->input->post('title'))
		{
			$time		= time();
			$array = array(
				'userName' 		=> $_SESSION['userName'],
				'title' 		=> $this->input->post('title'),
				'content' 		=> $this->input->post('content'),
				'ctime' 		=> $time,
			);
			$return 	= $this->bulletin->save($array);
			if ($return >0)
			{
				echo json_encode(array('msg'=>'已保存公告','success'=>1));
			}
			else
				echo json_encode(array('msg'=>'保存公告失败','success'=>0));
		}
		else
			echo json_encode(array('msg'=>'参数错误','success'=>0));
		exit;		
	}
	
	public function updateBulletin()
	{
		$id		= $this->uri->segment('updateBulletin');
		if ($id>0)
		{
			$upd	= array(
				'title'			=> $this->input->post('title'),
				'content'		=> $this->input->post('content'),
			);
			$return		= $this->bulletin->update($upd,array('id'=>$id));
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
			$return 	= $this->bulletin->delete("id='$id'");
			if ($return >0)
				echo json_encode(array('msg'=>'已删除该公告','success'=>1));
			else
				echo json_encode(array('msg'=>'删除公告失败','success'=>0));				
		}
		else
			echo json_encode(array('msg'=>'参数错误','success'=>0));
		exit;
	}		
	
	public function add()
	{
		$this->template->content	= new View('solid/bulletin/add_view');
	}
}