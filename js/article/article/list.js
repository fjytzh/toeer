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
		url:siteUrl+'article/article/getListJson',
		columns:[[
			{field:'article_id',title:'ID',width:30},
			{field:'title',title:'标题',width:700},
			{field:'fname',title:'分类',width:100},
			{field:'create_user_id',title:'发布人',width:100},
			{field:'create_time',title:'发布时间',width:100}
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
			text:'置顶',
			iconCls:'icon-redo',
			handler:function(){
				doTop();
			}		
		}]
	});
	$('#tt').datagrid('getPager');
});

function add(){
	$('#w').window({  
	    href:siteUrl+'article/article/add',
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
		    href:siteUrl+'article/article/edit/'+node.id,
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
		del(node.id,siteUrl+'article/article/del/'+node.id);
	}	
}

function doTop(){
	var node = $('#tt').datagrid('getSelected');
	if (!node){
		$.messager.alert('系统消息','请选择要重置的用户');
	}else{
		$.ajax({
			type:'post',
			data:'id='+node.id,
			url:siteUrl+'article/article/top',
		    success:function(data){
				data = eval("(" + data + ")");
				$.messager.alert('系统消息',data.msg);
	   		 }		
		});		
	}
}