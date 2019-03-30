<?php /* @var $this App */ ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Web Shell 控制台</title>
        <script src="asserts/jquery-2.1.3.min.js" type="text/javascript"></script>
    </head>
    <body>
        <style type="text/css">
            body{
                /*background-image: url(bg.png);*/
                background-color: #528B8B;
            }
            #tabmenu{
                border-bottom: 1px solid #cad0db;

            }
            #tabmenu li{
                display: inline;
                list-style: outside none none;
                margin: 0 -1px 0 0;
                padding: 0;
            }
            #tabmenu li a {		
                background: none repeat scroll 0 0 #e9ecf0;
                border-color: #cad0db #cad0db;
                border-radius: 4px 4px 0 0;
                border-style: solid solid none;
                border-width: 1px 1px medium;
                color: #666666;
                display: inline-block;
                font-family: "微软雅黑";
                font-size: 14px;
                line-height: 26px;
                outline: 0 none;
                padding: 0 14px;
                text-decoration: none;
                margin-right: 5px;
            }
            .container{
                margin: 30px;;
            }
        </style>
        <ul id="tabmenu">
            <?php
            $pages = $this->getPages();
            foreach ($pages as $c => $_pages) {
                foreach ($_pages as $name => $page) {
                    echo "<li><a href='" . Controller::url($c, $page) . "'>{$name}</a></li>";
                }
            }
            ?>
        </ul>
        <div class="container">
            <?php
            if (Func::getVar('shell')) {
                echo $this->controllerData;
            } else {
                $dirvers = App::loadDrivers();
                ?>
                <form>
                    Web Shell 地址: <input name="shell" style="width: 350px;"/>
                    <br/><br/>
                    Shell 类型:
                    <select style="width: 350px;" name="driver">
                        <option value="">-----</option>
                        <?php
                        foreach ($dirvers as $driver => $code) {
                            echo '<option value="' . $driver . '" data="' . htmlspecialchars($code) . '">' . $driver . '</option>';
                        }
                        ?>
                    </select>
                    <br/><br/>
                    <input id="code" style="width: 500px;" readonly />
                    <br/><br/>
                    <button>Hack!</button>
                </form>
                <script>
                    $(function(){
                       $("[name='driver']").change(function(){
                           $("#code").val($( "[name='driver'] option:selected").attr("data"));
                       });
                    });
                </script>
                <?php
            }
            ?>
        </div>
    </body>
</html>
