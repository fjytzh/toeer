<?php 
	class Mod_Model extends Model
	{
		public $dbm;

		public function __construct()
		{
			parent::__construct();
		}
		
		public function setTable()
		{
			return 'sysmod';
		}
		
		/**
		 * 
		 * 取得 mod
		 * @param int $bid
		 */
		public function getMod($bid=0)
		{
			return $this->dbm->fetchData('sysmod',array('id,modName,url,visible,leaf,app'),array('bid'=>$bid),array('orderNum'=>'desc'));
		}
		
		public function getUrlId($url)
		{
			return $this->dbm->getOne('sysmod','id',"url='$url'");
		}

		/**
		 * 取得所有mod 的id
		 */
		public function getAllId()
		{
			$rs		= $this->dbm->fetchData('sysmod','id');
			$ids	= array();
			foreach ($rs as $row)
			{
				$ids[]	= $row->id;
			}
			if (count($ids)>0)
				return implode(',',$ids);
			else
				return false;
		}
		
		/**
		 * 
		 * 保存mod..
		 * @param array $data
		 * @param int $bid
		 */
		public function saveValue($data,$bid)
		{
			$exist	= $this->getExistUrl($data['url']);				
			if ($exist>0)
			{
				return false;
			}
			else 
			{
				$return	= $this->dbm->insertData('sysmod', $data);
				if ($return)//将上级的leaf设为1
				{
					$upd	= array('leaf'=>1);
					$this->dbm->updateData('sysmod', $upd,"id={$data['bid']}");
				}
				return $return;				
			}
		}
		
		public function getExistUrl($url)
		{
			if ($url !='')
			{
				return $this->dbm->getCount('sysmod',"url='$url'");
			}
			return false;
			
		}
		
		public function updateValue($upd,$id)
		{
			$return		= $this->dbm->updateData('sysmod',$upd,$id);
			if ($return)
			{
				$updateLeaf		= array('leaf'=>1);
				$this->dbm->updateData('sysmod', $updateLeaf,"id={$upd['bid']}");
				return true;
			}
			else
				return false;
		}		

	}
?>