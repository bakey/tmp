<div id="password">
<form id="LoginForm" method="post" action="/dev/libedu/index.php?r=site/login">
	<div class="input username">
          <input id="LoginForm_username" name="LoginForm[username]" type="text" placeholder="用户名" />
    </div>
	<div class="input password">
		<input id="LoginForm_password" name="LoginForm[password]" type="password"  placeholder="密码" />
	</div>
	<button>登陆</button>
	<?php /*echo CHtml::button('登陆')*/?>
	</form>
</div>
