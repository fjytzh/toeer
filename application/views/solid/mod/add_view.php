<body>
<?php 
	if (isset($row))//编辑 时
	{
		$bid		= $row->bid;
		$modName	= $row->modName;
		$url		= $row->url;
		$app		= $row->app;
		if ($url != '')
		{
			$fcs		= explode('/', $url);
			$class		= isset($fcs[0]) ? $fcs[0]:'';
			$function	= isset($fcs[1]) ? $fcs[1]:'';
		}
		else
		{
			$class		= '';
			$function	= '';
		}
		
		$visible	= $row->visible;
		$url		= url::site().'solid/mod/updateMod/'.$row->id;
	}
	else 
	{
		$url	= url::site().'solid/mod/saveMod';
		list($bid,$modName,$class,$function,$visible) = '';
		$app	= 1;
	}
?>
		<div class="easyui-layout" fit="true">
			<div region="center" border="false" style="padding:10px;background:#fff;border:1px solid #ccc;">
		    <form id="form1" method="post">
		        <table id="tabwin">
		            <tr>
		                <td>上级模块:</td>
		                <td><input id="cc" class="easyui-combotree" url="<?php echo url::site();?>solid/mod/getPreMod" value="<?php echo $bid;?>" style="width:200px;" />&nbsp;未输入表示为顶级模块</td>
		            </tr>
		            <tr>
		                <td>模块名称:</td>
		                <td><input type="text"  class="easyui-validatebox" name="modName"  required="true" value="<?php echo $modName;?>" /></td>
		            </tr>
		            <tr>
		                <td>模块类:</td>
		                <td><input type="text" name="class" class="easyui-validatebox" value="<?php echo $class;?>" /></td>
		            </tr>
		            <tr>
		                <td>模块方法:</td>
		                <td><input type="text" name="function" class="easyui-validatebox"  value="<?php echo $function;?>" /></td>
		            </tr>
		            <tr>
		                <td>是否显示:</td>
		                <td>隐藏:<input type="radio" name="visible" value="0" <?php echo comm::setChecked(0,0,$visible);?> />&nbsp;显示:<input type="radio" name="visible" value="1" <?php echo comm::setChecked(1,1,$visible);?> /></td>
		            </tr>
		            <tr>
		                <td>所属项目:</td>
		                <td><input class="easyui-combobox" value="<?php echo $app;?>" name="app" url="<?php echo url::site();?>solid/app/getAllApp" valueField="id" textField="name" panelHeight="auto"></td>
		            </tr>
		        </table>
		        <input type="hidden" name="cvalue" id="cvalue" value="" />
		    </form>		
			</div>
			<div region="south" border="false" style="text-align:center;height:40px;">
				<br />
				<a class="easyui-linkbutton" iconCls="icon-ok" href="javascript:void(0)" onclick="return saveForm();">保存</a>&nbsp;<a class="easyui-linkbutton" iconCls="icon-cancel" href="javascript:void(0)" onclick="closeWin('w')">关闭</a>
			</div>
		</div>

<script type="text/javascript">
	function saveForm(){
		$('#form1').form('submit',{
		    url:"<?php echo $url;?>",
		    onSubmit:function(){
				var val = $('#cc').combotree('getValue');
				if (val<1)
					val=0;
		    	$('#cvalue').val(val);
		        return $(this).form('validate');
		    },
		    success:function(data){
		    	data = vdata(data);
		    	if (data.success==1){
					location.reload();
			    }else{
			    	$.messager.alert('系统消息',data.msg);
				}
		    }
		});
	}
	
</script>
</body>