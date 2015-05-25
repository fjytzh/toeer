$(function(){
	$('body').css('visibility', 'visible');
	$('#tt').datagrid({
		title:'我的发件箱',
		iconCls:'icon-save',
		width:'auto',
		height:fixHeight(),
		striped: true,
		collapsible:true,
		singleSelect:true,
		url:siteUrl+'solid/outbox/getOutbox',
		columns:[[
			{field:'id',title:'id',width:50},
			{field:'msg',title:'发送内容',width:450},
			{field:'users',title:'发送对象',width:170},
			{field:'ctime',title:'发送时间',width:100}
		]],
		pagination:true,
		rownumbers:true,
		toolbar:[{
			id:'btnadd',
			text:'发送',
			iconCls:'icon-add',
			handler:function(){
				sendMsg();
			}
		},'-',{
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

function sendMsg(){
	$('#w').window({
		href:siteUrl+'solid/outbox/add',
		title:'发送信息'
	});
	$('#w').window('open');
}


function showMsg(){
	var node = $('#tt').datagrid('getSelected');
	if (!node){
		$.messager.alert('系统消息','请选择要查看的项目');	
	}else{
		$('#w').window({
			href:siteUrl+'solid/outbox/show/'+node.id,
			title:'发送信息'
		});
		$('#w').window('open');		
	}
}

function delMsg(){
	var node = $('#tt').datagrid('getSelected');
	if (!node){
		$.messager.alert('系统消息','请选择要删除的项目');
	}
	else{
		del(node.id,siteUrl+'solid/outbox/del/'+node.id);
	}	
}

function doSubmit(url,name){
	formSubmit(url);
}