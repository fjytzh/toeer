<?php 
	class ArticleClass_Model extends Model
	{
		
		public function __construct()
		{
			parent::__construct();
		}
		
		public function setTable()
		{
			return 'articleClass';
		}
	}
