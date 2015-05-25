<?php defined('SYSPATH') OR die('No direct access allowed.');
class Cache_Model extends Model
{
	private $memcache;
	private $mtrue;

	public function __construct()
	{
		$this->mtrue		= Kohana::config('config.memcache');
		if ($this->mtrue)
		{
			$this->memcache	= new Memcache;
			$this->memcache->connect(Kohana::config('config.memcache_ip'),Kohana::config('config.memcache_port'));
		}
	}
	
	public function setTable()
	{
		
	}
	
	private function checkMemcache()
	{
		if (!is_object($this->memcache))
		{
			return 'noMemcache';
		}
		else 
		{
			return 'true';
		}
	}
	
	public function getDatas($key)
	{
		if (is_object($this->memcache))
		{
			$data	= $this->memcache->get($key);
			return $data;
		}
		else 
			return 'noMemcache';
	}
	
	public function deleteKey($keys)
	{
		if (is_object($this->memcache))
		{
			if (is_array($keys))
			{
				foreach ($keys as $key)
				{
					$this->memcache->delete($key);
				}			
			}
			else
			{
				$this->memcache->delete($keys);
			}
		}
	}	
	
	public function setCache($key,$data,$time)
	{
		if (is_object($this->memcache))
		{
			return $this->memcache->set($key,$data,false,$time);	
		}
	}
}	