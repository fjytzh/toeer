<?php defined('SYSPATH') OR die('No direct access allowed.');
	class Welcome_Controller extends Template_Controller 
	{
		public function __construct()
		{
			parent::__construct();
			url::redirect('solid/admin');	
		}

	}
