$(function(){
	$('body').css('visibility', 'visible');
	$('#tt').datagrid({
		title:'用户组列表',
		iconCls:'icon-save',
		width:'auto',
		height:fixHeight(),
		striped: true,
		collapsible:true,
		singleSelect:true,
		url:siteUrl+'solid/group/getGroup',
		columns:[[
			{field:'id',title:'id',width:100},
			{field:'groupName',title:'组名',width:120},
			{field:'ctime',title:'创建时间',width:150},
			{field:'utime',title:'更新时间',width:150},
			{field:'modPower',title:'权限id',width:150}
		]],
		pagination:true,
		rownumbers:true,
		toolbar:[{
			id:'btnadd',
			text:'添加',
			iconCls:'icon-add',
			handler:function(){
				addGroup();
			}
		},'-',{
			id:'btnupd',
			text:'编辑',
			iconCls:'icon-edit',
			handler:function(){
				editGroup();
			}
		}
		,'-',{
			id:'btndel',
			text:'删除',
			iconCls:'icon-cancel',
			handler:function(){
				delGroup();
			}
		}]
	});
	$('#tt').datagrid('getPager');

});

function addGroup(){
	$('#w').window({  
	    href:siteUrl+'solid/group/add?text',
	    title:'添加用户组'
	}); 
	$('#w').window('open');
}

function editGroup(){
	var node = $('#tt').datagrid('getSelected');
	if (!node){
		$.messager.alert('系统消息','请选择要编辑的用户组');
	}else{
		$('#w').window({  
		    href:siteUrl+'solid/group/edit/'+node.id+'?text',
		    title:'更新用户组'
		}); 
		$('#w').window('open');
	}
}

function delGroup(){
	var node = $('#tt').datagrid('getSelected');
	if (!node){
		$.messager.alert('系统消息','请选择要删除的用户组');
	}
	else{
		del(node.id,siteUrl+'solid/group/del/'+node.id);
	}	
}