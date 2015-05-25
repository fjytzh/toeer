<?php defined('SYSPATH') OR die('No direct access allowed.');
	class Member_Controller extends Template_Controller 
	{
		private $login;
		private $mod;
		private $msg;
		private $cacheKey;
		public function __construct()
		{
			parent::__construct();
			comm::validUser();
			$this->mod	= new Mod_Model;	
			$this->cacheKey			= md5('solid/member/top/level.0');
		}
		
		public function index()
		{
			$data['top']			= $this->top();
			$data['seg']			= $this->uri->segment('index') ? $this->uri->segment('index'):3;
			$this->template->content = new View('solid/member/frame_view',$data);
		}
		
		/*
		 * 上层框架内容
		 */
		private function top()
		{
			return $this->mod->getMod();
		}
		
		/*
		 * 左侧栏目
		 */
		public function left()
		{
			$seg		= $this->uri->segment(4);
			$rs			= $this->mod->getMod();
			$linkText	= '';
			$powers		= comm::getPowers();
			foreach ( $rs as $row )
			{
				if ( !( $row->id == $seg ) )
				{
					continue;
				}
				$linkText = $row->modName;
				break;
			}
			$app		= new App_Model;
			$apps		= $app->getAppPaths();
			$preUrl		= 'solid/';
			$rs2		= $this->mod->getMod($seg);
			$array		= array();
			foreach ($rs2 as $p)
			{
				if (in_array($p->id,$powers))//取得有权限的数据
				{
					if ($p->visible =='1')
					{
						$url		= $p->url ? url::site().$apps[$p->app].'/'.$p->url:'';
						$cacheKey3	= md5('solid/member/top/level.1.'.$p->id);
						$rs3		= $this->mod->getMod($p->id);
						$array2		= array();
						if (@count($rs3)==0)
						{
							$showParentNote	= true;
						}
						else
							$showParentNote	= false;//节点是否展示
						foreach ($rs3 as $s)
						{
							if (in_array($s->id,$powers))
							{
								if ($s->visible	== '1')
								{
									$url		= $s->url ? url::site().$apps[$s->app].'/'.$s->url:'';
									$array2[]	= array('id'=>$s->id,'attributes'=>array('url'=>$url),'text'=>$s->modName);
									$showParentNote		= true;//如果子节点有不全部是隐藏，父节点才需要展示
								}
							}
						}
						if ($showParentNote)
							$array[]	= array('id'=>$p->id,'attributes'=>array('url'=>$url),'text'=>$p->modName,'children'=>$array2);
					}
				}
			}
			$json		= array(array('id'=>$seg,'text'=>$linkText,'children'=>$array));
			echo json_encode($json);
			exit;
		}
		
		/**
		 * 主内容
		 */
		public function main()
		{
			$view 		= new View('solid/member/main_view');
			$view->html	= '欢迎使用统一管理平台';
			$view->render(true);
		}
	}