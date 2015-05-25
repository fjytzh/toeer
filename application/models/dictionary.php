<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * 一手房项目组使用 - PHP项目控制类库
 * Copyright (c) 2011 房客
 * All rights reserved.
 *
 * @package    dictionary
 * @author     吴家庚 <63857991@QQ.com>
 * @copyright  2011 一手房项目
 * @version    v1.0
 */

/**
 * Dictionary 字典模型类
 * @package dictionary
 */
Class Dictionary_Model extends Model{
    public function __construct(){
		parent::__construct();
	}
	/**
     * 返回数据表
     * @return string
     */
	public function setTable(){
		return 'dictionary_item';
	}
	/**
	 * 返回字典总数
	 * @return int
	 */
	public function getCountDictionaryDir(){
		return $this->dbm->getCount('dictionary');
	}
	/**
	 * 返回字典列表
	 * @param int $start 开始条数
	 * @param int $limit 显示几条
	 * @param mix $fields 字段
	 * @param array $wh 查询条件
	 * @param mix $order 排序
	 * @return array 
	 */
	public function getDictionaryDirList($start=0,$limit='',$fields='*',$wh='',$order=''){
		$result = $this->dbm->fetchData('dictionary',$fields,$wh,$order,$limit,$start);
		$v = array();
		foreach ($result as $row)
		{
			$row->showdictionarylist = '<a href="javascript:void(0);" onclick="showDictionaryListBox('.$row->id.', \''.$row->name.'\')">查   看</a>'; 
			$v[]	= $row;
		}
		return $v;
	}
	/**
	 * 返回字典信息
	 * @param int $dicId 字典ID
	 * @return Array
	 */
	public function getDictionaryDirInfo($id){
		return $this->dbm->getRecord('dictionary', '*', "id = {$id}");
	}
	/**
	 * 增加及编辑入库
	 * @param string $name 字典名称
	 * @param int $dicId 字典ID
	 * @return bool
	 */
	public function setDictionaryData($name, $id=0){
		$data = array(
			'name' => $name
		);
		if ($id){
			return $this->dbm->updateData('dictionary', $data, array('id' => $id));
		}else {
			return $this->dbm->insertData('dictionary',$data);
		}
	}
	/**
	 * 删除字典
	 * @param int $dicId 字典
	 * @return bool
	 */
	public function deleteDictionaryDir($id){
		return $this->dbm->deleteData('dictionary', "id = {$id}");
	}
}
?>