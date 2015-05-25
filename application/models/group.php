<?php 
	class Group_Model extends Model
	{
		public $dbm;
		
		public function __construct()
		{
			parent::__construct();
			$this->dbm		= new Dbm_Model;
		}
		
		public function setTable()
		{
			return 'group';
		}
			
		public function getModPower($gid)
		{
			return $this->dbm->getOne('group','modPower',"id='$gid'");
		}
	
		public function getCheckPower($gid)
		{
			return $this->dbm->getRow('group','modPower,modPrePower', "id='$gid'");
		}		
		
		public function del($id)
		{
			$return	= $this->dbm->deleteData('group',"id='$id'");
			$this->dbm->updateData('account',array('gid'=>0),array('gid'=>$id));//将属于该用户组的组类别置0
			return $return;
		}
	}
?>