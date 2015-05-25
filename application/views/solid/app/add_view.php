<body>
<?php 
	if (isset($row))//编辑 时
	{
		$path		= $row->path;
		$name		= $row->name;
		$url		= url::site().'solid/app/updateApp/'.$row->id;
	
	}
	else 
	{
		$url	= url::site().'solid/app/saveApp';
		list($path,$name) = '';
	}
?>
<div class="easyui-layout" fit="true">
	<div region="center" border="false" style="padding:10px;background:#fff;border:1px solid #ccc;">
    <form id="form1" method="post">
        <table id="tabwin">
            <tr>
                <td>项目名称:</td>
                <td><input type="text"  class="easyui-validatebox" name="name"  required="true" value="<?php echo $name;?>" /></td>
            </tr>
            <tr>
                <td>相对路径:</td>
                <td><input type="text"  class="easyui-validatebox" name="path" value="<?php echo $path;?>" /></td>
            </tr>
        </table>
    </form>		
	</div>
	<div region="south" border="false" style="text-align:center;height:40px;">
		<br />
		<a class="easyui-linkbutton" iconCls="icon-ok" href="javascript:void(0)" onclick="return formSubmit('<?php echo $url;?>');">保存</a>&nbsp;<a class="easyui-linkbutton" iconCls="icon-cancel" href="javascript:void(0)" onclick="closeWin('w')">关闭</a>
	</div>
</div>
</body>