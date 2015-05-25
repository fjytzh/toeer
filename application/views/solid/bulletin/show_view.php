<body>
<?php 
	if (isset($row))//编辑 时
	{
		$title		= htmlspecialchars($row->title);
		$content	= htmlspecialchars($row->content);
		$ctime		= date('Y-m-d H:i:s');
	}
?>
<div class="easyui-layout" fit="true">
	<div region="center" border="false" style="padding:10px;background:#fff;border:1px solid #ccc;">
    <form id="form1" method="post">
        <table id="tabwin">
            <tr>
                <td>标题:</td>
                <td><?php echo $title;?></td>
            </tr>
            <tr>
                <td>内容:</td>
                <td><?php echo $content;?></td>
            </tr>
            <tr>
                <td>公告时间:</td>
                <td><?php echo $ctime;?></td>
            </tr>
        </table>
    </form>		
	</div>
	<div region="south" border="false" style="text-align:center;height:40px;">
		<br />
		<a class="easyui-linkbutton" iconCls="icon-cancel" href="javascript:void(0)" onclick="closeWin('w')">关闭</a>
	</div>
</div>
</body>