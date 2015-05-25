<?php 
	class Account_Model extends Model
	{
		
		public function __construct()
		{
			parent::__construct();
		}
		
		public function setTable()
		{
			return 'account';
		}
		
		public function checkOldPasswd($passwd)
		{
			if ($passwd)
			{
				$passwd		= md5(Kohana::config('config.md5key').$passwd);
				return $this->dbm->getOne('account','id',"userName='{$_SESSION['userName']}' and passwd='$passwd'");
			}
		}	
			
		public function updateNewPasswd($passwd,$id)
		{
			$updPwd = md5(Kohana::config('config.md5key').$passwd);
			return $this->dbm->updateData('account',array('passwd'=>$updPwd),"id='$id'");
		}		
	}
?>