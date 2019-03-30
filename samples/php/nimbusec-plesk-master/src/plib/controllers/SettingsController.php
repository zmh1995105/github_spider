<?php

class SettingsController extends pm_Controller_Action
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

		try {
			$nimbusec = new Modules_NimbusecAgentIntegration_NimbusecHelper();

			// domain view
			$this->view->registered_domains = $nimbusec->groupByBundle($nimbusec->getRegisteredPleskDomains());
			$this->view->nonregistered_domains = $nimbusec->getNonRegisteredPleskDomains();

        } catch (Exception $e) {
            $this->view->response = $this->createHTMLR("Could not retrieve registered domains", "error");
		}
		
		// provisional - sync registered domains with agent conf every time the customer
		// is at the agent tab. This is a rather bad solution, as the synchronization should
		// not be dependent on whether the customer clicks on a random tab. Instead, the synchronization
		// should be conducted by a cron job script running in background; like the agent/quarantine.php
		try {
			// sync domains in config
			$nimbusec->syncDomainInAgentConfig();
		} catch (Exception $e) {
			$this->_forward("view", "dashboard", null, [
				"response" => $this->createHTMLR("Could not synchronize Server Agent config", "error")
			]);
			return;
		}

	}

	public function registerAction() 
	{
		$request = $this->getRequest(); 
		$valid = $this->isValidPostRequest($request, "submit", "registerSelected");
		if (!$valid) {
			$this->_forward("view", "settings");
			return;
		}
		
		$domains = $request->getPost("active");
		$bundle = $request->getPost("bundle");

		// validate given domains
		$validator = new Zend\Validator\NotEmpty();
		if (!$validator->isValid($domains)) {
			$this->_forward("view", "settings", null, [
				"response" => $this->createHTMLR($this->lmsg("settings.controller.no_domains"), "error")
			]);
			return;	
		}
		
		// validate bundle
		$bundle_elements = explode("__", $bundle);
		if (count($bundle_elements) !== 2) {
			$this->_forward("view", "settings", null, [
				"response" => $this->createHTMLR($this->lmsg("settings.controller.invalid_bundle"), "error")
			]);
			return;	
		}

		$bundle_id = $bundle_elements[0];
		$bundle_name = $bundle_elements[1];

		// validate bundle uuid
		$validator = new Zend\Validator\Uuid();
		if (!$validator->isValid($bundle_id)) {
			pm_Log::err("Domain registration: invalid bundle id");

			$this->_forward("view", "settings", null, [
				"response" => $this->createHTMLR($this->lmsg("settings.controller.invalid_bundle"), "error")
			]);
			return;	
		}
		
		$nimbusec = new Modules_NimbusecAgentIntegration_NimbusecHelper();

		// register domain
		$success = true;
		foreach ($domains as $domain) {
			$success = $success && $nimbusec->registerDomain($domain, $bundle_id);
		}

		if (!$success) {
			$this->_forward("view", "settings", null, [
				"response" => $this->createHTMLR($this->lmsg("error.unexpected"), "error")
			]);
			return;	
		}

		try {
			// sync domains in config
			$nimbusec->syncDomainInAgentConfig();
		} catch (Exception $e) {
			$this->_forward("view", "settings", null, [
				"response" => $this->createHTMLR("Could not synchronize Server Agent config", "error")
			]);
			return;
		}

		$this->_status->addInfo(sprintf($this->lmsg("settings.controller.registered"), $bundle_name));
		$this->_helper->redirector("view", "settings");
		return;
	}

	public function unregisterAction() 
	{
		$request = $this->getRequest(); 
		$valid = $this->isValidPostRequest($request, "submit", "removeSelected", true);
		if (!$valid) {
			$this->_forward("view", "settings");
			return;
		}

		$index = substr($request->getPost("submit"), -1);
	
		$domains = $request->getPost("deactive{$index}");	
		$bundle_name = $request->getPost("bundle");

		// validate given domains
		$validator = new Zend\Validator\NotEmpty();
		if (!$validator->isValid($domains)) {
			$this->_forward("view", "settings", null, [
				"response" => $this->createHTMLR($this->lmsg("settings.controller.no_domains"), "error")
			]);
			return;	
		}

		// validate bundle
		$validator = new Zend\Validator\NotEmpty();
		if (!$validator->isValid($bundle_name)) {
			$this->_forward("view", "settings", null, [
				"response" => $this->createHTMLR($this->lmsg("settings.controller.invalid_bundle"), "error")
			]);
			return;	
		}

		$nimbusec = new Modules_NimbusecAgentIntegration_NimbusecHelper();

		// unregister domains
		$success = true;
		foreach ($domains as $domain) {
			$success = $success && $nimbusec->unregisterDomain($domain);
		}

		if (!$success) {
			$this->_forward("view", "settings", null, [
				"response" => $this->createHTMLR($this->lmsg("error.unexpected"), "error")
			]);
			return;	
		}

		try {
			// sync domains in config
			$nimbusec->syncDomainInAgentConfig();
		} catch (Exception $e) {
			$this->_forward("view", "settings", null, [
				"response" => $this->createHTMLR("Could not synchronize Server Agent config", "error")
			]);
			return;
		}

		$this->_status->addInfo(sprintf($this->lmsg("settings.controller.unregistered"), $bundle_name));
		$this->_helper->redirector("view", "settings");
		return;
	}
}