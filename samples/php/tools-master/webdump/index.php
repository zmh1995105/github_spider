<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {

	require __DIR__."/config.php";
	
	$content = file_get_contents("php://input");
	if (is_string($content)) {
	
		$dump_filename = time().".json";
		$filename = "{$dump_dirname}/{$dump_filename}";
		
		$return = file_put_contents($filename, $content);
		if (is_int($return)) {
			exit(0);
			
		} else user_error("can't save POST data to file: {$filname}");
	} else user_error("can't get POST content");
	die;
}
