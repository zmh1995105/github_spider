<?php
include_once "../../include/app.php";
$L = $La->extlanguage("webconsole");
$url = "http://".$_SERVER['SERVER_ADDR'].":8181/web-console/src/";
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=8" />
    <title>WebConsole</title>
    <link href="../../css/base.css?v=<?=mt_rand()?>" rel="stylesheet" type="text/css">
    <link href="../../css/style-webconsole.css?v=<?=mt_rand()?>" rel="stylesheet" type="text/css">
    <script src="../../js/jquery.js"></script>
    <script src="../../js/common.js?v=<?=mt_rand()?>"></script>
    <script>
        <?php
        if(!isset($_langs) || count($_langs)==0) $_langs = array('zh-cn');
        if (in_array($real_lang,$_langs)){
            $turl =  "http://help.terra-master.com/TOS/view/?lang/$real_lang/flag/plex_media_server";
        }
        ?>
        <?php if ($turl){?>
        top.window.art.dialog.list['<?php echo $PageName['filename']?>'].openhelp("<?php echo $turl;?>");
        <?php }?>
        $.getScript("/js/lib/cTools.js", function () {
            var ajaxload_callback = new cTools();
        });
    </script>
</head>

<body>
<header class="heder-info">
    <div class="logo-info">
        <figure>
            <img src="../../images/icons/webconsole.png">
            <figcaption><?=$L['webconsole']?></figcaption>
        </figure>
    </div>
    <div class="v-info">
        <p><span style="width: 40%;display: inline-block;text-align: right;padding-right: 14px;"><?php echo $root['meto']['app_version']?></span><span><?php echo $L['version']?></span></p>
        <p><span style="width: 40%;display: inline-block;text-align: right;padding-right: 14px;"><?php echo $root['meto']['app_auth']?></span><span><?php echo $L['auth']?></span></p>
        <p><span style="width: 40%;display: inline-block;text-align: right;padding-right: 14px;"><?php echo $root['meto']['app_publisher']?></span><span>TerraMaster</span></p>
    </div>
</header>
<div class="intr">
    <p><?=$L[tos_plex_note]?></p>
</div>
<div class="mainbox" style="width: 85%;margin: 0 auto;">
    <div class="conLine">
        <?php if ($status ==1){?>
            <p style="padding-left: 30px;margin-top: 15px;"><button id="_location" class="btn-info-no"><?=$L[enter]?> Plex</button></p>
        <?php }?>
    </div>
    <div class="conLine" style="margin-top: 15px;">
        <p><?php echo $L['defuser']?>:dev</p>
        <p><?php echo $root['install']['password'];?>:dev</p>
    </div>
</div>
<script>
    (function(){
        function ajaxrequest(data, callback, obj) {
            $.ajax({type:"POST",url:"/include/core/index.php",data:data, timeout:50000,success: $.proxy(callback, obj)});
        }

        $("#_location").click(function () {
            window.open('<?php echo $url;?>');
        });
    })($);
</script>
</body>
</html>