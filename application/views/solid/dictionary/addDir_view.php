<body>
<?php 
	if (isset($row))//编辑 时
	{
		$id 		= $row->id;
		$name	= $row->name;
		$url		= url::site().'solid/dictionary/saveDictionaryDir/'.$row->id;
	}
	else 
	{
		$url		= url::site().'solid/dictionary/saveDictionaryDir';
		list($id, $name)	= array(0, '');
	}
?>
<div class="easyui-layout" fit="true">
	<div region="center" border="false" style="padding:10px;background:#fff;border:1px solid #ccc;">
		<form id="form1" name="form1" method="post" action="">
			<table id="tabwin">
	   			<tr>
	        		<td>字典名称：</td>
					<td><input type="text" value="<?php echo $name;?>" name="name" class="easyui-validatebox" required="true" /></td>
				</tr>
			</table>
		    <input name="id" type="hidden" id="id" value="<?php echo $id;?>" />
		</form>
	</div>
	<div region="south" border="false" style="text-align:center;height:40px;">
		<br />
		<a class="easyui-linkbutton" iconCls="icon-ok" href="javascript:void(0)" onClick="return formSubmit('<?php echo $url;?>');">保存</a>&nbsp;<a class="easyui-linkbutton" iconCls="icon-cancel" href="javascript:void(0)" onClick="closeWin('DictionaryDirBox')">关闭</a>
	</div>	
</div>
</body>