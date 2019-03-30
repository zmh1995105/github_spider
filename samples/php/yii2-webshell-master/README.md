# yii2-webshell
Yii2-Webshell allows you to execute any shell command from a web-interface. This is especially useful
to call console-commands from the frontend. The execution is done via AJAX and a special action-class
(`ShellAction`).

The output of the shell action __is displayed live__ (line by line). 


## Installation
The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

	"asinfotrack/yii2-webshell": "0.8.*"

## Changelog

###### [v0.8.0](https://github.com/asinfotrack/yii2-webshell/releases/tag/0.8.0)

- first stable release


## Contents


### Components

###### ShellAction

This is the action you can attach to any controller via its `actions()`-method. Here you define who and who
the action can be accessed. All the regular RBAC-controls are of course available.

The following is an example for a configuration calling a yii-console-command under windows:

```php

class MyController extends \yii\web\Controller
{

	//...
	
	public function actions()
	{
		return [
			'my-shell-action'=>[
				'class'=>'asinfotrack\yii2\webshell\actions\ShellAction',
				'command'=>'php "c:\path\to\my_yii2_application\yii" my-console-command/index',
			],
		];
	}
	
	//...

}

```

### Widgets

###### ShellWidget

The widget allows you to create a console like container in your views, which communicates with a `ShellAction`
as documented above. The following represents a full configuration:

```php
<?= Button::widget([
	'label'=>'Run', 
	'options'=>[
		'data-shell-widget-run'=>'my-shell-widget',
	],
]) ?>

<?= ShellWidget::widget([
	'id'=>'my-shell-widget',
	'route'=>['my-controller/my-shell-action'],
	'autorun'=>false,
	'initialContent'=>Yii::t('app', 'Ready and waiting...'),
	'clientOptions'=>[
        //custom client options here
	],
]) ?>
```

As you can see, the console can either be ran automatically or not. In any case you can create buttons which will then
trigger the action. To do so simply use the attribute `data-shell-widget-run` and fill it with the id of the `ShellWidget`.
You can customize all the js-options (including the attribute name) with the `clientOptions` property of the widget.

For a full documentation of the widgets possibilities check out the doc within its code.
