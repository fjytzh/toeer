$(function(){
	$('body').css('visibility', 'visible');
	$('#tt').treegrid({
		title:'全部模块',
		iconCls:'icon-ok',
		width:500,
		height:550,
		rownumbers: true,
		animate:true,
		collapsible:true,
		fitColumns:true,
		url:siteUrl+'solid/mod/getModTree',
		idField:'id',
		treeField:'text',
		columns:[[
            {title:'模块名称',field:'text',width:180}
		]],
		toolbar:[{
			id:'btnadd',
			text:'添加',
			iconCls:'icon-add',
			handler:function(){
				showBox('w');
			}
		},'-',{
			id:'btnupd',
			text:'编辑',
			iconCls:'icon-edit',
			handler:function(){
				updateNote();
			}
		},'-',{
			id:'btndel',
			text:'删除',
			iconCls:'icon-cancel',
			handler:function(){
				delNote();
			}
		}]
	});
});


function showBox(){
	$('#w').window({  
	    href:siteUrl+'solid/mod/add?text',
	    title:'添加模块'
	}); 	
	$('#w').window('open');
}	


function delNote(){
	var node = $('#tt').treegrid('getSelected');
	if (!node){
		$.messager.alert('系统消息','请选择要删除的模块');
		return false;
	}
	$.messager.confirm('系统消息', '确定删除吗？', function(r){
		if (r){
			$.ajax({
				type:'post',
				data:'nid='+node.id,
				url:siteUrl+'solid/mod/delMod',
			    success:function(data){
					data = eval("(" + data + ")");
					$.messager.alert('系统消息',data.msg);
			    	if (data.success==1){
			    		location.reload();
			    	}
		   		 }		
			});

		}
	});
}


function updateNote(){
	var node = $('#tt').treegrid('getSelected');
	if (!node){
		$.messager.alert('系统消息','请选择要编辑的模块');
	}else{
		$('#w').window({  
		    href:siteUrl+'solid/mod/edit/'+node.id+'?text',
		    title:'更新模块'
		}); 
		$('#w').window('open');
	}

}