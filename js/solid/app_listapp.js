$(function(){
	$('body').css('visibility', 'visible');
	$('#tt').datagrid({
		title:'项目列表',
		iconCls:'icon-save',
		width:'auto',
		height:fixHeight(),
		striped: true,
		collapsible:true,
		singleSelect:true,
		url:siteUrl+'solid/app/getApp',
		columns:[[
			{field:'id',title:'id',width:100},
			{field:'name',title:'项目名称',width:120},
			{field:'path',title:'相对路径',width:150},
			{field:'ctime',title:'创建时间',width:150}
		]],
		pagination:true,
		rownumbers:true,
		toolbar:[{
			id:'btnadd',
			text:'添加',
			iconCls:'icon-add',
			handler:function(){
				addApp();
			}
		},'-',{
			id:'btnupd',
			text:'编辑',
			iconCls:'icon-edit',
			handler:function(){
				editApp();
			}
		}
		,'-',{
			id:'btndel',
			text:'删除',
			iconCls:'icon-cancel',
			handler:function(){
				delApp();
			}
		}]
	});
	$('#tt').datagrid('getPager');
});

function addApp(){
	$('#w').window({  
	    href:siteUrl+'solid/app/add',
	    title:'添加项目'
	}); 
	$('#w').window('open');
}

function editApp(){
	var node = $('#tt').datagrid('getSelected');
	if (!node){
		$.messager.alert('系统消息','请选择要编辑的项目');
	}else{
		$('#w').window({  
		    href:siteUrl+'solid/app/edit/'+node.id,
		    title:'更新项目'
		}); 
		$('#w').window('open');
	}
}

function delApp(){
	var node = $('#tt').datagrid('getSelected');
	if (!node){
		$.messager.alert('系统消息','请选择要删除的项目');
	}
	else{
		del(node.id,siteUrl+'solid/app/del/'+node.id);
	}		
}
