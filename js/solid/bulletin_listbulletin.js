$(function(){
	$('body').css('visibility', 'visible');
	$('#tt').datagrid({
		title:'公告列表',
		iconCls:'icon-save',
		width:'auto',
		height:fixHeight(),
		striped: true,
		collapsible:true,
		singleSelect:true,
		url:siteUrl+'solid/bulletin/getBulletin',
		columns:[[
			{field:'id',title:'id',width:50},
			{field:'title',title:'标题',width:300},
			{field:'userName',title:'发布者',width:70},
			{field:'ctime',title:'创建时间',width:100},
			{field:'opt',title:'操作',width:150}
		]],
		pagination:true,
		rownumbers:true,
		toolbar:[{
			id:'btnadd',
			text:'添加',
			iconCls:'icon-add',
			handler:function(){
				addBulletin();
			}
		}]
	});
	$('#tt').datagrid('getPager');
});

function addBulletin(){
	$('#w').window({  
	    href:siteUrl+'solid/bulletin/add?text',
	    title:'添加公告'
	}); 
	$('#w').window('open');
}

function showBulletin(id){
	$('#w').window({
		href:siteUrl+'solid/bulletin/show/'+id,
		title:'公告详情'
	});
	$('#w').window('open');
}

function editBulletin(id){
	$('#w').window({  
	    href:siteUrl+'solid/bulletin/edit/'+id,
	    title:'更新公告'
	}); 
	$('#w').window('open');
}

function delBulletin(id){
	del(id,siteUrl+'solid/bulletin/del');
}
