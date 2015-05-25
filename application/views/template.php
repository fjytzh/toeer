<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="NOODP" />
<link rel="stylesheet" type="text/css" href="<?php echo url::jsUrl();?>jqueryeui/themes/default/easyui.css" />
<link rel="stylesheet" type="text/css" href="<?php echo url::jsUrl();?>jqueryeui/themes/icon.css" />
<script type="text/javascript" src="<?php echo url::jsUrl();?>jqueryeui/jquery-1.6.min.js"></script>
<script type="text/javascript" src="<?php echo url::jsUrl();?>jqueryeui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="<?php echo url::jsUrl();?>jqueryeui/locale/easyui-lang-zh_CN.js"></script>
<script type="text/javascript" src="<?php echo url::jsUrl();?>solidScript.js"></script>
<script type="text/javascript">
var siteUrl		= '<?php echo url::site();?>';
</script>
<link rel="stylesheet" type="text/css" href="<?php echo url::cssUrl();?>solid.css" />
<?php 
	if (isset($css))
	{
		foreach ($css as $singal)
		{
			echo '<link rel="stylesheet" type="text/css" href="'.url::cssUrl().$singal.'" />'."\r\n";
		}
	}
	if (isset($js))
	{
		foreach ($js as $singal)
		{
			echo '<script type="text/javascript" src="'.url::jsUrl().$singal.'"></script>'."\r\n";
		}
	}
	
	if (!isset($title))
		$title	= Kohana::config('config.proTitle');
?>
<title><?php echo $title;?></title>
</head>
	<?php if (isset($content)) echo $content;?>
</html>
