<body>
<div id="w" class="easyui-window" cache="false" modal="true" shadow="true" closed="true" iconCls="icon-save" style="padding:5px;"></div>
<?php 
	if (isset($rs))//编辑 时
	{
		foreach ($rs as $row)
		{
			$realName		= $row->realName;
			$content		= htmlspecialchars($row->msg);			
			$time			= date('Y-m-d H:i:s',$row->ctime);			
		}
	}
?>
<div class="easyui-layout" fit="true">
	<div region="center" border="false" style="padding:10px;background:#fff;border:1px solid #ccc;">
    <form id="form1" method="post">
        <table id="tabwin">
            <tr>
                <td>发件人:</td>
                <td><?php echo $realName;?></td>
            </tr>
            <tr>
                <td>内容:</td>
                <td><?php echo $content;?></td>
            </tr>
            <tr>
                <td>接收时间:</td>
                <td><?php echo $time;?></td>
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