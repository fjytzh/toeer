<?php defined('SYSPATH') or die('No direct access allowed.');
class Outbox_Controller extends Template_Controller
{
	private $outbox;

	public function __construct()
	{
		parent::__construct();
		comm::validUser();
		$this->outbox = new Outbox_Model();
	}
	
	public function add()
	{
		$this->template->content	= new View('solid/msg/send_view');
	}
	
	public function listOutbox()
	{
		$this->template->js			= array('solid/msg_outbox.js');
		$this->template->content	= new View('solid/msg/outbox_view');
	}
	
	public function show()
	{
		if ($this->uri->segment('show')>0)
		{
			$id				= $this->uri->segment('show');
			$row			= $this->outbox->getOneData("id='$id'");
			$row->ctime		= date('Y-m-d H:i:s',$row->ctime);
			$row->users		= $this->outbox->getUsers($row->id);
			$data['rs']		= $row;
		}		
		$this->template->content	= new View('solid/msg/outbox_show_view',$data);			
	}
	
	public function save()
	{
		if ($this->input->post('users') && $this->input->post('content'))
		{
			$uids		= array_map('intval',$this->input->post('users'));
			$users		= $this->outbox->getRealNames($uids);
			if (!is_array($users) || (count($users) != count($uids)))
			{
				echo json_encode(array('msg'=>'发送对参有误','success'=>0));
				exit;
			}
			$time		= time();
			$insert		= array(
				'uid'		=> $_SESSION['uid'],
				'realName'	=> $_SESSION['realName'],
				'msg'		=> $this->input->post('content'),
				'ctime'		=> $time,
			);
			$msgId		= $this->outbox->save($insert);
			$inbox		= new Inbox_Model;
			
			foreach ($uids as $v)
			{
				$insert2	= array(
					'receiveId'		=> $v,
					'msgId'			=> $msgId,
					'realName'		=> $users[$v],
					'ctime'			=> $time
				);
				$this->outbox->intoInbox($insert2);
			}
			echo json_encode(array('msg'=>'信息已发送','success'=>1));
		}
		else
			echo json_encode(array('msg'=>'参数错误','success'=>0));
		exit;
	}
	
	public function getOutbox()
	{	
		$total		= $this->outbox->getAllCount("uid='{$_SESSION['uid']}'");
		$page		= $this->input->post('page');
		$size		= $this->input->post('rows');
		$start		= ($page-1)*$size;
		$rs			= $this->outbox->getOutbox($start,$size);
		$v			= array();
		foreach ($rs as $row)
		{
			$row->ctime	= date('Y-m-d H:i:s',$row->ctime);
			$row->users	= $this->outbox->getUsers($row->id);
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
			$return 	= $this->outbox->delete(array('id'=>$id));
			if ($return >0)
				echo json_encode(array('msg'=>'已删除该消息','success'=>1));
			else
				echo json_encode(array('msg'=>'删除消息失败','success'=>0));				
		}
		else
			echo json_encode(array('msg'=>'参数错误','success'=>0));
		exit;		
	}
	
	public function echoUsers()
	{
		$user		= new Account_Model;
		$rs			= $user->getData(0,100,'id,realName');
		echo json_encode($rs);
		exit;
	}

}