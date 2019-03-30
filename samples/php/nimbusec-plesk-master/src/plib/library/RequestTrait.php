<?php

trait Modules_NimbusecAgentIntegration_RequestTrait
{
    // isValidPostRequest verifies a Zend_Request's validity
	public function isValidPostRequest($request, $form_event = "action", $expected_action, $dynamic_action = false) 
    {
        // is post
		if (!$request->isPost()) {
			return false;
		}

        // does the given form element exist
		$fetched_action = $request->getPost($form_event);
		if (!isset($fetched_action)) {
			return false;
		}

        if (!$dynamic_action) {       
            // does the form element equals the given action
            if ($fetched_action !== $expected_action) {
                return false;
            }
        }

        if ($dynamic_action) {
            // does the form element starts with the given action
            if (strpos($fetched_action, $expected_action) === false) {
                return false;
            }
        }

		return true;
	}
}