<?php

class IndexController extends pm_Controller_Action
{
    use Modules_NimbusecAgentIntegration_LoggingTrait;

    public function init()
    {
        parent::init();
        $this->initPleskStore();
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

    private function initPleskStore()
    {
        pm_Settings::set("extension_id", "nimbusec-agent-integration");
        pm_Settings::set("extension_title", "Nimbusec Webhosting Security");

        pm_Settings::set("agent_dir", pm_Context::getVarDir());
        pm_Settings::set("agent_config_default", pm_Context::getVarDir() . "/default.conf");
        pm_Settings::set("agent_config", pm_Context::getVarDir() . "/agent.conf");
        pm_Settings::set("agent_log", pm_Context::getVarDir() . "/agent.log");
        pm_Settings::set("agent_script", "run.php");

        pm_Settings::set("shellray_url", "https://shellray.com/upload");
        pm_Settings::set("portal_url", "https://portal.nimbusec.com/");
        pm_Settings::set("api_url", "https://api.nimbusec.com");
    }

    public function indexAction()
    {
        $installed = pm_Settings::get("extension_installed");
        if ($installed !== "true") {
            
            // check if a plesk licence exist
            $productName = "ext-" . pm_Settings::get("extension_id");
            $licences = pm_License::getAdditionalKeysList($productName);
            if (count($licences) == 0) {

                // set by default to empty
                pm_Settings::set("api_key", null);
                pm_Settings::set("api_secret", null);
                pm_Settings::set("has_licence", "false");

                $this->_forward("view", "index");
                return;
            }

            // retrieve information from licence
            $licence = reset($licences);
            $credentials = json_decode($licence["key-body"], true);
            if ($credentials === null) {
                $this->err("Unable to deserialize licence key-body: " . json_last_error_msg() != false ? json_last_error_msg() : "No error");
                $this->_forward("view", "index");
                return;
            }

            if (!array_key_exists("ClientID", $credentials) || !array_key_exists("ClientSecret", $credentials)) {
                $this->err("Invalid licence body. No key or secret found");
                $this->_forward("view", "index");
                return;                
            }

            pm_Settings::set("has_licence", "true");
            pm_Settings::set("api_key", $credentials["ClientID"]);
            pm_Settings::set("api_secret", $credentials["ClientSecret"]);

            $this->_forward("licence", "setup", null, [
                "response" => $this->createHTMLR($this->lmsg("setup.licence.information"), "info")
            ]);
            return;
        }

        $this->_forward("view", "dashboard");
    }

    public function viewAction()
    {
        $this->view->tabs = Modules_NimbusecAgentIntegration_PleskHelper::getTabs();
        $this->view->buy_url = pm_Context::getBuyUrl();

        // try to fetch passed parameters (e.g from forwards)
        $this->view->response = $this->getRequest()->getParam("response");

        $this->view->base_url = pm_Context::getBaseUrl();
    }
}
