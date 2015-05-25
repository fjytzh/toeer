<?php 
	class User_Model extends Model
	{
		
		public function __construct()
		{
			parent::__construct();
		}
		
		public function setTable()
		{
			return 'account';
		}
		
		/**
		 * 返回置业顾问列表
		 * @param int $userid 用户ID
		 * @param int $itemsid 项目ID
		 * @author 吴家庚
		 * @return array
		 */
		public function getItemGroupUser($itemsid){
			$sql = "select a.* from ".$this->dbm->getPre()."account a, ".$this->dbm->getPre()."items_user i where a.id = i.userid and i.itemsid = $itemsid and a.groupid=27";
			$rs  = $this->dbm->dbmquery($sql);
			$v   = array();
			foreach ($rs as $row)
			{
				$v[]	= $row;
			}
			return $v;
		}
	}
