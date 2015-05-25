<body class="easyui-layout" style="visibility:hidden">
	<div region="north" border="false" style="background:url(<?php echo url::imgUrl();?>solid/topBg.gif) repeat-x; background-color:#DFE8F6; line-height:39px; height:39px;">
		<div id="topText">欢迎使用统一管理平台</div>
		<ul class="topUl">
			<li class="topRight"></li>
			<li class="topMiddle"><a href="#" class="c" onclick="return logout()">退出登录</a></li>	
			<?php 
				$powers		= comm::getPowers();
				foreach ($top as $t)
				{
					if (in_array($t->id,$powers))
						echo '<li class="topMiddle"><a href="'.url::site().'solid/member/index/'.$t->id.'" class="c">'.$t->modName.'</a></li>';
				}
			?>			
			<li class="topLeft">

			</li>
		</ul>
	</div>
	<div region="west" split="true" title="功能列表" style="width:180px;padding:10px;" name="west">
		<div id="tt"></div>
	</div>
	<div region="center" title="主窗体">
		<div class="easyui-tabs" fit="true" border="false" id="ut">
			<div title="我的桌面" style="overflow:hidden;"> 
				<div style="margin:20px;">
					<h4>下一版本改进计划:</h4>
					1、完善帮助文档<br /><br />
					3、系统模块缓存优化<br /><br />
					4、系统模块排序<br /><br />
					(金霖方)
				</div>
			</div>
		</div>
	</div>
	<div region="south" class="panel" style="background:#E0ECFF; padding:3px; color:#999">欢迎你，<?php echo $_SESSION['realName'];?>。 用户名：<?php echo $_SESSION['userName'];?></div>
	<script type="text/javascript">
		$(function(){
			$('body').css('visibility', 'visible');
			$('#tt').tree({
				url: '<?php echo url::site().'solid/member/left/'.$seg;?>',
				onClick:function(node){
					$(this).tree('toggle', node.target);
					var b = $('#tt2').tree('isLeaf', node.target);
					if (b == true){
						var t	=$('#ut').tabs('getTab','我的桌面');
						var title	= node.text;
						if ($('#ut').tabs('exists', title)){  
					        $('#ut').tabs('select', title);  
					    } else { 
							var content = '<iframe id="contentTab" scrolling="auto" frameborder="0"  src="'+node.attributes.url+'" style="width:100%;height:100%;"></iframe>';
					        $('#ut').tabs('add',{  
					            title:title,  
					            content:content,  
					            closable:true  
					        }); 						
					    }
						//alert('you dbclick '+node.text);
					}
				}
			});
		});
		
	</script>
	</body>


