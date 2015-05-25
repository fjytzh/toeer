<?php 
	class App_Model extends Model
	{
		public function __construct()
		{
			parent::__construct();
		}	

		public function setTable()
		{
			return 'app';
		}
		
		public function getAppPaths()
		{
			$rs		= $this->getData(0,100);
			$array	= array();
			foreach ($rs as $row)
			{
				$array[$row->id] = $row->path;
			}
			return $array;
		}		

	}
