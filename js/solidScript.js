	$.extend($.fn.validatebox.defaults.rules, {
	    eque: {
		    validator: function(value){
		    	return $("input[name=newPasswd]").val() == $("input[name=confirmPasswd]").val();
		    },
		    message:'确认新密码必须与新密码一致'
	    },
	    minLength: {
	        validator: function(value, param){
	            return value.length >= param[0];
	        },
	        message:'至少为{0}个字符.'
	    },
	    qq:{
	    	validator: function (value,param){
	    		return /^[1-9]\d{3,11}$/.test(value);
	    	},
	    	message: 'QQ号码不正确'
	    },
		mobile:{
			validator: function (value,param){
				return /^((\(\d{2,3}\))|(\d{3}\-))?(13|14|15|18)\d{9}$/.test(value);
			},
			message: '手机号码不正确'
		},
		phone:{
			validator: function (value,param){
				return /^((\(\d{2,3}\))|(\d{3}\-))?(\(0\d{2,3}\)|0\d{2,3}-)?[1-9]\d{6,7}(\-\d{1,4})?$/.test(value);
			},
			message: '电话号码不正确'
		},
		number: {
	        validator: function (value, param) {
	            return /^\d+$/.test(value);
	        },
	        message: '请输入数字'
	    },
	    zip: {
	        validator: function (value, param) {
	            return /^[1-9]\d{5}$/.test(value);
	        },
	        message: '邮编输入有误'
	    }
	}); 

	function logout(){
		$.messager.confirm('系统消息',' 您确定要退出吗?',function(r){
			if (r)
			{
				location.href="/solid/admin/logout";
			}
			else
				return false;
		});
	}
	
	function vdata(data){
		var d = eval("("+data+")");
		return d;
	}
	
	function formSubmit(url,formid){
		if (!formid)
			formid = 'form1';
		$('#'+formid).form('submit',{
		    url:url,
		    onSubmit:function(){
		        return $(this).form('validate');
		    },
		    success:function(data){
		    	data = vdata(data);
		    	if (data.success == 1){
		    		location.reload();
		    	}else{
		    		$.messager.alert('系统消息',data.msg);
		    	}
		    }
		});
	}

	function formSubmitBoxClose(url,formid,gridid,boxid){
		if (!formid)
			formid = 'form1';
		$('#'+formid).form('submit',{
		    url:url,
		    onSubmit:function(){
		        return $(this).form('validate');
		    },
		    success:function(data){
		    	data = vdata(data);
		    	if (data.success == 1){
					if (gridid == ''){
		    			location.reload();
					}else {
						closeWin(boxid)
						$('#'+gridid).datagrid('reload');
					}
		    	}else{
		    		$.messager.alert('系统消息',data.msg);
		    	}
		    }
		});
	}

	function del(id,url)
	{
		$.messager.confirm('系统消息','确定删除吗?',function(r){
			if (r){
				$.ajax({
					type:'post',
					data:'id='+id,
					url:url,
					success:function(data){
						data = vdata(data);
						$.messager.alert('系统消息',data.msg,'warning',function(){
							location.reload();	
						});	
					}
				});
			}
			else{
				return false;	
			}		
		});
	}	
	
	function delBoxClose(id,url,gridid,boxid)
	{
		$.messager.confirm('系统消息','确定删除吗?',function(r){
			if (r){
				$.ajax({
					type:'post',
					data:'id='+id,
					url:url,
					success:function(data){
						data = vdata(data);
						$.messager.alert('系统消息',data.msg,'warning',function(){
							closeWin(boxid)
							$('#'+gridid).datagrid('reload');
						});	
					}
				});
			}
			else{
				return false;	
			}		
		});
	}
	
	function closeWin(winName){
		if (!winName)
			winName	= 'w';
		$('#'+winName).window('close');
	}

	
	function fixWidth(percent){
		if (!percent)
			percent = 0.98;
		return $(this).width() * percent;
	}
	
	
	function fixHeight(percent){
		if (!percent)
			percent = 0.98;
		return $(this).height() * percent;
	}

	function doPrint(id_s) { 
		  var ele = document.getElementById(id_s);  
		  var w = window.open('about:blank');
		  w.document.body.innerHTML = ele.innerHTML;
		  
		  var hkey_root,hkey_path,hkey_key
			hkey_root="HKEY_CURRENT_USER"
			hkey_path="\\Software\\Microsoft\\Internet Explorer\\PageSetup\\"
			//设置网页打印的页眉页脚为空
			try{
				var RegWsh = new ActiveXObject("WScript.Shell")
				hkey_key="header" 
				RegWsh.RegWrite(hkey_root+hkey_path+hkey_key,"")
				hkey_key="footer"
				RegWsh.RegWrite(hkey_root+hkey_path+hkey_key,"")
			}catch(e){}
		  
		  w.print();
	}
