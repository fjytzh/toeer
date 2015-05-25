<?php 
	class Article_Model extends Model
	{
		
		public function __construct()
		{
			parent::__construct();
		}
		
		public function setTable()
		{
			return 'article';
		}
		public function getArticleList(){
			
		}
	}
