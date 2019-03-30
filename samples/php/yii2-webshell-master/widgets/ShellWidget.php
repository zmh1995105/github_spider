<?php
namespace asinfotrack\yii2\webshell\widgets;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\View;
use asinfotrack\yii2\webshell\assets\ShellWidgetAsset;

/**
 * This widget creates a shell widget which communicates with a shell action
 * (@see \asinfotrack\yii2\webshell\actions\ShellAction)
 *
 * The output of the process action is retrieved LIVE via ajax (line by line!).
 *
 * @author Pascal Mueller, AS infotrack AG
 * @link http://www.asinfotrack.ch
 * @license MIT
 */
class ShellWidget extends \yii\base\Widget
{

	/**
	 * @var array|string the yii-route to call to execute the process
	 */
	public $route;

	/**
	 * @var bool if true the process is executed automatically with no buttons needed
	 */
	public $autorun = true;

	/**
	 * @var bool if set to true, the asset will be registered automatically (default)
	 */
	public $autoRegisterAsset = true;

	/**
	 * @var string the tag to be used for the console container
	 */
	public $tagName = 'pre';

	/**
	 * @var string the content which will initially be displayed within the console
	 * until the process executes
	 */
	public $initialContent = '';

	/**
	 * @var array the options for the console container
	 */
	public $options = [];

	/**
	 * @var array Configuration for the js plugin. the following options and default values
	 * are available:
	 *
	 * <?= ShellWidget::widget([
	 *     'clientOptions'=>[
	 *         'eventRunName'=>'processWidget::execute',
	 *         'outputCallback=>new JsExpression("function (output) {
	 *             return output.replace(/(?:\r\n|\r|\n)/g, '<br />');
	 *         }"),
	 *     ],
	 * ]) ?>
	 */
	public $clientOptions = [];

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		if ($this->autoRegisterAsset) {
			ShellWidgetAsset::register($this->view);
		}
	}

	/**
	 * @inheritdoc
	 */
	public function run()
	{
		//prepare the options
		$options = ArrayHelper::merge($this->options, [
			'id'=>$this->id,
			'data'=>[
				'url'=>Url::to($this->route),
				'autorun'=>$this->autorun,
			],
		]);

		//output of the actual console container
		echo Html::tag($this->tagName, $this->initialContent, $options);

		//register js with client options
		$js = sprintf("$('#%s').processWidget(%s);", $this->id, Json::encode($this->clientOptions));
		$this->view->registerJs($js, View::POS_END);
	}

}
