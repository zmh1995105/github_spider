<?php

class Modules_NimbusecAgentIntegration_PleskHelper
{
    // getTabs returns the plugin menu tabs depending on the installation state
    // of the extension
    public static function getTabs()
    {
        if (pm_Settings::get("extension_installed") !== "true") {
            if (pm_Settings::get("has_licence") !== "true") {
                return [
                    ["title" => pm_Locale::lmsg("licence.view.title"), "action" => "view", "controller" => "index"]
                ];
            }

            return [
                ["title" => pm_Locale::lmsg("setup.view.title"), "action" => "licence", "controller" => "setup"]
            ];
        }

        if (!pm_ProductInfo::isUnix()) {
            return [
                ["title" => pm_Locale::lmsg("dashboard.view.title"), "action" => "view", "controller" => "dashboard"],
                ["title" => pm_Locale::lmsg("settings.view.title"), "action" => "view", "controller" => "settings"],
                ["title" => pm_Locale::lmsg("agent.view.title"), "action" => "view", "controller" => "agent"],
                ["title" => pm_Locale::lmsg("setup.view.title"), "action" => "view", "controller" => "setup"],
            ];    
        }

        return [
			["title" => pm_Locale::lmsg("dashboard.view.title"), "action" => "view", "controller" => "dashboard"],
			["title" => pm_Locale::lmsg("quarantine.view.title"), "action" => "view", "controller" => "quarantine"],
			["title" => pm_Locale::lmsg("settings.view.title"), "action" => "view", "controller" => "settings"],
			["title" => pm_Locale::lmsg("agent.view.title"), "action" => "view", "controller" => "agent"],
			["title" => pm_Locale::lmsg("setup.view.title"), "action" => "view", "controller" => "setup"],
        ];
    }

    // setQuarantine saves a given quarantine store as JSON within Plesk's 
    // kv-database. If needed, it splits the JSON string to fulfill
    public static function setQuarantine($quarantine_store)
    {
        $encoded = json_encode($quarantine_store);
        
        // Plesk allowes the store to have a maximum length of 2000 chars.
        // To prevent this, cut the store into multiple parts, each of length 1980. 
        // Use the rest 20 chars for referencing to the next store.
        $splitted = str_split($encoded, 1980);

        for ($i = 0; $i < count($splitted); $i++) {
            $store_part = $splitted[$i];

            // only append reference if there is a next store
            if (($i + 1) < count($splitted)) {
                $store_part .= "_qref_" . strval($i + 1);
            }

            $key = "quarantine_{$i}";
            if ($i === 0) {
                $key = "quarantine";
            }

            pm_Settings::set($key, $store_part);
        }
    }

    // getQuarantine returns the JSON encoded quarantine store string as an object
    public static function getQuarantine()
    {
        $quarantine_store = pm_Settings::get("quarantine", "");
        if ($quarantine_store === "") {
            return [];
        }

        return json_decode(Modules_NimbusecAgentIntegration_PleskHelper::getFullQuarantineStore($quarantine_store), true);
    }

    // getFullQuarantineStore follows and concats each splitted quarantine store part until
    // the whole store is complete
    private static function getFullQuarantineStore($quarantine_store) 
    {
        // are there references to other stores?
        $stores = explode("_qref_", $quarantine_store);
        if (count($stores) === 1) {
            return $stores[0];
        }

        $ref_index = $stores[1];
        $next = pm_Settings::get("quarantine_{$ref_index}", "");
        if ($next === "") {
            pm_Log::err("Quarantine: invalid store: quarantine_{$ref_index}");
            throw new Exception(pm_Locale::lmsg("quarantine.controller.invalid_store"));
        }

        return $stores[0] . Modules_NimbusecAgentIntegration_PleskHelper::getFullQuarantineStore($next);
    }

    // getAdministrator sends via Plesk's API an RPC call to 
    // ask for the administrator object
    public static function getAdministrator()
    {
        $request = <<<DATA
<server>
	<get>
		<admin/>
	</get>
</server>
DATA;

        $resp = pm_ApiRpc::getService()->call($request);
        return $resp->server->get->result->admin;
    }

    // getHost sends via Plesk's API an RPC class to
    // ask for the hostname of the server 
    public static function getHost()
    {
        $request = <<<DATA
<server>
	<get>
		<gen_info/>
	</get>
</server>
DATA;

        $resp = pm_ApiRpc::getService()->call($request);
        return $resp->server->get->result->gen_info->server_name;
    }

    // getHostDomains retrieves all host domains with activated hosting
    public static function getHostDomains()
    {
        $domains = [];

        $fetched = pm_Domain::getAllDomains();
        $filtered = array_filter($fetched, function ($domain) {
            return $domain->hasHosting();
        });

        foreach ($filtered as $domain) {
            $name = $domain->getDisplayName();
            $path = $domain->getDocumentRoot();

            $domains[$name] = $path;
        }

        return $domains;
    }

    // getDomainDir returns the path to the document root of the given domain
    public static function getDomainDir($domain)
    {
        $fetched = pm_Domain::getByName($domain);

        if (!$fetched->hasHosting()) {
            return false;
        }

        return $fetched->getDocumentRoot();
    }

    // createMessage builds a HTML message with a given message and
    // of a given level
    public static function createMessage($msg, $level)
    {
        $title = $level;
        if ($level == "info") {
            $title = "information";
        }

        $title = ucfirst($title);

        // return html template
        return "
        <div class='msg-box msg-{$level}'>
            <div class='msg-content'>
                <span class='title'>
                    {$title}:
                </span>

                {$msg}
            </div>
        </div>";
    }

    // createQNavigationBar builds the navigation bar for the quaratine view.
    // How the bar looks like depends on the given path.
    public static function createQNavigationBar($path, $display_name = "")
    {
        // template variable
        $navigation_bar = "";

        $subpaths = array_filter(explode("/", $path));

        $partial_path = "";
        for ($i = 0; $i < count($subpaths); $i++) {
            $subpath = $subpaths[$i];
            $partial_path .= "{$subpath}/";

            // for the last layer, take the replacement
            if ($i === 2) {
                $subpath = $display_name;
            }

            $navigation_bar .= "
            <li>
                <a id='subpath' path='{$partial_path}'>
                    <span>
                        {$subpath}
                    </span>
                </a>
            </li>";
        }

        // return html template
        return "
        <div class='pathbar'>
            <ul>
                {$navigation_bar}
            </ul>
        </div>";
    }

    // createQOptions builds the options part (bulk options, etc..) for the quarantine view. 
	public static function createQOptions($path, $helper) 
    {
        // return html template
		return "
        <div class='form-row'>
            <div class='field-name' style='margin-left: .6%;'>
                " . pm_Locale::lmsg("dashboard.view.bulk_actions") . "
            </div>

            <div class='field-value' style='margin-bottom: .5%;'>
                <a onclick='bulk_request(\"{$path}\", \"unquarantine-bulk\", updateHandler, \"" . $helper->url("unquarantine-bulk", "quarantine") . "\");' 
                        style='color: #353535;'>

                    <i class='mdi mdi-bug'></i>
                    <span>" . pm_Locale::lmsg("quarantine.controller.unquarantine") . "</span>
                </a>
            </div>

        </div>";
	}

    // createQTreeView builds the base of the tree like directory / files view
    // of the quarantine view.
	public static function createQTreeView($path, $files, $helper)
    {
		if (count($files) == 0) {
			return "";
		}

        // detect type
        $type = $files[0]["type"];

        // file view
        if ($type == 2) {
            $fragments = array_filter(explode("/", $path));
            $domain = $fragments[1];

            return self::createQTreeViewFile($path, $domain, $files);
        }
        
        // build tree view
        $tree_view = "";
        if ($type === 0) {
            $tree_view = self::createQTreeViewDir($path, $files, $helper);
        } elseif ($type === 1) {
            $tree_view = self::createQTreeViewDomain($path, $files, $helper);
        }

        // return html template
        return "
        <div class='list'>
            <table>
                {$tree_view}
            </table>
        </div>";
    }

    // createQTreeViewDir builds the tree view for the directory layer
    private static function createQTreeViewDir($path, $files, $helper)
    {
        $table_body = "";
        foreach ($files as $file) {
            $table_body .= "
            <tr>
                <td>
                    <input type='checkbox' id='select'/>
                    <a id='subpath' path='{$path}/{$file['name']}'>
                        <i class='mdi mdi-folder'></i>
                        <span>{$file['name']}</span>
                    </a>
                </td>
                <td>{$file['count']}</td>
                <td>
                    <a onclick='request_wrapper(\"{$path}/{$file['name']}\", \"unquarantine\", updateHandler, \"" . $helper->url("unquarantine", "quarantine") . "\");'>
                        <i class='mdi mdi-bug'></i>
                        <span>" . pm_Locale::lmsg("quarantine.controller.unquarantine") . "</span>
                    </a>
                </td>
            </tr>";
        }

        // return html template
        return "
        <thead>
            <tr>
                <th style='width: 30%;'><input type='checkbox' id='select-all'/> Name</th>
                <th>" . pm_Locale::lmsg("quarantine.controller.no_of_files") . "</th>
                <th>" . pm_Locale::lmsg("quarantine.controller.action") . "</th>
            </tr>
        </thead>
        <tbody>
            {$table_body}
        </tbody>";
    }

    // createQTreeViewDir builds the tree view for the domain layer
    private static function createQTreeViewDomain($path, $files, $helper)
    {
        $table_body = "";
        foreach ($files as $file) {
            $table_body .= "
            <tr>
                <td>
                    <input type='checkbox' id='select'/>
                    <a id='subpath' path='{$path}/{$file['id']}'>
                        <i class='mdi mdi-file-outline'></i>
                        <span>{$file['name']}</span>
                    </a>
                </td>
                <td>{$file['create_date']}</td>
                <td>{$file['old']}</td>
                <td>{$file['filesize']}</td>
                <td>{$file['permission']}</td>
                <td>{$file['owner']}</td>
                <td>{$file['group']}</td>
                <td>
                    <a onclick='request_wrapper(\"{$path}/{$file['id']}\", \"unquarantine\", updateHandler, \"" . $helper->url("unquarantine", "quarantine") . "\");'>
                        <i class='mdi mdi-bug'></i>
                        <span>" . pm_Locale::lmsg("quarantine.controller.unquarantine") . "</span>
                    </a>
                </td>
            </tr>";
        }

        // return html template
        return "
        <thead>
            <tr>
                <th style='width: 30%;'><input type='checkbox' id='select-all'/> Name</th>
                <th>" . pm_Locale::lmsg("quarantine.controller.quarantined_on") . "</th>
                <th>" . pm_Locale::lmsg("quarantine.controller.old_path") . "</th>
                <th>" . pm_Locale::lmsg("quarantine.controller.filesize") . "</th>
                <th>" . pm_Locale::lmsg("dashboard.view.permission") . "</th>
                <th>" . pm_Locale::lmsg("dashboard.view.owner") . "</th>
                <th>" . pm_Locale::lmsg("dashboard.view.group") . "</th>
                <th>" . pm_Locale::lmsg("quarantine.controller.action") . "</th>
            </tr>
        </thead>
        <tbody>
            {$table_body}
        </tbody>";
    }

    // createQTreeViewFile builds the tree view for a given file and handles
    // the error message, if no file was found.
    private static function createQTreeViewFile($path, $domain, $files)
    {
        $source_code = "No source code is found";
        try {
            $file_manager = new pm_FileManager(pm_Domain::getByName($domain)->getId());
            if ($file_manager->fileExists($files[0]['path'])) {
                $source_code = trim(htmlentities($file_manager->fileGetContents($files[0]['path'])));
            }
        } catch (pm_Exception $e) {}

        // return html template
        return "<pre style='white-space: pre-wrap;'><code class='php'>{$source_code}</code></pre>";
    }

    // createFormRow builds a HTML form row for a given title and a given value
    public static function createFormRow($title, $value)
    {
        return "
        <div class='form-row'>
            <div class='field-name'>
                {$title}
            </div>
            <div class='field-value'>
                {$value}
            </div>
        </div>";
    }

    // createFormRow builds a HTML-based options selection panel
    public static function createSelectIssuesByDomain($domain)
    {
        return "
        <div style='margin-top: 5px;'>
            <a id='issue-link-{$domain}'>
                " . pm_Locale::lmsg("dashboard.view.select_issues") . "
            </a>
        </div>";
    }

    // createSeperator builds a sepearator element which matches Plesk's design guidelines
    public static function createSeperator()
    {
        return "<div class='btns-box'></div>";
    }

    // createIssuePanel builds for a given issue the while HTML panel providing options
    // and detailed information about the issue
    public static function createIssuePanel($domain, $issue, $helper)
    {
        $colors = ["#bbb", "#fdd835", "#f44336"];

        $left_bubble = $issue['severity'] == 1 ? $colors[1] : $colors[0];
        $right_bubble = $issue['severity'] > 1 ? $colors[2] : $colors[0];

        $source_code = "No source code is found";
        try {
            $file_manager = new pm_FileManager(pm_Domain::getByName($domain)->getId());
            if ($file_manager->fileExists($issue['resource'])) {
                $source_code = trim(htmlentities($file_manager->fileGetContents($issue['resource'])));
            }
        } catch (pm_Exception $e) {}

        $panel = "
        <div class='panel panel-collapsible p-promo panel-collapsed'>
            <div class='panel-wrap'>

                <div class='panel-heading'>
                    <div class='panel-heading-wrap'>
                        <span class='panel-control'>

                            <div style='margin-left: -140px; color: #303030; margin-top: 2px;display: inline-block;'>
                                    " . date('m/d/o h:i A', $issue['lastDate'] / 1000) . "                                           
                            </div>
                            <div style='margin-left: -246px; display: inline-block;'>

                                <form id='falsePositive' method='post' action='" . $helper->url('false-positive', 'dashboard') . "'>
                                    <input name='action' value='falsePositive' type='hidden'/>
                                    <input name='domain' value='{$domain}' type='hidden'/>
                                    <input name='resultId' value='{$issue['id']}' type='hidden'/>
                                    <input name='file' value='{$issue['resource']}' type='hidden'>
                                    <a onclick='sendForm(this);'>
                                        <i class='mdi mdi-flag'></i>
                                        <span class='button-text'>    
                                            <span>
                                                " . pm_Locale::lmsg('dashboard.view.false_positive') . "
                                            </span>
                                        </span>
                                        <span class='button-loading' style='display: none;'>
                                            <span style='margin-right: 5px;'>
                                                Please Wait <img style='margin-left: 5px; width: 16px; height: 16px;' src='/theme/icons/16/plesk/indicator.gif'>
                                            </span>
                                        </span>
                                    </a>
                                </form>

                            </div>";

        if (pm_ProductInfo::isUnix()) {
            $panel .= "
            <div style='margin-left: -256px; margin-top: 2px;display: inline-block;'>

                <form id='moveToQuarantine' method='post' action='" . $helper->url('quarantine', 'dashboard') . "'>
                    <input name='action' value='moveToQuarantine' type='hidden'>
                    <input name='domain' value='{$domain}' type='hidden'>
                    <input name='file' value='{$issue['resource']}' type='hidden'>
                    <a onclick='sendForm(this);'>
                        <i class='mdi mdi-bug'></i>
                        <span class='button-text'>    
                            <span>
                                " . pm_Locale::lmsg('dashboard.view.quarantine') . "
                            </span>
                        </span>
                        <span class='button-loading' style='display: none;'>
                            <span style='margin-right: 5px;'>
                                Please Wait <img style='margin-left: 5px; width: 16px; height: 16px;' src='/theme/icons/16/plesk/indicator.gif'>
                            </span>
                        </span>
                    </a>
                </form>

            </div>";
        }

        $panel .= "
                        </span>

                        <div class='panel-heading-name'>
                            <span style='margin-right: 5px'>";
        if (pm_ProductInfo::isUnix()) {
            $panel .= "
                <input type='checkbox' id='issue-{$domain}'/>
            ";
        }

        $panel .= " 
                                <i class='mdi mdi-checkbox-blank-circle' style='color: {$left_bubble}'></i>
                                <i class='mdi mdi-checkbox-blank-circle' style='color: {$right_bubble}'></i>
                            </span>

                            <span style='font-size: 13px'>
                                {$issue['resource']}
                            </span>
                        </div>

                    </div>
                </div>

                <div class='panel-content'>
                    <div class='panel-content-wrap'>

                        <div class='box-area'>
                            <div class='form-row'>
                                <div class='field-name'>
                                    <span>
                                        " . pm_Locale::lmsg('dashboard.view.occured_on') . "
                                    </span>
                                </div>
                                <div class='field-value'>
                                    <span style='vertical-align: middle;'>
                                        " . date('m/d/o h:i A', $issue['lastDate'] / 1000) . "
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class='box-area'>
                            <div class='form-row'>
                                <div class='field-name'>
                                    <span>
                                        " . pm_Locale::lmsg('dashboard.view.known_since') . "
                                    </span>
                                </div>
                                <div class='field-value'>
                                    <span style='vertical-align: middle;'>
                                        " . date('m/d/o h:i A', $issue['createDate'] / 1000) . "
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class='box-area'>
                            <div class='form-row'>
                                <div class='field-name'>
                                    <span>
                                        " . pm_Locale::lmsg('dashboard.view.path') . "
                                    </span>
                                </div>
                                <div class='field-value'>
                                    <span style='vertical-align: middle;'>
                                        {$issue['resource']}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class='box-area'>
                            <div class='form-row'>
                                <div class='field-name'>
                                    <span>
                                        " . pm_Locale::lmsg('dashboard.view.name') . "
                                    </span>
                                </div>
                                <div class='field-value'>
                                    <span style='vertical-align: middle;'>
                                        {$issue['threatname']}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class='box-area'>
                            <div class='form-row'>
                                <div class='field-name'>
                                    <span>
                                        " . pm_Locale::lmsg('dashboard.view.md5') . "
                                    </span>
                                </div>
                                <div class='field-value'>
                                    <span style='vertical-align: middle;'>
                                        {$issue['md5']}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class='box-area'>
                            <div class='form-row'>
                                <div class='field-name'>
                                    <span>
                                        " . pm_Locale::lmsg('dashboard.view.owner') . "
                                    </span>
                                </div>
                                <div class='field-value'>
                                    <span style='vertical-align: middle;'>
                                        {$issue['owner']}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class='box-area'>
                            <div class='form-row'>
                                <div class='field-name'>
                                    <span>
                                        " . pm_Locale::lmsg('dashboard.view.group') . "
                                    </span>
                                </div>
                                <div class='field-value'>
                                    <span style='vertical-align: middle;'>
                                        {$issue['group']}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class='box-area'>
                            <div class='form-row'>
                                <div class='field-name'>
                                    <span>
                                        " . pm_Locale::lmsg('dashboard.view.permission') . "
                                    </span>
                                </div>
                                <div class='field-value'>
                                    <span style='vertical-align: middle;'>
                                        {$issue['permission']}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class='source-code'>
                            <a>
                                " . pm_Locale::lmsg('dashboard.view.source_code') . " <i class='mdi mdi-arrow-down-drop-circle source-code-icon'></i>
                            </a>
                        
                            <div class='panel panel-collapsible panel-collapsed source-code-panel' style='margin: 0px; border: 0px'>
                                <div class='panel-wrap'>
                                    <div class='panel-content'>
                                        <div class='panel-content-wrap'>
                                            <pre style='white-space: pre-wrap;'><code class='php'>{$source_code}</code></pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>";

        return $panel;
    }

    // onError acts as a customized method for handling error messages in PHP
    public static function onError($errno, $errstr, $errfile, $errline, array $errcontext) {
        // error was suppressed with the @-operator
        if (0 === error_reporting()) {
            return false;
        }
    
        throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
    }
}
