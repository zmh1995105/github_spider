<style>
    ul li{
        list-style-type:none;
    }
    li >div{
        display: inline-block;
    }
</style>
<form>
    <input type="hidden" name="shell" value="<?php echo Func::getVar('shell') ?>"/>
    <input type="hidden" name="driver" value="<?php echo Func::getVar('driver') ?>"/>
    <input value="<?php echo $data['path'] ?>" name="dir"/><button>前往</button>
</form>

<ul id='dir'>
    <?php
    foreach ($data['files'] as $file => $info) {
        if ($file == '.') {
            continue;
        }
        $link = preg_replace('/\/+/', '/', $data['path'] . '/') . $file;

        if ($info['type'] == 'file') {
            $url = Controller::url('dir', 'download', array('f' => $link,'ajax'=>1));
        } else {
            $url = Controller::url('dir', '', array('dir' => $link));
        }
        ?>
        <li>
            <div><span><?php echo $info['type'] == 'file' ? '■':'□';?></span></i><a href='<?php echo $url ?>'><?php echo $file ?></a></div>
            <div class="actions">

            </div>
        </li>
        <?php
    }
    ?>
</ul>