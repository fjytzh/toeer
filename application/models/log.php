<?php 
	class Log_Model extends Model
	{
		public function __construct()
		{
			parent::__construct();
		}	

		public function setTable()
		{
			return 'log';
		}
		
	}