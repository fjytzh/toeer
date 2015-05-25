<?php defined('SYSPATH') or die('No direct access allowed.');
class Inbox_Controller extends Template_Controller
{
	private $inbox;

	public function __construct()
	{
		parent::__construct();
		comm::validUser();
		$this->inbox = new Inbox_Model();
	}
	
	public function listInbox()
	{
		$this->template->js			= array('solid/msg_inbox.js');
		$this->template->content	= new View('solid/msg/inbox_view');
	}
	
	public function show()
	{
		if ($this->uri->segment('show')>0)
		{
			$id				= $this->uri->segment('show');
			$data['rs']		= $this->inbox->getOneInbox($id);
		}		
		$this->template->content	= new View('solid/msg/add_view',$data);	
	}
	
	public function getInbox()
	{
		$total		= $this->inbox->getAllCount("receiveId='{$_SESSION['uid']}'");
		$page		= $this->input->post('page');
		$size		= $this->input->post('rows');
		$start		= ($page-1)*$size;
		$rs			= $this->inbox->getInbox($start,$size);
		$v			= array();
		foreach ($rs as $row)
		{
			$row->ctime	= date('Y-m-d H:i:s',$row->ctime);
			$v[]	= $row;
		}
		echo json_encode(array('total'=>$total,'rows'=>$v));
		exit;		
	}
	
	public function del()
	{
		$id		= $this->input->post('id');
		if ($id>0)
		{
			$return 	= $this->inbox->delete("id='$id'");
			if ($return >0)
				echo json_encode(array('msg'=>'已删除该消息','success'=>1));
			else
				echo json_encode(array('msg'=>'删除消息失败','success'=>0));				
		}
		else
			echo json_encode(array('msg'=>'参数错误','success'=>0));
		exit;		
	}
}