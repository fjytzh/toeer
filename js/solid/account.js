$(function(){
	$('body').css('visibility', 'visible');	
});

function updatePwd(){
	$('#form1').form('submit',{
	    url:siteUrl+'solid/account/setPwd',
	    onSubmit:function(){
	        return $(this).form('validate');
	    },
	    success:function(data){
	    	data = vdata(data);
	    	$.messager.alert('系统消息',data.msg);
	    }
	});
}	