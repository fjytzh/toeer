<body>
<?php 
	if (isset($row))//编辑 时
	{
		$modName	= $row->groupName;
		$gid		= $row->id;	
		$url		= url::site().'solid/group/update/'.$row->id;
	}
	else 
	{
		$modName	= '';
		$gid		= 0;	
		$url		= url::site().'solid/group/save';
	}
?>
<div class="easyui-layout" fit="true">
	<div region="center" border="false" style="padding:10px;background:#fff;border:1px solid #ccc;">
    <form id="form1" method="post">
        <table>
            <tr height="30">
                <td>用户组名:</td>
                <td><input type="text"  class="easyui-validatebox" id="groupName" name="groupName" style="width:320px" value="<?php echo $modName;?>" required="true" /></td>
            </tr>
        </table>
        <div style="height:340px; width:400px;overflow:auto">
        <table>            
        	<tr>
                <td valign="top">权限列表:</td>
                <td id="tt2" style="padding:5px;border:1px solid #ccc; width:300px;"></td>
            </tr>
        </table>
        </div>
    </form>
 	<div region="south" border="false" style="text-align:center;height:40px;">
		<br />
		<a class="easyui-linkbutton" iconCls="icon-ok" href="javascript:void(0)" onclick="return submitForm('<?php echo $url;?>');">保存</a>&nbsp;<a class="easyui-linkbutton" iconCls="icon-cancel" href="javascript:void(0)" onclick="closeWin('w')">关闭</a>
	</div>	   
	</div>	
</div>
<script type="text/javascript">
$(function(){
	$('#tt2').tree({
		url: '<?php echo url::site();?>solid/mod/getParentMod/<?php echo $gid;?>',
		checkbox:true,
		height:200,
		onClick:function(node){
			$(this).tree('toggle', node.target);
		}
	});
	
});

function submitForm()
{
	var nodes = $('#tt2').tree('getChecked');
	var s = '';
	var b = '';
	for(var i=0; i<nodes.length; i++){
		if (s != '') s += ',';
		if (b != '') b += ',';
		s += nodes[i].id;
		b += nodes[i].attributes.bid;
	}
	$.ajax({
		type:'post',
		data:'groupName='+$('#groupName').val()+'&modPower='+s+'&modPrePower='+b,
		url:'<?php echo $url;?>',
		success:function(data){
			data = vdata(data);
			if (data.success ==1){
				location.reload();
			}else{
				$.messager.alert('系统消息',data.msg);
			}
		}	
	});
		

}
</script>
</body>