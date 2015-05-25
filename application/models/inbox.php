<?php 
	class Inbox_Model extends Model
	{
		public function __construct()
		{
			parent::__construct();
		}	

		public function setTable()
		{
			return 'inbox';
		}
		
		public function getInbox($start,$size)
		{
			$sql	= "select a.id,a.ctime,b.msg,b.realName from {$this->pre}inbox a left join {$this->pre}outbox b on(a.msgId=b.id) where a.receiveId='{$_SESSION['uid']}' order by a.id desc limit $start,$size"; 
			return $this->dbm->dbmquery($sql);
		}
		
		public function getOneInbox($id)
		{
			$sql	= "select a.id,a.ctime,b.msg,b.realName from {$this->pre}inbox a left join {$this->pre}outbox b on(a.msgId=b.id) where a.id='$id'"; 
			return $this->dbm->dbmquery($sql);
		}
		
	}