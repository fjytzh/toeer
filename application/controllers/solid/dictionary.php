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
 * Dictionary 字典控制类
 * @package dictionary
 */
class Dictionary_Controller extends template_Controller 
{
	public $dictionary;
	public function __construct()
	{
		parent::__construct();
		comm::validUser();
		$this->dictionary = new Dictionary_Model();
	}
	//字典列表
	public function dictionarydirlist()
	{
		$this->template->js			= array('solid/dictionary.js');
		$this->template->content	= new View('solid/dictionary/list_view');
	}
	//返回字典列表json
	public function getDictionaryDirJson()
	{
		$total		= $this->dictionary->getCountDictionaryDir();
		$page		= $this->input->post('page');
		$size		= $this->input->post('rows');
		$start		= ($page-1)*$size;
		$ddlist 	= $this->dictionary->getDictionaryDirList($start, $size);
		echo json_encode(array('total'=>$total,'rows'=>$ddlist));
		exit;
	}
	//增加字典
	public function addDictionaryDir()
	{
		$this->template->content	= new View('solid/dictionary/addDir_view');
	}
	//修改字典
	public function editDictionaryDir($dicId){
		$dicId = intval($dicId);
		$data['row']	= $this->dictionary->getDictionaryDirInfo($dicId);
		$this->template->content	= new View('solid/dictionary/addDir_view', $data);
	}
	//保存字典
	public function saveDictionaryDir(){
		$id		= $this->input->post('id');
		$name = $this->input->post('name');
		$result = $this->dictionary->setDictionaryData($name, $id);
		if ($result){
			echo json_encode(array('msg'=>'保存成功','success'=>1));
		}else{
			echo json_encode(array('msg'=>'保存失败','success'=>0));
		} 
		exit;
	}
	//删除字典
	public function delDictionaryDir($dicId){
		$dicId = intval($dicId);
		$total		= $this->dictionary->getAllCount("dicId = {$dicId}");
		if ($total){
			echo json_encode(array('msg'=>'字典项不为空，不可删除','success'=>0));
			exit;
		}
		$result 	= $this->dictionary->deleteDictionaryDir($dicId);
		if ($result){
			echo json_encode(array('msg'=>'删除成功','success'=>1));
		}else{
			echo json_encode(array('msg'=>'删除失败','success'=>0));
		} 
		exit;
	}
	//字典项列表
	public function dictionaryList($dicId){
		$dicId = intval($dicId);
		$this->template->content	= new View('solid/dictionary/list_view');
	}
	//返回字典项列表json
	public function getDictionaryJson($dicId)
	{
		$dicId		= intval($dicId);
		$total		= $this->dictionary->getAllCount("dicId = {$dicId}");
		$page		= $this->input->post('page');
		$size		= $this->input->post('rows');
		$start		= ($page-1)*$size;
		$rs		 	= $this->dictionary->getData($start, $size, "*", array('dicId' => $dicId));
		$v			= array();
		foreach ($rs as $row)
		{
			$v[]	= $row;
		}
		echo json_encode(array('total'=>$total,'rows'=>$v));
		exit;
	}
	//增加字典项
	public function addDictionary($dicId)
	{
		$data['dicId']				= intval($dicId);
		$this->template->content	= new View('solid/dictionary/add_view', $data);
	}
	//修改字典项
	public function editDictionary($dicId, $id){
		$dicId			= intval($dicId);
		$id 			= intval($id);
		$data['row']	= $this->dictionary->getOneData("id = '$id'");
		$this->template->content	= new View('solid/dictionary/add_view', $data);
	}
	//保存字典项
	public function saveDictionary(){
		$id		= intval($this->input->post('id'));
		$dicId		= intval($this->input->post('dicId'));
		$itemValue 	= $this->input->post('itemValue');
		$name = $this->input->post('name');
		$orderNum	= intval($this->input->post('orderNum'));
		$result		= false;
		$dataArray = array(
			'dicId'			=> $dicId,
			'itemValue'		=> $itemValue,
			'name'	=> $name,
			'orderNum'		=> $orderNum
		);
		if ($id){
			$result 	= $this->dictionary->getOneData("dicId = '{$dicId}' and itemValue = '{$itemValue}' and id != {$id}");
			if ($result){
				echo json_encode(array('msg'=>'保存失改，值重复','success'=>0));
				exit;
			}
			$result		= $this->dictionary->update($dataArray, array('id'=>$id));
		}else {
			$result = $this->dictionary->getOneData("dicId = '{$dicId}' and itemValue = '{$itemValue}'");
			if ($result){
				echo json_encode(array('msg'=>'保存失改，值重复','success'=>0));
				exit;
			}
			$result 	= $this->dictionary->save($dataArray);
		}
		if ($result){
			echo json_encode(array('msg'=>'保存成功','success'=>1));
		}else{
			echo json_encode(array('msg'=>'保存失败','success'=>0));
		} 
		exit;
	}
	//删除字典
	public function delDictionary($dicId, $id){
		$dicId 			= intval($dicId);
		$id 			= intval($id);
		$result 		= $this->dictionary->delete("id='{$id}'");
		if ($result){
			echo json_encode(array('msg'=>'删除成功','success'=>1));
		}else{
			echo json_encode(array('msg'=>'删除失败','success'=>0));
		} 
		exit;
	}
	//返回字典项Json
	public function getDic()
	{
		$did	= uri::segment('getDic');
		$rs		= $this->dictionary->getData(0,100,'',array('dicId'=>$did));
		echo json_encode($rs);
		exit;
	}
	
	//返回combotree Json
	public function getComboTreeDictionaryJson($dicId){
		$dicId		= intval($dicId);
		$rs		 	= $this->dictionary->getData(0, 0, "*", array('dicId' => $dicId));
		$v			= array();
		foreach ($rs as $row)
		{
			$v[]	= array('id'=>$row->itemValue,'text'=>$row->name);
		}
		echo json_encode($v);
		exit;
	}
}