<?php 
	class Login_Model extends Model
	{
		public $dbm;
		public function __construct()
		{
			$this->dbm = new Dbm_Model;
		}
		
		public function setTable()
		{
		}

		public function checkUser($userName,$passwd)
		{
			$passwd		= md5(Kohana::config('config.md5key').$passwd);
			return $this->dbm->getRow('account','id,gid,realName',"userName='$userName' and passwd='$passwd'");
		}
	
	}

?>
