<body>
<?php 
	if (isset($row))//编辑 时
	{
		$title		= htmlspecialchars($row->title);
		$content	= htmlspecialchars($row->content);
		$url		= url::site().'solid/bulletin/updateBulletin/'.$row->id;
	}
	else 
	{
		$url	= url::site().'solid/bulletin/saveBulletin';
		list($title,$content) = '';
	}
?>
<div class="easyui-layout" fit="true">
	<div region="center" border="false" style="padding:10px;background:#fff;border:1px solid #ccc;">
    <form id="form1" method="post">
        <table id="tabwin">
            <tr>
                <td>标题:</td>
                <td><input type="text"  class="easyui-validatebox" name="title" size="50" required="true" value="<?php echo $title;?>" /></td>
            </tr>
            <tr>
                <td>内容:</td>
                <td><textarea name="content" rows="7" cols="40"><?php echo $content;?></textarea></td>
            </tr>
        </table>
    </form>		
	</div>
	<div region="south" border="false" style="text-align:center;height:40px;">
		<br />
		<span><a class="easyui-linkbutton" iconCls="icon-ok" href="javascript:void(0)" onclick="return formSubmit('<?php echo $url;?>');">保存</a>&nbsp;</span><a class="easyui-linkbutton" iconCls="icon-cancel" href="javascript:void(0)" onclick="closeWin('w')">关闭</a>
	</div>
</div>
</body>