<div id="password">
<form id="LoginForm" method="post" action="/dev/libedu/index.php?r=site/login">
	<div class="input username">
          <input id="LoginForm_username" name="LoginForm[username]" type="text" placeholder="用户名" />
    </div>
	<div class="input password">
		<input id="LoginForm_password" name="LoginForm[password]" type="password"  placeholder="密码" />
	</div>
	<?php 
	echo CHtml::htmlButton('登陆' , array(
				'ajax' => array(
						'url' => 'index.php?r=site/login',
						'type' => "post",
						'success' => 'function(data){
							var res = eval( "(" + data + ")");
							if ( res.status == "success" ) {
								window.location.href = res.returnUrl;
							}
							else {
								$.notification( 
									{
										title: "错误的用户名或者密码",
										content: "请检查您的用户名和密码，尝试再次登陆",
										icon: "!"
									}
								);
								
							}
						}', 
					)
			) )?>
			<span class="checkbox grey">
				<label>
					<input type="checkbox" class="grey"  name="LoginForm[rememberMe]" onchange='$(this).parents("span").toggleClass("checked");'> 
						<span class="on">开</span>
						<span class="toggle"></span>
						<span class="off">关</span>
				</label>
			</span>
			
			<label>记住我</label>
	</form>
</div>
