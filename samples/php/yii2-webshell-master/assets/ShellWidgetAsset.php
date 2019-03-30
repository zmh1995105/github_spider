<?php
namespace asinfotrack\yii2\webshell\assets;

/**
 * Asset loading the client side code for the shell widget
 *
 * @author Pascal Mueller, AS infotrack AG
 * @link http://www.asinfotrack.ch
 * @license MIT
 */
class ShellWidgetAsset extends \yii\web\AssetBundle
{

	public $sourcePath = '@vendor/asinfotrack/yii2-webshell/assets/src';

    public $depends = [
        'yii\web\JqueryAsset',
    ];

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();

		$this->js[] = YII_DEBUG ? 'shell-widget.js' : 'shell-widget.min.js';
	}

}
