$(function(){
	$('body').css('visibility', 'visible');
	$('#tt').datagrid({
		title:'我的收件箱',
		iconCls:'icon-save',
		width:'auto',
		height:fixHeight(),
		striped: true,
		collapsible:true,
		singleSelect:true,
		url:siteUrl+'solid/inbox/getInbox',
		columns:[[
			{field:'id',title:'id',width:50},
			{field:'msg',title:'发送内容',width:450},
			{field:'realName',title:'发送者',width:70},
			{field:'ctime',title:'对方发送时间',width:100}
		]],
		pagination:true,
		rownumbers:true,
		toolbar:[{
			id:'btnshow',
			text:'查看',
			iconCls:'icon-reload',
			handler:function(){
				showMsg();
			}
		},'-',{
			id:'btndel',
			text:'删除',
			iconCls:'icon-cancel',
			handler:function(){
				delMsg();
			}
		}]
	});
	$('#tt').datagrid('getPager');
});

function showMsg(){
	var node = $('#tt').datagrid('getSelected');
	if (!node){
		$.messager.alert('系统消息','请选择要查看的项目');	
	}else{
		$('#w').window({
			href:siteUrl+'solid/inbox/show/'+node.id,
			title:'消息详情'
		});
		$('#w').window('open');
	}
}

function delMsg(id){
	var node = $('#tt').datagrid('getSelected');
	if (!node){
		$.messager.alert('系统消息','请选择要删除的项目');	
	}else{
		del(node.id,siteUrl+'solid/inbox/del');
	}
}