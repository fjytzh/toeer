$(function(){
	$('body').css('visibility', 'visible');
	$('#tt').datagrid({
		title:'用户列表',
		iconCls:'icon-save',
		width:'auto',
		height:fixHeight(),
		striped: true,
		collapsible:true,
		singleSelect:true,
		url:siteUrl+'solid/user/getUser',
		columns:[[
			{field:'id',title:'id',width:100},
			{field:'userName',title:'用户账号',width:120},
			{field:'realName',title:'真实姓名',width:110},
			{field:'ctime',title:'创建时间',width:150},
			{field:'groupName',title:'所属分组',width:150}
		]],
		pagination:true,
		rownumbers:true,
		toolbar:[{
			id:'btnadd',
			text:'添加',
			iconCls:'icon-add',
			handler:function(){
				showBox();
			}
		},'-',{
			id:'btnupd',
			text:'编辑',
			iconCls:'icon-edit',
			handler:function(){
				editUser();
			}
		},'-',{
			id:'btndel',
			text:'删除',
			iconCls:'icon-cancel',
			handler:function(){
				delUser();
			}		
		},'-',{
			id:'btnreset',
			text:'密码重置',
			iconCls:'icon-redo',
			handler:function(){
				resetUser();
			}		
		}]
	});
	$('#tt').datagrid('getPager');
});

function showBox(){
	$('#w').window({  
	    href:siteUrl+'solid/user/add?text',
	    title:'添加用户'
	}); 
	$('#w').window('open');
}

function editUser(){
	var node = $('#tt').datagrid('getSelected');
	if (!node){
		$.messager.alert('系统消息','请选择要编辑的用户');
	}else{
		$('#w').window({  
		    href:siteUrl+'solid/user/edit/'+node.id+'?text',
		    title:'更新用户'
		}); 
		$('#w').window('open');
	}
}

function resetUser(){
	var node = $('#tt').datagrid('getSelected');
	if (!node){
		$.messager.alert('系统消息','请选择要重置的用户');
	}else{
		$.ajax({
			type:'post',
			data:'id='+node.id,
			url:siteUrl+'solid/user/restPwd',
		    success:function(data){
				data = eval("(" + data + ")");
				$.messager.alert('系统消息',data.msg);
	   		 }		
		});		
	}
}

function delUser()
{
	var node = $('#tt').datagrid('getSelected');
	if (!node){
		$.messager.alert('系统消息','请选择要删除的用户');
	}
	else{
		del(node.id,siteUrl+'solid/user/del/'+node.id);
	}	
}