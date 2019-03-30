<?php session_start();
//Server Enviroment Terminal
// COPYRIGHT © 2018 Paitorocxon (Fabian Müller)
//  VERSION 1.0.0
$VERSION = 'SET 1.0.0<br>Server Enviroment Terminal © 2018 Fabian Müller (Paitorocxon)';
function Error_Handler($error_number,$error_string,$error_file,$error_line){
    $cache = '<b><font color="#F00">!--[SERVER] ERROR ' . $error_number . $error_number . "<br>" . "#####" . $error_string .  "#####" . "<br>" . $error_file . $error_line . ' !--</font></b>';
}
set_error_handler("Error_Handler");

Zeroday:

$cache = '';
if (isset($_SESSION['content'])){
} else {
}
$lastcommand = $_REQUEST['last'];
if(isset($_REQUEST['command'])){
    
    $full_command = explode(" ", $_REQUEST['command']);
    if (isset($_SESSION['lastcommand'])) {
        $command = str_replace('!!', $_SESSION['lastcommand'],$full_command);        
    }else{
        $command = $full_command;   
    }
    if(isset($command[0])){
        if($command[0]=="ls"){
            if(isset($command[1])){
                /*if(strpos($command[1],"..")){
                    die("Illegal charackters! (..)");
                }*/
            $files = scandir(realpath(dirname(__FILE__)) . $command[1]);   
            }else{
            $files = scandir(realpath(dirname(__FILE__)));                
            }
            $count = 0;
            $cache = $cache . "<br>";
            $xfolders = array();
            $xfiles = array();
            foreach ($files as $file){
                $count++;
                if(is_dir($file)){
                array_push($xfolders,'/' .$file);
                }else{
                array_push($xfiles,'&nbsp;' . $file);
                }
            }
            foreach ($xfolders as $folder) {
                $cache = $cache . '<br><font color="#FF0">' . $folder . '</font>';
            }
            foreach ($xfiles as $file) {
                $cache = $cache . '<br>' . $file;
            }
            $cache = $cache . "<br><br>" . "[" . $count . "] Files in "; 
        }elseif($command[0]=="mkdir"){
            if(isset($command[1])){
                /*if(strpos($command[1],"..")){
                    die("Illegal charackters! (..)");
                }*/
                mkdir($command[1]); 
                $cache = $cache . "Created " . $command[1];      
            }else{        
                $cache = $cache . "Not created " . $command[1];            
            }
              

        }elseif($command[0]=="del"){
            if(isset($command[1])){
                if(strpos($command[1],"..")){
                    die("Illegal charackters! (..)");
                }elseif($command[1]="pse.php"){
                    die("Illegal charackters! (..)");
                }
                unlink( $command[1]); 
                $cache = $cache . "Erased " . $command[1];      
            }else{        
                $cache = $cache . "Error!" . $command[1];            
            }  
        }elseif($command[0]=="reset"){
            session_destroy();
            $cache = '';
        }elseif($command[0]=="clear"){
            $_SESSION['content'] = '';
        }elseif($command[0]=="rmdir"){
            if(isset($command[1])){
                /*if(strpos($command[1],"..")){
                    die("Illegal charackters! (..)");
                }*/
                $files = glob('path/to/temp/{,.}*', GLOB_BRACE);
                foreach($files as $file){ 
                  if(is_file($file)){
                    unlink($file);
                  }
                }
                try{
                    rmdir($command[1]);
                } catch (Exception $ex){
                    $cache = $cache .  $ex;
                }
                $cache = $cache . "Erased " . $command[1];      
            }else{        
                $cache = $cache . "Error!" . $command[1];            
            } 
        }elseif($command[0]=="upload"){
            if(isset($command[1])){
                $myfile = fopen($command[1], "w") or die("Cannot create file");
                $txt = base64_decode($command[2]);
                fwrite($myfile, $txt);
                fclose($myfile);
            }
               
        }elseif($command[0]=="version"){
               $cache = $VERSION;
        }elseif($command[0]=="rm"){
            if(isset($command[1])){
                /*if(strpos($command[1],"..")){
                    die("Illegal charackters! (..)");
                }*/
                if( file_exists($command[1])){
                  if(is_file($command[1])){
                    unlink($command[1]);
                  }
                }
                $cache = $cache . "Erased " . $command[1];      
            }else{        
                $cache = $cache . "Error!" . $command[1];            
            } 
        }elseif($command[0]=="rmuser"){
            if(isset($command[1])){
         
                if( file_exists('userfiles/' . $command[1])){
                  if(is_file('userfiles/' . $command[1])){
                    unlink('userfiles/' . $command[1]);
                  }
                }
                $cache = $cache . "Erased " . $command[1];      
            }else{        
                $cache = $cache . "Error!" . $command[1];            
            }
        }elseif($command[0]=="read"){
            if(isset($command[1])){
                
                /*if(strpos($command[1],"..")){
                    die("Illegal charackters! (..)");
                }*/
                if(file_exists($command[1])){
                    $cache = '<b>[' . $command[1] . ']</b><br>' . htmlspecialchars(file_get_contents($command[1]));
                }   
            }else{        
                $cache = $cache . "Error! No such file or directory!" . $command[1];            
            }   
        }elseif($command[0]=="cat"){
            if(isset($command[1])){
                
                /*if(strpos($command[1],"..")){
                    die("Illegal charackters! (..)");
                }*/
                if(file_exists($command[1])){
                    $cache = '<b>[' . $command[1] . ']</b><br>' . htmlspecialchars(file_get_contents($command[1]));
                }   
            }else{        
                $cache = $cache . "Error! No such file or directory!" . $command[1];            
            }   
        }elseif($command[0]=="createuser"){
            if(isset($command[1]) && isset($command[2])){
                /*if(strpos($command[1],"..")){
                    die("Illegal charackters! (..)");
                }*/
                if(file_exists("userfiles/" . $command[1])){
                    die("User exists already");
                }else{
                    $myfile = fopen("userfiles/" . $command[1], "w") or die("Cannot create user");
                    $txt = base64_encode(base64_encode(base64_encode($command[2])));
                    fwrite($myfile, $txt);
                    fclose($myfile);
                    $cache = $cache . "User " . $command[1] . "sucessfully created!";
                }   
            }else{        
                $cache = $cache . "Error! No such file or directory!" . $command[1];            
            }
        }elseif($command[0]=="touch"){
            if(isset($command[1])){
                /*if(strpos($command[1],"..")){
                    die("Illegal charackters! (..)");
                }*/
                if(file_exists($command[1])){
                    die("User exists already");
                }else{
                    $myfile = fopen($command[1], "w") or die("Cannot create file");
                    $txt = "";
                    foreach($command as $cont) {
                        if ($cont == $command[0] OR $cont == $command[1]){
                         
                        } else {
                            
                        $txt = $txt . " " . $cont;
                        }
                    }
                    fwrite($myfile, $txt);
                    fclose($myfile);
                }   
            }else{        
                $cache = $cache . "Error! No such file or directory!" . $command[1];            
            }
            


        }elseif($command[0]=="clone"){
            if(isset($command[1])){
                if(file_exists($command[1])){
                    if(!copy($command[1], $command[2])){
                        die('ERROR WHILE CLONE!');
                    }else{
                        die('Done!');
                    }
                }   
            }else{        
                $cache = $cache . "Error! No such file or directory!" . $command[1];            
            }
            
            
        }elseif($command[0]=="readall"){
            if(isset($command[1])){
                /*if(strpos($command[1],"..")){
                    die("Illegal charackters! (..)");
                }*/
                $files = glob('path/to/temp/{,.}*', GLOB_BRACE);
                foreach($files as $file){
                                $cache = $cache .  "FILE:" . $file . "<br>";                
                  if(is_file($file)){
                    $cache = $cache . file_get_contents($file) . "<br>" . "##########################";
                  }
                }     
            }else{        
                $cache = $cache . "Error!" . $command[1];            
            }
            die("END");  
        }elseif($command[0]=="sql"){
            
            
            
            define("DB_SERVER", $command[1]);
            define("DB_USER", $command[2]);
            define("DB_PASSWORD", $command[3]);
            define("DB_DATABASE", $command[4]);
            $connect = mysqli_connect(DB_SERVER , DB_USER, DB_PASSWORD, DB_DATABASE);
            $servername = $command[1];
            $uname = $command[2];
            $password = $command[3];
            $dbname = $command[4];
            $command5 = $command[5];
            //$cache = $cache . $servername . "<br>" . $username . "<br>" . $password . "<br>" . $dbname . "<br>";
            $conn = new mysqli($servername, $uname, $password, $dbname);
            if ($conn->connect_error) {
                $cache = ("Connection failure: " . $conn->connect_error);
            }
            $stringlength = strlen($servername) + strlen($uname) + strlen($password) + strlen($dbname) + strlen($command5) +2;
            $cache = $cache . $stringlength . $_REQUEST['command'];
            $sql = substr($_REQUEST['command'], $stringlength,80);
            $cache = $cache . $servername . "@" . $uname . ":" . $sql . "<br>" . "'" . $password . "'";
            $result = $conn->query($sql);
            $cache = $cache . substr($_REQUEST['command'], $stringlength,80);
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    foreach ($row as $rawrow){
                        $cache = $cache . $rawrow . "<br>";
                    }
                }
            } else {
            }
            
            $conn->close();
        }elseif($command[0]=="help"){
            $cache = $cache . '<br><table>';
            $cache = $cache . '<tr><td>ls [/FOLDERNAME]                              </td><td>List all files in folder</td>' . '</tr>';
            $cache = $cache . '<tr><td>mkdir FOLDERNAME                              </td><td>Creates a new directory</td>' . '</tr>';
            $cache = $cache . '<tr><td>rmdir FOLDERNAME                              </td><td>Deletes a directory</td>' . '</tr>';
            $cache = $cache . '<tr><td>del FILENAME                                  </td><td>Deletes a file</td>' . '</tr>';
            $cache = $cache . '<tr><td>touch FILENAME [content]                      </td><td>Create new file</td>' . '</tr>';
            $cache = $cache . '<tr><td>read FILENAME [content]                       </td><td>Read a file</td>' . '</tr>';
            $cache = $cache . '<tr><td>sql HOST USER PASSWORD DATABASE COMMAND       </td><td>Run SQL command</td>' . '</tr>';
            $cache = $cache . '<tr><td>rm FILENAME                                   </td><td>Delete a file</td>' . '</tr>';
            $cache = $cache . '<tr><td>clone FILENAME FILENAME                       </td><td>copy a file</td>' . '</tr>';
            $cache = $cache . '<tr><td>reset                                         </td><td>Reset the Terminal</td>' . '</tr>';
            $cache = $cache . '<tr><td>rmuser USERNAME                               </td><td>Delete a user</td>' . '</tr>';
            $cache = $cache . '</table>';
                        
        }else{
            if ((string)$command == 'Array') {
            }else{
                $cache = '<b><font color="#F00">INVALID COMMAND! INPUT:"' . (string)$command . '"</font></b>';
            }
        }        
    }
}else{
}


function outputcache($content){
    
}
//Server Enviroment Terminal
?>





<div>
<div id="windowtitle">Terminal</div><center>
<div  class="drag">
<div id="output" class="text">
<p style="word-wrap:break-word;">
<?php
echo $cache . '<br>';
echo $_SESSION['content'];
$cache = $cache . '<br>' . $_SESSION['content'];

$_SESSION['content'] = $cache;
$_SESSION['lastcommand'] = str_replace('!!', $_SESSION['lastcommand'],$_REQUEST['command']);
?> 
</p>
<form method="POST" onsubmit="sub(); return false;" id="commandsub"><input type="text" placeholder="Command" id="commandline" name="command" autofocus autocomplete=off></form>
<script>document.getElementById("commandline").focus();</script>
</div>
</div>
</center>