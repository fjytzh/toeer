<body>
<?php 
	if (isset($rs))//编辑 时
	{
		$users			= $rs->users;
		$content		= htmlspecialchars($rs->msg);			
		$time			= $rs->ctime;			
	}
?>
<div class="easyui-layout" fit="true">
	<div region="center" border="false" style="padding:10px;background:#fff;border:1px solid #ccc;">
    <form id="form1" method="post">
        <table id="tabwin">
            <tr>
                <td>收件人:</td>
                <td><?php echo $users;?></td>
            </tr>
            <tr>
                <td>内容:</td>
                <td><?php echo $content;?></td>
            </tr>
            <tr>
                <td>发送时间:</td>
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