<?php defined('SYSPATH') OR die('No direct access allowed.');
	class Search_Controller extends Template_Controller 
	{
		private $search;
		public function __construct()
		{
			parent::__construct();
			$this->search	= new Search_Model;	
			if( !file_exists($this->getMerchantPath())) 
			{
				throw new Kohana_User_Exception('Invalid merchant path', 'Could not find merchant path '.$this->getMerchantPath());
			}		
			if( !file_exists($this->getIndexPath())) 
			{
				throw new Kohana_User_Exception('Invalid index path', 'Could not find merchant path '.$this->getIndexPath());
			}		
				
			if ($path = Kohana::find_file('vendor', 'Zend/Loader'))
			{
			    ini_set('include_path', ini_get('include_path').PATH_SEPARATOR.dirname(dirname($path)));
			}	
			$this->loadLibs();
		}
		
		private function getMerchantPath() {
			return APPPATH.'merchants';
		}		
		
		private function getIndexPath()
		{
			return $this->getMerchantPath().'/index';
		}
		
		public function loadLibs() 
		{
			require_once 'Zend/Loader/Autoloader.php';
			Zend_Loader_Autoloader::getInstance();
		}

		
		public function geneIndex($id='')//生成索引
		{
			if (file_exists($this->getMerchantPath().'/touch.lock'))
			{
				echo '加锁文件';
				exit;
			}
			else 
			{
				touch($this->getMerchantPath().'/touch.lock');
				$set	= true;
				if ($id)
				{
					$set	= '';
				}
				else 
				{
					error_log("开始运行每周脚本".date('Y-m-d H:i:s')."\n",3,$this->getMerchantPath().'/lucene.log');
				}
				echo '正在生成索引<br>';
				$rs			= $this->search->getArticle();
				Zend_Search_Lucene_Analysis_Analyzer::setDefault(new Zend_Search_Lucene_Analysis_Analyzer_Common_Bean_CaseInsensitive());
				$index 	= Zend_Search_Lucene::create($this->getIndexPath(),$set);
				$i		= 0;
				foreach ($rs as $row)
				{
					$i++;
					if ($i ==1)
					{
						$fp		= fopen($this->getMerchantPath().'/luceneId.php','w');
						fwrite($fp,$row->aid);
					}
					echo '正在生成第'.$i.'条<br>';
					$doc = new Zend_Search_Lucene_Document(); 
					$doc->addField(Zend_Search_Lucene_Field::Text('title',$row->title,'utf-8'));
					$doc->addField(Zend_Search_Lucene_Field::UnIndexed('myid',$row->aid));
					$index->addDocument($doc); 
				}
				$index->commit();	
				unlink($this->getMerchantPath().'/touch.lock');			
			}
		}

		public function search()
		{
			$keyword		= '东方';
			if ($keyword)
			{
				if (strlen($keyword)<1)
				{
					$data['rs']		= '';
				}
				else 
				{
					$scws 		= scws_new();
					$string		= iconv('utf-8','gbk',$keyword);
					$scws->send_text($string);
					$sp			= array();
					while ($tmp = $scws->get_result())
					{
						foreach ($tmp as $segment)
						{
							if (strlen($segment['word'])>1)
							{
								$sp[]	= $segment['word'];
							}
						}
					}
					
					if ($sp <1)
						$sp		= $string;
					else
						$sp		= implode(' ',$sp);
					$sp		= explode(' ',iconv('gbk','utf-8',$sp));
					$sp		= array_unique($sp);
					if (count($sp) > 8)
						$data['rs']	= '';
					else 
					{
						$sps			= implode(' AND ',$sp);
						$index			= Zend_Search_Lucene::open($this->getIndexPath());  
						Zend_Search_Lucene::setDefaultSearchField('name');
						$data['rs']		= $index->find($sps);
					}
				}
				$this->template->content	= new View('solid/search/list_view',$data);
			}
			else 
			{
				$data['rs']		= '';
				$this->template->content	= new View('solid/search/list_view',$data);
			}
		}		
		
		
		public function twentyGeneIndex()
		{
			$id		= file_get_contents('configs/LuceneId.php');
			$this->geneIndex($id);
			$time	= date('Y-m-d');
			error_log("开始运行".date('Y-m-d H:i:s')."\n",3,'merchants/twentyLucene'.$time.'.log');
		}	

				
//		public function test($encoding='')
//		{
//			$analyzer = new Zend_Search_Lucene_Analysis_Analyzer_Common_Text_CaseInsensitive();
//			$keyword	= '专柜正品 德国 voiki 沃克 3人休闲帐篷 ';
//			$analyzer->setInput($keyword,'utf-8'); 
//			$position     = 0;
//			$tokenCounter = 0;
//			while (($token = $analyzer->nextToken()) !== null) 
//			{
//				$tokenCounter++;
//				$tokens[] = $token;
//			}
//			print_r($tokens);
//		}
	
	}