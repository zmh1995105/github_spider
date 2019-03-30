<?php
/**
 * @author xiaofeng
 * web shell exec命令兼容处理
 */
class Shell
{
	public function testExec($cmd = 'ps aux | grep aux')
	{
		foreach(['system', 'shell_exec', 'exec', 'passthru', 'proc_open', 'popen'] as $exec)
		{
			echo "\n$exec:\n" . Shell::exec($cmd, $exec) . PHP_EOL;
		}
	}

	/**
	 * 进程列表的简要包装
	 * @param  [type] $grep [description]
	 * @return [type]       [description]
	 */
	public static function ps($grep = null)
	{
		$cmd = (self::isWin() ? "tasklist /V /FO csv" : "ps aux") .
				($grep === null ?
					'' : '| ' . (self::isWin() ? 'findstr' : 'grep') . ' ' . $grep);
		return self::exec($cmd);
	}

	/**
	 * 执行命令
	 * @param  [type] $cmd       [description]
	 * @param  [type] $execFuncs [description]
	 * @return [type]            [description]
	 * @author xiaofeng
	 */
	public static function exec($cmd, $execFuncs = null)
	{
		$cmd = self::htmlEntityDecode($cmd);
		$defaultExecFuncs = ['system', 'shell_exec', 'exec', 'passthru', 'proc_open', 'popen'];
		if($execFuncs === null) {
			$execFuncs = $defaultExecFuncs;
		} else {
			if(!is_array($execFuncs)) {
				$execFuncs = [$execFuncs];
			}
			$execFuncs = array_map('strtolower', $execFuncs);
			$execFuncs = array_intersect($defaultExecFuncs, $execFuncs);
		}

		$output = "";
		$cmd = $cmd." 2>&1";
		if(!$execFuncs || !$cmd) {
			return $output;
		}

		foreach($execFuncs as $exec)
		{
			if(self::isFuncCallable($exec)){
				$func = "_$exec";
				self::$func($cmd, $output);
			}

			// 任何一个命令返回结果则返回
			if(!empty($output)) {
				return $output;
			}
		}

		return $output;
	}

	private static function _system($cmd, &$output)
	{
		ob_start();
		@system($cmd);
		$output = ob_get_clean();
	}

	private static function _shell_exec($cmd, &$output)
	{
		$output .= @shell_exec($cmd);
	}

	private static function _exec($cmd, &$output)
	{
		@exec($cmd,$res);
		if(!empty($res)) {
			$output .= implode("\n", $res);
		}
	}

	private static function _passthru($cmd, &$output)
	{
		ob_start();
		@passthru($cmd);
		$output .= ob_get_clean();
	}

	private static function _proc_open($cmd, &$output, &$error = '')
	{
		$descriptors = [
			0 => ["pipe", "r"], // STDIN
			1 => ["pipe", "w"], // STDOUT
			2 => ["pipe", "w"], // STDERR
		];
		$proc = @proc_open($cmd, $descriptors, $pipes, getcwd(), []);

		if(!is_resource($proc)){
			return false;
		}

		/*
		while($res = fgets($pipes[1])){
			if(!empty($res)){
				$output .= $res;
			}
		}
		while($res = fgets($pipes[2])){
			if(!empty($res)){
				$output .= $res;
			}
		}
		*/

		// STDIN无内容
    	@fclose($pipes[0]);

		$output .= stream_get_contents($pipes[1]);
		fclose($pipes[1]);

		$error .= stream_get_contents($pipes[2]);
		fclose($pipes[2]);

		// proc_close 之前，所有pipe必须先close
		@proc_close($proc);
	}

	private static function _popen($cmd, &$output)
	{
		$res = @popen($cmd, 'r');
		if($res){
			/*
			while(!feof($res)){
				$output .= fread($res, 2096);
			}
			*/
			$output .= stream_get_contents($res);
			@pclose($res);
		}
	}

	public static function isWin(){
		static $isWin = null;
		if($isWin === null) {
			// $isWin = strtolower(substr(PHP_OS, 0, 3)) === 'WIN';
			$isWin = strtolower(substr(php_uname(), 0, 3)) === "win";
		}
		return $isWin;
	}

	private static function isFuncCallable($name)
	{
		return (is_callable($name) && function_exists($name));
	}

	// @see http://php.net/manual/zh/function.html-entity-decode.php#104617
	public static function htmlEntityDecode($cmd) {
		if(function_exists('mb_convert_encoding')) {
			return preg_replace_callback("/(&#[0-9]+;)/", function($m) {
				return mb_convert_encoding($m[1], "UTF-8", "HTML-ENTITIES");
			}, $cmd);
		} else {
			return $cmd;
		}
	}
}
