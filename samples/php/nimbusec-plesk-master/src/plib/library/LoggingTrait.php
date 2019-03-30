<?php

trait Modules_NimbusecAgentIntegration_LoggingTrait
{
	// err logs a plain error message
	public function err($msg) {
		$header = $this->getLogHeader();
		pm_Log::err("{$header} {$msg}");
	}

	// errE logs a plain error message along with the description of the passed
	// exception
	public function errE($exception, $premsg = "") {
		$header = $this->getLogHeader();

		$msg = ($premsg !== "") ? "{$premsg}: {$exception->getMessage()}" : "{$exception->getMessage()}";
		pm_Log::err("{$header} {$msg}");
	}

	// errF logs a message resolved through and format string
	public function errF($format, ...$arguments) {
		$header = $this->getLogHeader();
		
		$msg = sprintf($format, ...$arguments);
		pm_Log::err("{$header} {$msg}");
	}

	// getLogHeader retrieves useful debugging data about the method in which the trait is used
	private function getLogHeader() {
		$function = debug_backtrace()[2]["function"];
		$line = debug_backtrace()[2]["line"];
		$class = debug_backtrace()[2]["class"];

		return "[{$class}::{$function}:{$line}]";
	}
}