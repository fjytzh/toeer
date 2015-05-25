$(function(){
	$('body').css('visibility', 'visible');
	$('#tt').datagrid({
		title:'日志列表',
		iconCls:'icon-save',
		width:'auto',
		height:fixHeight(),
		striped: true,
		collapsible:true,
		singleSelect:true,
		pageSize:'30',
		url:siteUrl+'solid/log/getLog',
		columns:[[
			{field:'id',title:'id',width:100},
			{field:'realName',title:'姓名',width:220},
			{field:'ctime',title:'登录时间',width:150}
		]],
		pagination:true,
		rownumbers:true
	});
});
