
<?php defined('SYSPATH') OR die('No direct access allowed.');
	/**
	 * image upload helper class.
	 *
	
	 */
	class Img_Core 
	{
		public static function doUpload($folder,$file)
		{
			if (is_uploaded_file($file['tmp_name']))
			{
				if (getimagesize($file['tmp_name']))
				{
					$path_parts 	= pathinfo($file['name']);
					$extension		= strtolower($path_parts['extension']);
					$realImg		= $folder.'/'.time().rand(1000,9999).'.'.$extension;
					$allow			= array('jpg','gif','png');
					if ($extension == 'jpg')
						$other	= 'jpeg';
					else 
						$other	= $extension;
					if (in_array($extension,$allow))
					{
						
					}
					else
					{
					
					}
				}
				else
				{
				
				}
			}
			else
			{
			}
		}
	}
