<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Gu-Login</title>
    <link rel="stylesheet" href="/Public/css/library/sweetalert.css">
    <link rel="stylesheet" href="/Public/css/branch/login.css">
</head>
<body>
    <div class="page-container">
        <div class="form">
            <input type="text" name="email" placeholder="请输入电子邮箱" id="email" autocomplete="off">
			<br>
            <input type="password" name="password" placeholder="请输入用户密码" id="password" autocomplete="off">
			<br>
			<button>用户登陆</button>
        </div>
    </div>
</body>
<script type="text/javascript" src="/Public/js/library/jquery.js"></script>
<script type="text/javascript" src="/Public/js/library/sweetalert.js"></script>
<script type="text/javascript">
	$("button").click(function(){
		var user_email = $("#email");
		var user_password = $("#password");
		if(user_email.val() == "" || user_password.val() == ""){
			swal("Error", "请确认账号密码不为空", "error");
			return false;
		}
		$.ajax({
			url: '/Api/checkLogin',
			type: 'post',
			dataType: 'json',
			data: {email: user_email.val(),password:user_password.val()},
		})
		.done(function(data){
			if(data.type == "error"){
				swal("Error", "账号或密码错误", "error");
				return false;
			}
			window.location.href = "/Main/index";
		})
		.fail(function(data){
			console.log(data)
		})
	})
</script>
</html>
