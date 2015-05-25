<body>
<?php 
	if (isset($row))//编辑 时
	{
		$userName	= $row->userName;
		$allow		= true;		
		$url		= url::site().'solid/user/update/'.$row->id;
		$realName	= $row->realName;
		$gid		= $row->gid;
	}
	else 
	{
		$allow		= false;	
		$url		= url::site().'solid/user/save';
		list($userName,$gid,$realName)	= '';
	}
?>
<div class="easyui-layout" fit="true">
	<div region="center" border="false" style="padding:10px;background:#fff;border:1px solid #ccc;">
	    <form id="form1" method="post">
	        <table id="tabwin">
	            <tr>
	                <td>用户账号:</td>
	                <td><input type="text" value="<?php echo $userName;?>" name="userName" <?php if ($allow) echo 'readonly="readonly"';?> class="easyui-validatebox" required="true"  validType="minLength[2]" /></td>
	            </tr>
	            <?php 
	            	if (!$allow)//编辑时，只编辑用户组
	            	{
	            		echo '<tr>
			                <td>用户密码:</td>
			                <td><input type="password" name="newPasswd" class="easyui-validatebox" required="true"  validType="length[5,10]" /></td>
			            </tr>
			            <tr>
			                <td>确认密码:</td>
			                <td><input type="password" name="confirmPasswd" class="easyui-validatebox" required="true"  validType="eque" /></td>
			            </tr>';
	            	}
	            ?>
	            <tr>
	            	<td>真实姓名:</td>
	            	<td><input type="text" name="realName" value="<?php echo $realName;?>" class="easyui-validatebox" required="true" /></td>	
	            </tr>
	            <tr>
	                <td>所属用户组:</td>
	                <td><input class="easyui-combobox" value="<?php echo $gid;?>" name="gid" url="<?php echo url::site();?>solid/group/getGroup2" valueField="id" textField="groupName" panelHeight="auto"></td>
	            </tr>
	        </table>
	    </form>
	</div>	
	<div region="south" border="false" style="text-align:center;height:40px;">
		<br />
		<a class="easyui-linkbutton" iconCls="icon-ok" href="javascript:void(0)" onclick="return formSubmit('<?php echo $url;?>');">保存</a>&nbsp;<a class="easyui-linkbutton" iconCls="icon-cancel" href="javascript:void(0)" onclick="closeWin('w')">关闭</a>
	</div>	
</div>

</body>