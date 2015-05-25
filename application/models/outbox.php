<?php 
	class Outbox_Model extends Model
	{
		public function __construct()
		{
			parent::__construct();
		}	

		public function setTable()
		{
			return 'outbox';
		}
		
		public function getOutbox($start,$size)
		{
			$rs		= $this->getData($start,$size,'*',array('uid'=>$_SESSION['uid'])," id   asc,uid   desc");
			return $rs;
		}
		
		public function getUsers($id)
		{
			$users	= array();
			$rs	= $this->dbm->dbmquery("select realName from {$this->pre}inbox where msgId='{$id}'");
			foreach ($rs as $row)
			{
				$users[]	= $row->realName;
			}	
			return implode(',',$users);		
		}
		
		public function intoInbox($post)
		{
			$this->dbm->insertData('inbox',$post);
		}
		
		public function getRealNames($ids)
		{
			$users	= array();
			$user	= new Account_Model;
			if ($ids[0]>0)
			{
				$ids	= implode(',',$ids);
				$rs		= $this->dbm->dbmquery("select id,realName from {$this->pre}account where id in($ids)");
				foreach ($rs as $row)
				{
					if ($row->realName !='')
						$users[$row->id]	= $row->realName;
				}
				return $users;
			}
		}

		
	}