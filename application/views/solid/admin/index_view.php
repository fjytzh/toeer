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
<link rel="stylesheet" type="text/css" href="<?php echo url::cssUrl();?>login.css" />
<title>请登录</title>
</head>

	<body>
		<div id="contianer">
			<form id="form1" method="post">
			<div class="wrapper">
			    <div class="ribbon">请 输 入 您 的 账 号</div>
				<div class="logo"></div>
				<div class="loginwrapper">
					<span class="usertext">用户名:<span id="error"></span></span><br />
					<input class="textbox easyui-validatebox" name="userName" type="text" size="25"  required="true" /><br />
					<span class="usertext">密  码:</span><br />
					<input class="textbox easyui-validatebox" type="password" name="passwd" size="25"  required="true" />
					<img src="../images/login/lock.png" alt="Lock Image" /><br />
				</div>
				<div class="bottomwrapper">
					<input type="submit" class="button" value="" />
				</div>
			</div>
			</form>
		</div>
	<script type="text/javascript">
	$('#form1').form({
	    url:'admin',
	    onSubmit:function(){
	        return $(this).form('validate');
	    },
	    success:function(data){
		    var data	= eval("("+data+")");
	    	if (data.success ==0){
				$('#error').html("用户或密码错误");
		    }
		    else{
			 	location.href="member";   
		    }  
	    }
	});	
	</script>		
	</body>


	
</html>
