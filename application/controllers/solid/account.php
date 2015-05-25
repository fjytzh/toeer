<?php defined('SYSPATH') or die('No direct access allowed.');
class Account_Controller extends Template_Controller
{
	private $account;

	public function __construct()
	{
		parent::__construct();
		comm::validUser();
		$this->account = new Account_Model();
	}

	/**
	 * 修改密码
	 */
	public function edit()
	{
		$this->template->js		= array('solid/account.js');
		$this->template->content = new View('solid/account/edit_view');
	}

	public function setPwd()
	{
		if($this->input->post('oldPasswd') && $this->input->post('newPasswd') && $this->input->post('confirmPasswd'))
		{
			$id = $this->account->checkOldPasswd($this->input->post('oldPasswd'));
			if($id)
			{
				$return = $this->account->updateNewPasswd($this->input->post('newPasswd'),$id);
				if($return>0)
					echo json_encode(array('msg'=>'新密码已保存','success'=>1));
				else
					echo json_encode(array('msg'=>'密码更新失败','success'=>0));
			}
			else
				echo json_encode(array('msg'=>'旧密码错误','success'=>0));
		}
		else
		{
			echo json_encode(array('msg'=>'参数错误'));
		}
		exit;
	}
}