<body>
<?php 
	if (isset($row))//编辑 时
	{
		$id 		= $row->id;
		$dicId 		= $row->dicId;
		$itemValue	= $row->itemValue;
		$name	= $row->name;
		$orderNum	= $row->orderNum;
		$url		= url::site().'solid/dictionary/saveDictionary';
	}
	else 
	{
		$url		= url::site().'solid/dictionary/saveDictionary';
		list($id, $dicId, $itemValue, $name, $orderNum)	= array(0, $dicId, '', '', 0);
	}
?>
<div class="easyui-layout" fit="true">
	<div region="center" border="false" style="padding:10px;background:#fff;border:1px solid #ccc;">
		<form id="form1" name="form1" method="post" action="">
			<table id="tabwin">
	   			<tr>
	        		<td>名称：</td>
				  <td><input type="text" value="<?php echo $name;?>" name="name" class="easyui-validatebox" required="true" /><font color="#FF0000">不可重复</font></td>
				</tr>
				<tr>
	        		<td>值：</td>
					<td><input type="text" value="<?php echo $itemValue;?>" name="itemValue" class="easyui-validatebox" required="true" /><font color="#FF0000">不可重复</font></td>
				</tr>
				<tr>
	        		<td>排序：</td>
					<td><input type="text" value="<?php echo $orderNum;?>" name="orderNum" class="easyui-validatebox" required="true" /></td>
				</tr>
			</table>
		    <input name="dicId" type="hidden" id="dicId" value="<?php echo $dicId;?>" />
			<input name="id" type="hidden" id="id" value="<?php echo $id;?>" />
		</form>
	</div>
	<div region="south" border="false" style="text-align:center;height:40px;">
		<br />
		<a class="easyui-linkbutton" iconCls="icon-ok" href="javascript:void(0)" onClick="return formSubmitBoxClose('<?php echo $url;?>', 'form1', 'dl', 'DictionaryBox');">保存</a>&nbsp;<a class="easyui-linkbutton" iconCls="icon-cancel" href="javascript:void(0)" onClick="closeWin('DictionaryBox')">关闭</a>
	</div>	
</div>
</body>