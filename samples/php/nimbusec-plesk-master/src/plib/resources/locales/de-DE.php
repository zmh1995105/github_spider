<?php

$messages = [

	/**************** general ****************/
	"msg.installed" => "installiert",
	"msg.not_installed" => "nicht installiert",
	"msg.directory" => "Verzeichnis",
	"msg.required" => "Pflichtfelder",

	"msg.issues.none" => "Keine",
	"msg.issues.yellow" => "Gelbe Issues",
	"msg.issues.red" => "Rote Issues",

	"button.wait" => "Bitte warten",

	/**************** error ****************/
	"error.download_agent" => "Der Nimbusec Agent konnte nicht heruntergeladen werden",
	"error.enable_sso" => "Es konnte keine Verbindung zum Nimbusec Portal hergestellt werden",
	"error.token_retrieval" => "Es konnte kein Nimbusec Agent Token heruntergeladen werden",
	"error.api_credentials" => "Die angegebenen API Zugangsdaten sind ungültig. Bitte überprüfen Sie deren Gültigkeit und probieren sie es erneut.",
	"error.api_url" => "Die angegebene Server URL ist ungültig.",
	"error.agent_not_supported" => "Unser Nimbusec Server Agent scheint ihr Betriebssystem nicht zu unterstützen. Falls Sie eine solche Nachricht auf einem Windows oder Linux Server vorfinden, kontaktieren Sie uns bitte per Mail über office@nimbusec.at.",
	"error.invalid_domain" => "Ungültige Domain",
	"error.invalid_issue" => "Ungültiges Issue",
	"error.file_not_exist" => "Die angegebene Datei existiert nicht",
	"error.invalid_path" => "Ungültiger Pfad",
	"error.unexpected" => "Ein unerwarteter Fehler ist aufgetreten",
	"error.msg" => "Ein unerwarteter Fehler ist aufgetreten: %s",
	"error.invalid_request" => "Ungültige Anfrage",

	"error.quarantine.file" => "Die Datei %s existiert nicht. Die Datei konnte nicht in Quarantäne verschoben werden.",
	"error.quarantine.directory" => "Es konnte kein Quarantäneverzeichnis erstellt werden: %s",
	"error.quarantine" => "Die Datei %s konnte nicht in Quarantäne an der Position %s verschoben werden: %s", 
	"error.fp" => "Die Datei %s konnte nicht als falsch positiv markiert werden: %s",
	"error.unquarantine" => "Die Datei %s konnte nicht aus der Quarantäne an der Position %s zurück verschoben werden: %s", 

	/**************** index ****************/
	"licence.view.title" => "Lizenz kaufen",
	"licence.view.description" => "Kaufen Sie eine Nimbusec Plesk Lizenz",	
	"licence.view.credentials" => "Geben Sie Ihre Zugangsdaten ein",
	"licence.view.credentials.description" => "Wenn Sie bereits Nimbusec API Zugangsdaten besitzen, dann können Sie die Installation starten",


	/**************** agent ****************/
	"agent.view.title" => "Agent Einstellungen",
	"agent.view.subtitle" => "Informationen über den Agent",
	"agent.view.description" => "Halten Sie den Nimbusec Agent up-to-date indem Sie regelmäßig nach einer neuen Version Ausschau halten und diese auch runterladen. Dies gewährleistet eine effiziente und fehlerfreie Malwareerkennung.",
	"agent.view.installed.title" => "Agent Status",
	"agent.view.installed.value" => "installiert",
	"agent.view.version.title" => "Agent Version",
	"agent.view.os.title" => "Agent Zielbetriebssystem",
	"agent.view.arch.title" => "Agent Zielarchitektur",

	"agent.view.os.windows" => "Windows",
	"agent.view.os.linux" => "Linux",
	"agent.view.os.macosx" => "Mac OSX",
	"agent.view.arch.32bit" => "32 bit",
	"agent.view.arch.64bit" => "64 bit",

	/* schedule settings */
	"agent.view.schedule.title" => "Agent Scaneinstellungen",
	"agent.view.schedule.description" => "Innerhalb dieser Einstellungen können Sie den Hintergrundscan des Nimbusec Server Agent aktivieren (oder deaktivieren) und diesen zum Ausführen in bestimmten Intervallen festlegen." .
											"<br>Bitte beachten Sie, dass der Hintergrundscan nicht beginnt, bis ein Interval gesetzt wurde.",
	"agent.view.schedule.status" => "Hintergrundscan aktiv",
	"agent.view.schedule.update" => "Scaneinstellungen speichern",

	"agent.view.schedule.yara" => "Statische Malware Signaturen einschalten", 
	"agent.view.schedule.yara_not_supported" => "(nicht unterstützt mit 32bit)",

	"agent.view.schedule.interval" => "Agent Scan Interval",
	"agent.view.schedule.interval.once" => "1x am Tag um 13:30",
	"agent.view.schedule.interval.twice" => "2x am Tag um 13:30 and 1:30",
	"agent.view.schedule.interval.three_times" => "3x am Tag um 1:30, 9:30 and 17:30",
	"agent.view.schedule.interval.four_times" => "4x am Tag um 1:30, 7:30, 13:30 and 19:30",	

	/* agent conf */
	"agent.view.conf.title" => "Agent Konfiguration",
	"agent.view.conf.description" => "Unten sehen Sie die Konfiguration des Nimbusec Agent (agent.conf)",
	"agent.view.conf.clipboard" => "In die Zwischenablage kopieren",
	
	"agent.controller.outdated" => "Ihr derzeitiger Nimbusec Agent ist veraltet. Bitte führen Sie ein Update so schnell wie möglich durch.",
	"agent.controller.not_outdated" => "Sie haben die neueste Version des Nimbusec Agent installiert.",
	"agent.controller.update" => "Laden Sie die Version %s herunter",
	"agent.controller.updated" => "Der neueste Version des Nimbusec Agent wurde erfolgreich heruntergeladen.",

	"agent.controller.invalid_interval" => "Ungültiges Interval ausgewählt",
	"agent.controller.schedule.updated" => "Agent Scaneinstellungen wurden erfolgreich gespeichert",
	"agent.controller.schedule.default" => "Der Nimbusec Agent wurde aktiviert. Er läuft einmal am Tag um 13:30. Für weitere Information und Einstellung wechseln Sie zu den '%s'",
	"agent.controller.schedule.notrunning" => "Der Nimbusec Agent ist nicht aktiviert. Checken Sie die Option \"Hintergrundscan aktiv\" und wählen Sie ein geeignetes Scaninterval, um den Agent zu aktivieren",
	"agent.controller.schedule.notrunning.dashboard" => "Der Nimbusec Agent ist nicht aktiviert. Wechseln Sie zu den <a href=\"%s\">%s</a> um ihn zu aktivieren",

	/**************** setup ****************/
	"setup.view.title" => "Installation",
	"setup.view.description" => "Geben Sie hier ihre Nimbusec API Zugangsdaten ein, um den Nimbusec Agent herunterzuladen. " .
								"Verändern Sie das API Server Feld nicht, um die Stabilität des Plugins zu gewährleisten. " .
								"<br>Für weitere Information zum Erhalten und Verwenden der API Zugangsdaten, kontaktieren Sie uns über <a href=\"mailto:plesk@nimbusec.com\">plesk@nimbusec.com</a>." .
								"<br>Die offizielle Dokumentation zur Nimbusec Plesk Extension finden Sie hier: <a href=\"https://kb.nimbusec.com/Integrations/Plesk\" target=\"_blank\">https://kb.nimbusec.com/Integrations/Plesk</a>.",
	"setup.view.download_agent" => "Nimbusec Server Agent herunterladen",

	"setup.controller.placeholder.api_key" => "Ihr Nimbusec API Key",
	"setup.controller.placeholder.api_secret" => "Ihr Nimbusec API Secret",

	"setup.controller.installed" => "Der Nimbusec Agent wurde erfolgreich installiert.",

	"setup.licence.information" => "Wir haben eine Nimbusec Plesk Lizenz auf ihrem System gefunden. Überprüfen Sie die untenstehenden Information und starten Sie
									die Installation des Nimbusec Server Agents",
	"setup.licence.description" => "Sie finden unten die entnommenen Zugansdaten aus Ihrer Nimbusec Plesk Lizenz. " .
									"Bitte überprüfen Sie diese auf ihre Korrektheit. " .
									"<br>Wenn die Zugangsdaten korrekt sind, können Sie die Installation starten. " .
									"Sollten die Zugangsdaten nicht korrekt sein, können Sie diese bearbeiten. " .
									"<br><br>Die offizielle Dokumentation zur Nimbusec Plesk Extension finden Sie hier: <a href=\"https://kb.nimbusec.com/Integrations/Plesk\" target=\"_blank\">https://kb.nimbusec.com/Integrations/Plesk</a>.",


	/**************** settings ****************/
	"settings.view.title" => "Domain Einstellungen",

	/* unregistered */
	"settings.view.unreg.title" => "Nicht registrierte Domains",
	"settings.view.unreg.description" => "Unten finden Sie alle Hostdomain, welche noch nicht über Nimbusec registriert wurden. " .
										 "Um eine Domain zu registrieren, wählen Sie folgende Domain zusammen mit dem Bundle aus, " .
										 "<br>welches zur Registrierung verwenden wollen, und klicken Sie auf \"Ausgewählte Domains registrieren\".",
	"settings.view.unreg.register" => "Ausgewählte Domains registrieren",
	"settings.view.unreg.no_domains" => "Keine Domains gefunden",
	"settings.view.unreg.domain" => "Nicht registrierte Domains",

	/* registered */
	"settings.view.reg.title" => "Registrierte Domains",
	"settings.view.reg.description" => "Unten finden Sie alle registrierten Hostdomains mitsamt ihren zugehörigen Bundles. " .
									   "Um eine Domain zu entfernen, wählen Sie diese aus und klicken Sie auf \"Ausgewählte Domains entfernen\".",
	"settings.view.reg.unregister" => "Ausgewählte Domains entfernen",
	"settings.view.reg.no_domains" => "Keine Domains gefunden.",
	"settings.view.reg.domain" => "Registrierte Domains",

	/* controller */
	"settings.controller.no_domains" => "Es wurden keine Domains ausgewählt.",
	"settings.controller.invalid_bundle" => "Ungültiges Bundles ausgewählt.",
	"settings.controller.registered" => "Die Domain(s) wurden erfolgreich mit %s registriert",
	"settings.controller.unregistered" => "Die Domain(s) wurden erfolgreich von %s entfernt",

	"settings.controller.no_domains.registered" => "Es sind keine Domains zum Scannen registriert. Wechseln Sie zu den <a href=\"%s\">%s</a> um Domains zum Scannen zu registrieren",


	/**************** dashboard ****************/
	"dashboard.view.title" => "Dashboard",
	"dashboard.view.description" => "Das Nimbusec Dashboard zeigt alle erkannten Vorfälle und hilft, diese zu verarbeiten.",

	"dashboard.view.bulk_actions" => "Massenaktionen",
	"dashboard.view.mass_quarantine" => "Manuelle Massenquarantäne",
	"dashboard.view.mass_quarantine.description" => "Die manuelle Massenquarantäen verschiebt alles ausgewählten Vorfälle in Quarantäne. Verwenden Sie diese Funktion mit Vorsicht, denn Sie kann ihrer Webseite schaden. Wenn Sie sich unsicher sind, verschieben Sie nur einzeln die Vorfälle in Quarantäne.",
	"dashboard.view.quarantine" => "Quarantänisieren",
	"dashboard.view.false_positive" => "Falsch positiv",
	"dashboard.view.select_issues" => "Wählen Sie alle Vorfälle aus",
	"dashboard.view.automatic_quarantine" => "Automatische Quarantäne von Vorfällen",
	"dashboard.view.automatic_quarantine.title" => "Automatische Quarantäne",
	"dashboard.view.automatic_quarantine.hint" => "Es wird ein automatisch im Hintergrund laufender Cronjob erstellt, welche alle 5 Minuten nach neuen entdeckten Vorfällen abprüft und diese je nach Art des Vorfallen in Quarantäne schiebt. ",
	
	"dashboard.view.disclaimer" => "Die automatische Quarantäne überprüft im Hintergrund, ob neue infizierte Files gefunden wurden und verschiebet diese automatisch aus ihrer ursprünglichen Position in Quarantäne. Die verhindert weitere Schäden, ermöglicht aber auch eine generelle Beschädigung der Webseite." .
								   "<br/>Daher sollte diese Feature in einer Produktivumgebung <strong>NICHT VERWENDET WERDEN</strong>. Die Nimbusec GmbH übernimmt keine Haftung für mögliche Schäden, welche in Zusammenhang mit der Verwendung dieses Features auftreten.",
	"dashboard.view.disclaimer.accept"=> " Akzeptieren Sie hier, wenn Sie einverstanden sind",

	"dashboard.view.issues" => "Vorfälle",
	"dashboard.view.issues.description" => "Unter finden Sie alle Vorfälle von Domains welche mit Nimbusec gescannt wurden.",
	"dashboard.view.issues.loading" => "(Bitte warten, Vorfälle werden geladen ... <img style='margin-left: 5px; margin-right: 5px; width: 16px; height: 16px;' src='/theme/icons/16/plesk/indicator.gif'>)",										   

	"dashboard.view.sort" => "Sortieren Sie die Vorfällen: ",
	"dashboard.view.sort.severity" => "nach der Schwere des Vorfalls",
	"dashboard.view.sort.no_issues" => "nach der Anzahl an Vorfällen",
	"dashboard.view.sort.no_quarantined" => "nach der Anzahl an in Quarantäne befindlichen Dateien",
	
	"dashboard.view.apply" => "Automatische Quarantäne aktivieren",
	"dashboard.view.no_issues" => "Es wurden keine Vorfälle gefunden.",
	"dashboard.view.source_code" => "Quellcode anzeigen",

	/* for an issue */
	"dashboard.view.occured_on" => "Aufgetreten am",
	"dashboard.view.known_since" => "Bekannt seit",
	"dashboard.view.path" => "Pfad",
	"dashboard.view.name" => "Name",
	"dashboard.view.md5" => "MD5",
	"dashboard.view.owner" => "Besitzer",
	"dashboard.view.group" => "Gruppe",
	"dashboard.view.permission" => "Berechtigung",

	"dashboard.controller.false_positive" => "Das Datei %s wurde erfolgreich als falsch positiv markiert",
	"dashboard.controller.quarantine" => "Die Datei %s wurde erfolgreich in Quarantäne verschoben",
	"dashboard.controller.bulk_quarantine" => "Die ausgewählten Dateien wurden erfolgreich in Quarantäne verschoben",
	"dashboard.controller.automatic_quarantine.enabled" => "Die automatische Quarantäne wurde erfolgreich aktiviert",
	"dashboard.controller.automatic_quarantine.disabled" => "Die automatische Quarantäne wurde erfolgreich deaktiviert",

	"dashboard.controller.no_issues" => "Keine Vorfälle ausgewählt, bitte wählen Sie zumindest eine Vorfäll aus, um diese Aktion auszuführen.",
	"dashboard.controller.invalid_schedule" => "Ungültige Vorfallsschwere ausgewählt",

	/**************** quarantine ****************/
	"quarantine.view.title" => "Quarantäne",
	"quarantine.view.description" => "Hier finden Sie alle in Quarantäne befindlichen Dateien. Weiters können diese Dateien hier inspiziert und aus der Quarantäne entfernt werden.",
	"quarantine.view.no_files_found" => "<h5>Keine Dateien in Quarantäne. <img style='width: 16px; height: 16px;' src='/theme/icons/16/plesk/on.png'/></h5>",

	"quarantine.controller.no_files_found" => "Es wurden keine Dateien in Quarantäne gefunden.",
	"quarantine.controller.invalid_store" => "Der Quarantänestore konnte nicht gefunden werden.",
	"quarantine.controller.unquarantine" => "Aus der Quarantäne entfernen",
	"quarantine.controller.no_of_files" => "Anzahl der Dateien",
	"quarantine.controller.action" => "Aktion",

	"quarantine.controller.quarantined_on" => "In Quarantäne seit",
	"quarantine.controller.old_path" => "Entfernt aus",
	"quarantine.controller.filesize" => "Dateigröße",

	"quarantine.controller.no_files" => "Keine Datei ausgewählt. Bitte wählen Sie zumindest eine Datei aus.",

	"quarantine.controller.unquarantined" => "Die Datei %s wurde erfolgreich aus der Quarantäne entfernt",
	"quarantine.controller.bulk_unquarantined" => "Die ausgewählten Dateien wurden erfolgreich aus der Quarantäne entfernt",
];

