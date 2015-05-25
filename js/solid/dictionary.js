/*!
 * easyui JS Library 1.2.4
 * Copyright(c) 2011 fangke Inc.
 * 吴家庚 63857991@qq.com
 */
$(function(){
	$('body').css('visibility', 'visible');
	$('#tt').datagrid({
		title:'字典列表',
		iconCls:'icon-save',
		width:'auto',
		height:fixHeight(0.98),
		pageSize:30,
		striped: true,
		collapsible:true,
		singleSelect:true,
		url:siteUrl+'solid/dictionary/getDictionaryDirJson',
		columns:[[
			{field:'id',title:'ID',width:100},
			{field:'name',title:'字典名称',width:200},
			{field:'showdictionarylist',title:'字典项',width:100,align:"center"}
		]],
		pagination:true,
		rownumbers:true,
		toolbar:[{
			id:'btnadd',
			text:'添加',
			iconCls:'icon-add',
			handler:function(){
				showAddDictionaryDirBox();
			}
		},'-',{
			id:'btnupd',
			text:'编辑',
			iconCls:'icon-edit',
			handler:function(){
				showEditDictionaryDirBox();
			}
		},'-',{
			id:'btndel',
			text:'删除',
			iconCls:'icon-cancel',
			handler:function(){
				delDictionaryDir();
			}	
		}]
	});
});

function showAddDictionaryDirBox(){
	$('#DictionaryDirBox').window({  
	    href:siteUrl+'solid/dictionary/addDictionaryDir?text',
	    title:'添加字典'
	}); 
	$('#DictionaryDirBox').window('open');
}

function showEditDictionaryDirBox(){
	var node = $('#tt').datagrid('getSelected');
	if (!node){
		$.messager.alert('系统消息','请选择要编辑的字典');
	}else{
		$('#DictionaryDirBox').window({  
		    href:siteUrl+'solid/dictionary/editDictionaryDir/'+node.id+'?text',
		    title:'更新字典'
		}); 
		$('#DictionaryDirBox').window('open');
	}
}

function delDictionaryDir()
{
	var node = $('#tt').datagrid('getSelected');
	if (!node){
		$.messager.alert('系统消息','请选择要删除的字典');
	}
	else{
		del(node.dicId,siteUrl+'solid/dictionary/delDictionaryDir/'+node.id);
	}	
}

function showDictionaryListBox(dicId, name){
	$('#DictionaryListBox').window({
	    title:"【"+name+'】--字典管理'
	}); 
	$('#DictionaryListBox').window('open');
	$('#dl').datagrid({
		iconCls:'icon-save',
		fit:true,
		striped: true,
		collapsible:true,
		singleSelect:true,
		url:siteUrl+'solid/dictionary/getDictionaryJson/'+dicId,
		columns:[[
			{field:'id',title:'ID',width:100},
			{field:'name',title:'字典名称',width:100},
			{field:'itemValue',title:'值',width:100},
			{field:'orderNum',title:'排序',width:100,align:"center"}
		]],
		pagination:true,
		rownumbers:true,
		toolbar:[{
			id:'btnadd',
			text:'添加',
			iconCls:'icon-add',
			handler:function(){
				showAddDictionaryBox(dicId);
			}
		},'-',{
			id:'btnupd',
			text:'编辑',
			iconCls:'icon-edit',
			handler:function(){
				showEditDictionaryBox(dicId);
			}
		},'-',{
			id:'btndel',
			text:'删除',
			iconCls:'icon-cancel',
			handler:function(){
				delDictionary(dicId);
			}	
		}]
	});
}

function showAddDictionaryBox(dicId){
	$('#DictionaryBox').window({  
	    href:siteUrl+'solid/dictionary/addDictionary/'+dicId+'?text',
	    title:'添加字典项'
	}); 
	$('#DictionaryBox').window('open');
}

function showEditDictionaryBox(dicId){
	var node = $('#dl').datagrid('getSelected');
	if (!node){
		$.messager.alert('系统消息','请选择要编辑的字典项');
	}else{
		$('#DictionaryBox').window({  
		    href:siteUrl+'solid/dictionary/editDictionary/'+dicId+'/'+node.id+'?text',
		    title:'更新字典项'
		}); 
		$('#DictionaryBox').window('open');
	}
}

function delDictionary(dicId)
{
	var node = $('#dl').datagrid('getSelected');
	if (!node){
		$.messager.alert('系统消息','请选择要删除的字典项');
	}
	else{
		delBoxClose(node.di_id,siteUrl+'solid/dictionary/delDictionary/'+dicId+'/'+node.id, 'dl', 'DictionaryBox');
	}	
}