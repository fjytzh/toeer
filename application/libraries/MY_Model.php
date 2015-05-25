<?php defined('SYSPATH') or die('No direct access allowed.');
abstract class Model extends Model_Core
{
	protected $table;
	public $dbm;	
	public $pre;
	public function __construct()
	{
		parent::__construct();
		$this->dbm		= new Dbm_Model;
		$this->table	= $this->setTable();
		$this->pre		= $this->dbm->getPre();
	}
	
	/**
	 * 设置表名
	 * @param string $newTable
	 */
	abstract protected function setTable();
	
	/**
	 * 保存记录
	 * @param array $post
	 */
	public function save($post,$table='')
	{
		if (!$table)
			$table	= $this->table;
		return $this->dbm->insertData($table,$post);
	}
	
	/**
	 * 更新记录
	 * @param array $upd
	 * @param array $wh
	 */
	public function update($upd,$wh,$table='')
	{
		if (!$table)
			$table	= $this->table;
		return $this->dbm->updateData($table, $upd,$wh);
	}
	
	/**
	 * 取得单条记录，返回object
	 * @param string $wh
	 */
	public function getOneData($wh,$field='*',$table='')
	{
		if (!$table)
			$table	= $this->table;
		return $this->dbm->getRecord($table,$field,$wh);
	}
	
	/**
	 * 取得字段值
	 * @param string $wh
	 * @param string $field
	 */
	public function getFieldData($field,$wh,$table='')
	{
		if (!$table)
			$table	= $this->table;
		return $this->dbm->getOne($table,$field,$wh);
	}
	
	/**
	 * 删除记录
	 * @param array $wh
	 */
	public function delete($wh,$table='')
	{
		if (!$table)
			$table		= $this->table;
		return $this->dbm->deleteData($table,$wh);
	}
	
	/**
	 * 取得结果集
	 * @param string $fields
	 * @param array $wh
	 * @param array $order
	 * @param int $limit
	 * @param int $start
	 */
	public function getData($start=0,$limit='',$fields='*',$wh='',$order='',$table='')
	{
		if (!$table)
			$table		= $this->table;
		return $this->dbm->fetchData($table,$fields,$wh,$order,$limit,$start);
	}
	
	public function getAdodb($field='*', $where='', $limit='',$table='') 
	{
		if (!$table)
			$table		= $this->table;	
        return $this->dbm->getAll($table, $field, $where, $limit); 	
	}
	
	/**
	 * 取得所有记录
	 */
	public function getAllCount($wh='',$table='')
	{
		if (!$table)
			$table		= $this->table;	
		return $this->dbm->getCount($table,$wh);
	}
	
}