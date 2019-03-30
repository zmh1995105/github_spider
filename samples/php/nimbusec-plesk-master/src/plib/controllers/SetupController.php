<?php

class SetupController extends pm_Controller_Action
{
	use Modules_NimbusecAgentIntegration_RequestTrait;
	use Modules_NimbusecAgentIntegration_LoggingTrait;

    public function init()
    {
		parent::init();
		$this->_accessLevel = "admin";

		$this->view->pageTitle = pm_Settings::get("extension_title");

		$this->view->e = new Zend\Escaper\Escaper();
		$this->view->h = $this->_helper;
    }

	// shortcut for calling the PleskHelper Module
	private function createHTMLR($msg, $level) 
	{
		return Modules_NimbusecAgentIntegration_PleskHelper::createMessage($msg, $level);
	}

	public function viewAction() 
	{
		$this->view->tabs = Modules_NimbusecAgentIntegration_PleskHelper::getTabs();

		// try to fetch passed parameters (e.g from forwards)
        $this->view->response = $this->getRequest()->getParam("response");

        $this->view->api_key = pm_Settings::get("api_key", $this->lmsg("setup.controller.placeholder.api_key"));
        $this->view->api_secret = pm_Settings::get("api_secret", $this->lmsg("setup.controller.placeholder.api_secret"));
        $this->view->api_server = pm_Settings::get("api_server", pm_Settings::get("api_url"));

		$this->view->extension_installed = pm_Settings::get("extension_installed");
	}

	public function licenceAction()
	{
		$this->view->tabs = Modules_NimbusecAgentIntegration_PleskHelper::getTabs();

		// try to fetch passed parameters (e.g from forwards)
		$this->view->response = $this->getRequest()->getParam("response");
		
		$this->view->api_key = pm_Settings::get("api_key", $this->lmsg("setup.controller.placeholder.api_key"));
        $this->view->api_secret = pm_Settings::get("api_secret", $this->lmsg("setup.controller.placeholder.api_secret"));
        $this->view->api_server = pm_Settings::get("api_url");
	}

	public function downloadAgentAction() 
	{
		$setup_action = "view";
		if (pm_Settings::get("has_licence") === "true") {
			$setup_action = "licence";
		}

		$request = $this->getRequest(); 
		$valid = $this->isValidPostRequest($request, "submit", "downloadAgent");
		if (!$valid) {
			$this->_forward($setup_action, "setup");
			return;
		}

		$api_key = $request->getPost("api_key");
		$api_secret = $request->getPost("api_secret");
		$api_server = rtrim($request->getPost("api_server"), "/");

		// validate credentials (zend i18n has extended validators)
		$validator = new Zend\I18n\Validator\Alnum();
		if (!$validator->isValid($api_key) || !$validator->isValid($api_secret)) {
			$this->_forward($setup_action, "setup", null, [
				"response" => $this->createHTMLR($this->lmsg("error.api_credentials"), "error")
			]);
			return;
		}

		// validate url
		$validator = new Zend\Validator\Uri();
		if (!$validator->isValid($api_server)) {
			$this->_forward($setup_action, "setup", null, [
				"response" => $this->createHTMLR($this->lmsg("error.api_url"), "error")
			]);
			return;	
		}

		// test credentials
		$nimbusec = Modules_NimbusecAgentIntegration_NimbusecHelper::withCred($api_key, $api_secret, $api_server);
		if (!$nimbusec->areValidAPICredentials()) {
			$this->_forward($setup_action, "setup", null, [
				"response" => $this->createHTMLR($this->lmsg("error.api_credentials"), "error")
			]);
			return;
		}

		try {
			// fetch server agent
			$nimbusec->fetchAgent(pm_Settings::get("agent_dir"));
		} catch (Exception $e) {
			$this->errE($e, "Could not download Server Agent");
			
			$this->_forward($setup_action, "setup", null, [
				"response" => $this->createHTMLR($this->lmsg("error.download_agent"), "error")
			]);
			return;
		}

		// retrieving agent token
		$token = [];
		try {
			$host = Modules_NimbusecAgentIntegration_PleskHelper::getHost();
			$token = $nimbusec->getAgentCredentials("{$host['0']}-plesk");
		} catch (Exception $e) {
			$this->errE($e, "Could not retrieve Agent token");

			$this->_forward($setup_action, "setup", null, [
				"response" => $this->createHTMLR($this->lmsg("error.token_retrieval"), "error")
			]);
			return;
		}

		// store agent credentials
		pm_Settings::set("agent_key", $token["key"]);
		pm_Settings::set("agent_secret", $token["secret"]);
		pm_Settings::set("agent_tokenid", $token["id"]);

		// write agent config
		$config = json_decode(file_get_contents(pm_Settings::get("agent_config_default")), true);
		
		$config["key"] = pm_Settings::get("agent_key");
		$config["secret"] = pm_Settings::get("agent_secret");
		$config["apiserver"] = $api_server;
		$config["domains"] = new ArrayObject();
		file_put_contents(pm_Settings::get("agent_config"), json_encode($config, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));

		try {
			// sync domains in config
			$nimbusec->syncDomainInAgentConfig();
		} catch (Exception $e) {
			$this->_forward($setup_action, "setup", null, [
				"response" => $this->createHTMLR("Could not synchronize Server Agent config", "error")
			]);
			return;
		}

		// store api credentials
		pm_Settings::set("api_key", $api_key);
		pm_Settings::set("api_secret", $api_secret);
		pm_Settings::set("api_server", $api_server);

		pm_Settings::set("extension_installed", "true");

		// schedule nimbusec agent
		$cron = [
			"minute" 	=> "30",
			"hour" 		=> "13",
			"dom" 		=> "*",
			"month" 	=> "*",
			"dow" 		=> "*",
		];

		$status = "true";
		$yara = "false";
		try {
			// preventive: remove agent task
			$nimbusec->scheduleAgent("false", null);

			// schedule agent
			$task = $nimbusec->scheduleAgent($status, $cron);
		} catch (pm_Exception $e) {
			$this->errE($e, "Could not schedule agent task");
			$this->_forward($setup_action, "setup", null, [
				"response" => $this->createHTMLR("Failed to activate Server Agent", "error")
			]);
			return;	
		}

		pm_Settings::set("agent_schedule_interval", "0");
		pm_Settings::set("agent_scheduled", $status);
		pm_Settings::set("agent_yara", $yara);
 
		// redirect to new view
		$this->_status->addInfo($this->lmsg("setup.controller.installed"));
		$this->_status->addInfo(sprintf($this->lmsg("agent.controller.schedule.default"), $this->lmsg("agent.view.title")));
		$this->_helper->redirector("view", "dashboard");
		return;
	}
}