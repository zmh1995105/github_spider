<?php

class QuarantineController extends pm_Controller_Action
{
	use Modules_NimbusecAgentIntegration_RequestTrait;

    public function init()
    {
		parent::init();
		$this->_accessLevel = "admin";

		$this->view->pageTitle = pm_Settings::get("extension_title");

		$this->view->headLink()->appendStylesheet(pm_Context::getBaseUrl() . "/css/materialdesignicons.min.css");
		
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
		$this->view->root_path = "/";
	}

	public function fetchAction() 
	{
		$request = $this->getRequest(); 
		$valid = $this->isValidPostRequest($request, "action", "fetch");
		if (!$valid) {
			$this->_helper->json([
				"error" => $this->lmsg("error.invalid_request")
			]);
			return;
		}

		$path = $request->getPost("path");
		$action = $request->getPost("action");

		// valdiate path
		$validator = new Zend\Validator\NotEmpty();
		if (!$validator->isValid($path)) {
			$this->_helper->json([
				"error" => $this->lmsg("error.invalid_path")
			]);
			return;
		}

		$nimbusec = new Modules_NimbusecAgentIntegration_NimbusecHelper();
		
		$path = $nimbusec->resolvePath($path);
		$fetched = $nimbusec->fetchQuarantine($path);

		$path_fragments = array_filter(explode("/", $path));

		// html template output
		// For the last layer which shows only the file by itself use the display name as a replacement
		// for the id under which it is identified.
		// Since there is only one file, take the display name from it.
		$html = Modules_NimbusecAgentIntegration_PleskHelper::createQNavigationBar($path);
		
		if (count($path_fragments) === 3) {
			$html = Modules_NimbusecAgentIntegration_PleskHelper::createQNavigationBar($path, $fetched[0]["name"]);
		}

		// bulk options
		if (count($path_fragments) < 3) {
			$html .= Modules_NimbusecAgentIntegration_PleskHelper::createQOptions($path, $this->_helper);
		}

		$html .= Modules_NimbusecAgentIntegration_PleskHelper::createQTreeView($path, $fetched, $this->_helper);

		$response = [
			"files" => $fetched,
			"html" 	=> $html,
			"path" 	=> $path,
			"action" => $action,
			"error" => false
		];

		// add success message, if there are no files in quarantine
		if (count($fetched) === 0) {
			$response["success"] = $this->createHTMLR($this->lmsg("quarantine.controller.no_files_found"), "info");
		}

		$this->_helper->json($response);
		return;
	}

	public function unquarantineAction()
	{
		$request = $this->getRequest(); 
		$valid = $this->isValidPostRequest($request, "action", "unquarantine");
		if (!$valid) {
			$this->_helper->json([
				"error" => $this->lmsg("error.invalid_request")
			]);
			return;
		}

		$path = $request->getPost("path");

		// valdiate path
		$validator = new Zend\Validator\NotEmpty();
		if (!$validator->isValid($path)) {
			$this->_helper->json([
				"error" => $this->lmsg("error.invalid_path")
			]);
			return;
		}

		$nimbusec = new Modules_NimbusecAgentIntegration_NimbusecHelper();
		$path = $nimbusec->resolvePath($path);

		// for showing success message
		$display_path = $path;
		
		// if last layer, replace unique path id with name of file
		$path_fragments = explode("/", $path);
		if (count($path_fragments) === 3) {
			$files = $nimbusec->getQuarantined($path_fragments[1]);
			list(, $name) = Sabre\Uri\split($files[$path_fragments[2]]["old"]);

			$display_path = Sabre\Uri\resolve($path, $name);
		}

		// try out unquarantining
		try {
			$success = $nimbusec->unquarantine($path);
			if (!$success) {
				$this->_helper->json([
					"error" => $this->createHTMLR($this->lmsg("error.unexpected"), "error")
				]);
				return;
			}
		} catch (Exception $e) {
			$this->_helper->json([
				"error" => $this->createHTMLR($e->getMessage(), "error")
			]);
			return;
		}

		// fetch one layer above
		// split e.g /quarantine/test.at to /quarantine and test.at
		list($dirname, ) = Sabre\Uri\split($path);
		$fetched = $nimbusec->fetchQuarantine($dirname);

		// if no quarantined issue are left, fetch again one layer above
		if (count($fetched) === 0) {
			list($dirname, ) = Sabre\Uri\split($dirname);
			if ($dirname == "") {
				$dirname = "quarantine/";
			}

			$fetched = $nimbusec->fetchQuarantine($dirname);
		}

		$html = Modules_NimbusecAgentIntegration_PleskHelper::createQNavigationBar($dirname) .
					Modules_NimbusecAgentIntegration_PleskHelper::createQOptions($dirname, $this->_helper) .
					Modules_NimbusecAgentIntegration_PleskHelper::createQTreeView($dirname, $fetched, $this->_helper);
		
		$this->_helper->json([
			"files"   => $fetched,
			"html" 	  => $html,
			"path" 	  => $dirname,
			"action"  => $action,
			"error"   => false,
			"success" => $this->createHTMLR(sprintf($this->lmsg("quarantine.controller.unquarantined"), $display_path), "info")
		]);
		return;		
	}

	public function unquarantineBulkAction()
	{
		$request = $this->getRequest(); 
		$valid = $this->isValidPostRequest($request, "action", "unquarantine-bulk");
		if (!$valid) {
			$this->_helper->json([
				"error" => $this->lmsg("error.invalid_request")
			]);
			return;
		}

		$path = $request->getPost("path");
		$paths = $request->getPost("paths");

		// valdiate path
		$validator = new Zend\Validator\NotEmpty();
		if (!$validator->isValid($path)) {
			$this->_helper->json([
				"error" => $this->lmsg("error.invalid_path")
			]);
			return;
		}

		// valdiate paths
		$validator = new Zend\Validator\NotEmpty();
		if (!$validator->isValid($paths)) {
			$this->_helper->json([
				"error" => $this->lmsg("quarantine.controller.no_files")
			]);
			return;
		}

		$nimbusec = new Modules_NimbusecAgentIntegration_NimbusecHelper();

		$path = $nimbusec->resolvePath($path);
		$paths = json_decode($paths, true);

		if (count($paths) == 0) {
			$this->_helper->json([
				"error" => $this->createHTMLR($this->lmsg("quarantine.controller.no_files"), "error")
			]);
			return;
		}

		// try out unquarantining
		foreach ($paths as $subpath) {
			$subpath = $nimbusec->resolvePath($subpath);

			try {
				$success = $nimbusec->unquarantine($subpath);
				if (!$success) {
					$this->_helper->json([
						"error" => $this->createHTMLR($this->lmsg("error.unexpected"), "error")
					]);
					return;
				}
			} catch (Exception $e) {
				$this->_helper->json([
					"error" => $this->createHTMLR($e->getMessage(), "error")
				]);
				return;
			}
		}

		// fetch one layer above
		// split e.g /quarantine/test.at to /quarantine and test.at
		list($dirname, ) = Sabre\Uri\split($path);
		$fetched = $nimbusec->fetchQuarantine($dirname);
		
		// if no quarantined issue are left, fetch again one layer above
		if (count($fetched) === 0) {
			list($dirname, ) = Sabre\Uri\split($dirname);
			if ($dirname == "") {
				$dirname = "quarantine/";
			}

			$fetched = $nimbusec->fetchQuarantine($dirname);
		}

		$html = Modules_NimbusecAgentIntegration_PleskHelper::createQNavigationBar($dirname) .
					Modules_NimbusecAgentIntegration_PleskHelper::createQOptions($dirname, $this->_helper) .
					Modules_NimbusecAgentIntegration_PleskHelper::createQTreeView($dirname, $fetched, $this->_helper);

		$this->_helper->json([
			"files"   => $fetched,
			"html" 	  => $html,
			"path" 	  => $dirname,
			"action"  => $action,
			"error"   => false,
			"success" => $this->createHTMLR($this->lmsg("quarantine.controller.bulk_unquarantined"), "info")
		]);
		return;
	}
}