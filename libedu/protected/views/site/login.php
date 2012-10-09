<div id="password">
<form id="LoginForm" method="post" action="/dev/libedu/index.php?r=site/login">
	<div class="input username">
          <input id="LoginForm_username" name="LoginForm[username]" type="text" placeholder="用户名" />
    </div>
	<div class="input password">
		<input id="LoginForm_password" name="LoginForm[password]" type="password"  placeholder="密码" />
	</div>
	<?php echo CHtml::button('登陆' , array(
			'ajax' => array(
						'url' => 'index.php?r=site/login',
						'type' => "post",
						'success' => 'function(data){
							var res = eval( "(" + data + ")");
							alert( res.status );
							if ( res.status == "success" ) {
								window.location.href = res.returnUrl;
							}
							else {
								
							}
						}', 
					)
			) )?>
	</form>
</div>
