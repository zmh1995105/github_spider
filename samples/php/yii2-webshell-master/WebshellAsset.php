<?php
namespace capoloja\webshell;

use yii\web\AssetBundle;

/**
 * WebshellAsset is an asset bundle used to include custom overrides for terminal into the page.
 *
 * @author Alexander Makarov <sam@rmcreative.ru>
 */
class WebshellAsset extends AssetBundle
{
    public $sourcePath = '@capoloja/webshell/assets';

    public $css = [
        'webshell.css',
    ];

    public $depends = [
        'capoloja\webshell\JqueryTerminalAsset',
    ];
}
