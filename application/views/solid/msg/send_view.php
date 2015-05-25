<body>
<?php 
	$url	= url::site().'solid/outbox/save';
?>
<div class="easyui-layout" fit="true">
	<div region="center" border="false" style="padding:10px;background:#fff;border:1px solid #ccc;">
    <form id="form1" method="post">
        <table id="tabwin">
            <tr>
                <td>选择发送对象:</td>
                <td><input class="easyui-combobox" style="width:300px" name="users[]" url="<?php echo url::site();?>solid/outbox/echoUsers" valueField="id" textField="realName" multiple="true" panelHeight="auto"></td>
            </tr>
            <tr>
                <td>内容:</td>
                <td><textarea name="content" class="easyui-validatebox" required="true" rows="7" cols="40"></textarea></td>
            </tr>
        </table>
        <input type="hidden" value="" id="str" name="str" />
    </form>		
	</div>
	<div region="south" border="false" style="text-align:center;height:40px;">
		<br />
		<a class="easyui-linkbutton" iconCls="icon-ok" href="javascript:void(0)" onclick="doSubmit('<?php echo $url;?>','users')">发送</a>&nbsp;<a class="easyui-linkbutton" iconCls="icon-cancel" href="javascript:void(0)" onclick="closeWin('w')">关闭</a>
	</div>
</div>
</body>