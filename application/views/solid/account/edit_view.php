 <body style="visibility:hidden">

<div id="p" class="easyui-panel" title="密码修改" style="width:280px;height:180px;padding:10px;background:#fafafa;"  
        iconCls="icon-edit"  
        collapsible="true" minimizable="true" maximizable=true>  
    <form id="form1" method="post">
        <table id="tabwin">
            <tr>
                <td>原密码:</td>
                <td><input type="password"  class="easyui-validatebox" name="oldPasswd"  required="true" /></td>
            </tr>
            <tr>
                <td>新密码:</td>
                <td><input type="password" name="newPasswd" class="easyui-validatebox" required="true"  validType="length[5,10]" /></td>
            </tr>
            <tr>
                <td>确认新密码:</td>
                <td><input type="password" name="confirmPasswd" class="easyui-validatebox" required="true"  validType="eque" /></td>
            </tr>
            <tr>
                <td></td>
                <td><a class="easyui-linkbutton" iconCls="icon-ok" href="javascript:void(0)" onclick="updatePwd()">提交</a></td>
            </tr>
        </table>
    </form>
</div>
</body>
