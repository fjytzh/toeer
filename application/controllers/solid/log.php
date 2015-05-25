<?php defined('SYSPATH') or die('No direct access allowed.');
class Log_Controller extends Template_Controller
{
	private $log;

	public function __construct()
	{
		parent::__construct();
		comm::validUser();
		$this->log = new Log_Model();
	}
	
	public function listLog()
	{
		$this->template->js			= array('solid/log_listlog.js');
		$this->template->content	= new View('solid/log/list_view');
	}
	
	public function getLog()
	{
		$total		= $this->log->getAllCount();
		$page		= $this->input->post('page');
		$size		= $this->input->post('rows');
		$start		= ($page-1)*$size;
		$rs			= $this->log->getData($start,$size,'','',array('id'=>'desc'));
		$v			= array();
		foreach ($rs as $row)
		{
			$row->ctime	= date('Y-m-d H:i:s',$row->ctime);
			$v[]	= $row;
		}
		echo json_encode(array('total'=>$total,'rows'=>$v));
		exit;			
	}		
}