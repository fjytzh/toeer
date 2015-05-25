<?php defined('SYSPATH') OR die('No direct access allowed.');
	class Admin_Controller extends Controller 
	{
		private $login;
		public function __construct()
		{
			parent::__construct();
			$this->login	= new Login_Model;
		}
		
		/**
		 * 登录页
		 */
		public function index()
		{
			$view			= new View('solid/admin/index_view');
			$view->error	= '';
			if ($this->input->post('userName') && $this->input->post('passwd'))
			{
				$row		= $this->login->checkUser($this->input->post('userName'),$this->input->post('passwd'));
				if (!$row)
				{
					echo json_encode(array('success'=>0,'msg'=>''));
					exit;
				}
				session_start();
				$_SESSION['gid']		= $row['gid'];
				$_SESSION['userName']	= $this->input->post('userName');
				$_SESSION['uid']		= $row['id'];
				$_SESSION['realName']	= $row['realName'];
				if ($row['gid'] == 1)//如果是管理员,则需要所有mod的权限
				{
					$mod			= new Mod_Model;
					$powers			= $mod->getAllId();
				}
				else
				{
					$group			= new Group_Model;
					$rs 			= $group->getCheckPower($row['gid']);
					if ($rs['modPrePower'] != "")
					{
						$powers = $rs['modPower'].",".$rs['modPrePower'];
					}
					else
					{
						$powers = $rs['modPower'];
					}
				}
				$_SESSION['powers'] 	= $powers;
				$_SESSION['realName']	= $row['realName'];
				$log		= new Log_Model;
				$post		= array(
					'realName'	=> $row['realName'],
					'ctime'		=> time()
				);								
				$log->save($post);	
				echo json_encode(array('success'=>1,'msg'=>''));
				exit;
			}			
			$view->render(true);
		}

		/**
		 * 退出系统
		 *
		 */
		public function logout()
		{
			session_start();
			session_destroy();
			url::redirect('solid/admin');			
		}			
			
	}