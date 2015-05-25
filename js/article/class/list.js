$(function(){
	$('body').css('visibility', 'visible');
	$('#tt').datagrid({
		title:'文章列表',
		iconCls:'icon-save',
		width:'auto',
		height:fixHeight(),
		striped: true,
		collapsible:true,
		singleSelect:true,
		url:siteUrl+'article/class/getListJson',
		columns:[[
			{field:'article_class_id',title:'ID',width:30},
			{field:'list_order',title:'排序',width:50},
			{field:'fname',title:'分类名称',width:100},
			{field:'fsname',title:'分类简称',width:100}
		]],
		pagination:true,
		rownumbers:true,
		toolbar:[{
			id:'btnadd',
			text:'添加',
			iconCls:'icon-add',
			handler:function(){
				add();
			}
		},'-',{
			id:'btnupd',
			text:'编辑',
			iconCls:'icon-edit',
			handler:function(){
				edit();
			}
		},'-',{
			id:'btndel',
			text:'删除',
			iconCls:'icon-cancel',
			handler:function(){
				del();
			}		
		},'-',{
			id:'btnreset',
			text:'排序',
			iconCls:'icon-redo',
			handler:function(){
				doSort();
			}		
		}]
	});
	$('#tt').datagrid('getPager');
});

function add(){
	$('#w').window({  
	    href:siteUrl+'article/class/add',
	    title:'添加记录'
	}); 
	$('#w').window('open');
}

function edit(){
	var node = $('#tt').datagrid('getSelected');
	if (!node){
		$.messager.alert('系统消息','请选择要编辑的记录');
	}else{
		$('#w').window({  
		    href:siteUrl+'article/class/edit/'+node.id,
		    title:'编辑记录'
		}); 
		$('#w').window('open');
	}
}

function del()
{
	var node = $('#tt').datagrid('getSelected');
	if (!node){
		$.messager.alert('系统消息','请选择要删除的记录');
	}
	else{
		del(node.id,siteUrl+'article/class/del/'+node.id);
	}	
}

function doSort(){
	var node = $('#tt').datagrid('getSelected');
	if (!node){
		$.messager.alert('系统消息','请选择要排序的记录');
	}else{
		$.ajax({
			type:'post',
			data:'id='+node.id,
			url:siteUrl+'article/class/sort',
		    success:function(data){
				data = eval("(" + data + ")");
				$.messager.alert('系统消息',data.msg);
	   		 }		
		});		
	}
}