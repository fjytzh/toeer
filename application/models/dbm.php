<?php defined('SYSPATH') OR die('No direct access allowed.');

	/**
	 * 数据库操作模块
	 * @author xilin
	 *
	 */
	class Dbm_Model
	{
		private $debug	= false;
		public $pre	= '';
		public function __construct($database='')
		{
			$this->db 		= Database::instance($database);
			$this->pre		= $this->db->table_prefix();
		}
		
		public function setDebug()
		{
			$this->debug	= true;
		}
		
		public function getPre()
		{
			return $this->db->table_prefix();
		}
		
		private function debugSql()
		{
	    	if ($this->debug)
	    		echo $this->db->last_query();				
		}
			
		/**
		 * sql where语句转换
		 * @param array $data
		 */
		private function convert_where($data)
		{
			if (is_array($data))
			{
				$sign	= 0;
				foreach ($data as $key=>$value)
				{
					$this->db->where($key,$value);
				}
			}
			else
			{
				if ($data) 
					$this->db->where($data);
			}
		}
	
		public function dbmquery($sql)
		{
			$return		=  $this->db->query($sql);
			$this->debugSql();
			return $return;			
		}				
	    /**
	     * 返回查询总数
	     *
	     * @param string $table
	     * @param array $data
	     * @return integer
	     */
	    public function getCount($table, $where='') 
	    {
	    	$return		= $this->getOne($table, 'COUNT(*)', $where);
			$this->debugSql();
	    	return $return;
	        
	    }
	    
	    /**
	     * 插入数据
	     *
	     * @param string $tablename
	     * @param array $post
	     * @return integer
	     */
	    public function insertData($tablename, $post) 
	    {
	        $this->db->set($post);
	        $return = $this->db->insert($tablename);
			$this->debugSql();
	        return $return->insert_id(); 
	    }
	
	    /**
	     * 更新数据
	     *
	     * @param string $tablename
	     * @param array $data
	     * @param mix $where
	     * @return boolen
	     */
	    public function updateData($tablename,$data,$where='') 
	    {
	        $return 	= $this->db->update($tablename, $data,$where); 
			$this->debugSql();
			if ($return)
			{
				return $return->count();
			}
			else
				return false;
	    }
	
	    /**
	     * 删除数据
	     *
	     * @param string $tablename
	     * @param mix $where
	     * @return boolen
	     */    
	    public function deleteData($tablename, $where='') 
	    {
	        $return 	= $this->db->delete($tablename, $where); 
			$this->debugSql();        
	        return (count($return) > 0) ? count($return) : FALSE;
	    }
	
	    /**
	     * 取得某个字段的值
	     *
	     * @param string $table
	     * @param string $field
	     * @param string $where
	     * @return string
	     */
	    public function getOne($table, $field, $where='') 
	    {
	        if ($where) $where 	= " WHERE $where ";
	        $return	= '';
	        $table	= $this->pre.$table;
	        $sql 	= "SELECT $field FROM $table $where";
	        $rs 	= $this->db->query($sql);
	        foreach ($rs as $row) 
	        {
	        	$return = @$row->$field;
	        }
			$this->debugSql();        
	        return $return;
	    }	


	    //取得某行的数据
	    public function getRow($table, $field='*', $where='') 
	    {    	
	        if ($where) $where 	= " WHERE $where ";
	        $table	= $this->pre.$table;
	        $sql 	= "SELECT $field FROM $table $where";
	        $rs 	= $this->db->query($sql);
			$this->debugSql();     
	        $row 	= FALSE;
	        foreach ($rs->result(FALSE) as $row) 
	        {
	        	return $row;
	        }
	    }
	    
	    //取得某行的数据(返回对象)
	    public function getRecord($table, $field='*', $where='') 
	    {    	
	        if ($where) $where 	= " WHERE $where ";
	        $table	= $this->pre.$table;
	        $sql 	= "SELECT $field FROM $table $where";
	        $rs 	= $this->db->query($sql);
			$this->debugSql();     
	        $row 	= FALSE;
	        foreach ($rs->result_array() as $row) 
	        {
	        	return $row;
	        }
	    }
	
	    //取得所有结果集的数据
	    public function getAll($table, $field='*', $where='', $limit='') 
	    {
	        if ($where) $where 	= " WHERE $where ";
	        if ($limit) $limit 	= " LIMIT $limit ";
			$table	= $this->pre.$table;
	        $sql 	= "SELECT $field FROM $table $where $limit";
	        $rs 	= $this->db->query($sql);
			$this->debugSql();
			return $rs->result_array();
	    }
	    
		/**
		 * 取得表数据
		 *
		 * @param string $tablename
		 * @param array $fields
		 * @param array $wh
		 * @param array $order
		 * @param integer $limit
		 * @param integer $start
		 * @return array
		 */
		function fetchData($tablename,$fields='*',$wh='',$order='',$limit='',$start=0)
		{
			if (!$fields)//奇怪,linux下必须加入这个条件
				$fields	= '*';
			if (is_array($fields))
			{
				$fields	= implode(',',$fields);
			}
			$this->db->select($fields);
			$this->convert_where($wh);
			if (is_array($order))
			{
				foreach ($order as $key=>$value)
				{
					if (!$key)
					{
						$key	= $value;
						$value	= 'ASC';
					}
					$this->db->orderby($key,$value);
				}
			}
			else 
			{
				if ($order)
				{
					$this->db->orderby($order);
				}
			}
			if ($limit)
				$this->db->limit($limit,$start);
			$rs		= $this->db->get($tablename);
			$this->debugSql();			
			return $rs->result_array();
		}	    
	}
?>