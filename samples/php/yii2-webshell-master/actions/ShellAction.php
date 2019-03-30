<?php
namespace asinfotrack\yii2\webshell\actions;

use Yii;
use yii\web\Response;
use yii\base\InvalidConfigException;
use Symfony\Component\Process\Process;

class ShellAction extends \yii\base\Action
{

	/**
	 * @var \Symfony\Component\Process\Process the process instance
	 */
	protected $process;

	/**
	 * @var string the shell command to execute
	 */
	public $command;

	/**
	 * @var \Closure method to handle the output in a custom way. It gets called each time there
	 * is more output available. To make the content available to the frontend you have to echo it
	 * immediately. The function should have the signature `function ($action, $output, $isError)`.
	 * `$action` is a reference to the action class, `$output` is the content to output and `$isError`
	 * is a boolean which is true when this was an error output.
	 *
	 * Make sure to always flush the output. You can use `flushOutput()`of the action to do so.
	 */
	public $outputCallback;

	/**
	 * @var int the timeout and therefore max runtime of the command (defaults to five minutes).
	 */
	public $timeout = 300;

	/**
	 * @var int|string the expected exit code of the command to signal a success
	 */
	public $commandExitCodeSuccess = \yii\console\Controller::EXIT_CODE_NORMAL;

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		//validate shell command
		if (empty($this->command)) {
			throw new InvalidConfigException(Yii::t('app', 'Missing shell-command'));
		}

		//create process instance
		$this->process = new Process($this->command);
		$this->process->setTimeout($this->timeout);
	}

	/**
	 * @inheritdoc
	 */
	public function run()
	{
		//run the process
		$exitCode = $this->process->run(function ($type, $data) {
			$isError = strcasecmp($type, Process::ERR) === 0;

			if ($this->outputCallback !== null && $this->outputCallback instanceof \Closure) {
				call_user_func($this->outputCallback, $this, $data, $isError);
			} else {
				$this->handleOutput($data, $isError);
			}
		});

		//prepare the response
		$response = Yii::$app->response;
		$response->format = Response::FORMAT_RAW;

		//fetch result and send the content
		if (strcasecmp($exitCode, (string) $this->commandExitCodeSuccess) === 0) {
			$response->statusCode = 200;
		} else {
			$response->statusCode = 500;
		}

		return sprintf("\nExit code of process: %d\n%d", $exitCode, $exitCode);
	}

	/**
	 * Flushes the output buffer
	 */
	public function flushOutput()
	{
		ob_flush();
		flush();
	}

	/**
	 * Default output handler
	 *
	 * @param string $data the output data received
	 * @param bool $isError whether or not this was an error message
	 */
	protected function handleOutput($data, $isError)
	{
		if (defined('STDOUT') && defined('STDERR')) {
			fwrite($isError ? STDERR : STDOUT, $data);
		} else {
			echo $data;
		}

		$this->flushOutput();
	}

}
