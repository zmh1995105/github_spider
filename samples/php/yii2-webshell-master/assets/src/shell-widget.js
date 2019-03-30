(function ($) {

	//plugin implementation
	$.fn.processWidget = function (options) {

		var settings = $.extend({}, $.fn.processWidget.defaultSettings, options);
		var thisWidget = this;
		var consoleContainer = $(thisWidget);
		var url = consoleContainer.attr('data-url');
		var id = consoleContainer.attr('id');
		var triggerButtons = $('[' + settings.buttonAttributeName + '=' + id + ']');

		//attach event handler which executes the request
		thisWidget.on(settings.eventRunName, function() {
			//prepare widget
			consoleContainer.empty();
			triggerButtons.attr('disabled', 'disabled');
			console.log('processWidget: performing request to ' + url);

			//the actual ajax call
			$.ajax({
				url: url,

				//complete unlocks all buttons
				complete: function (jqXHR, textStatus) {
					console.log('processWidget: request completed with ' + textStatus);
					triggerButtons.attr('disabled', null);

					var processExitCode = null;
					var responseText = jqXHR.responseText;
					if (responseText.length > 0 && responseText.indexOf("\n") != -1) {
						var lines = responseText.split("\n");
						processExitCode = lines[lines.length - 1].trim();
					}

					settings.completeCallback.call(thisWidget, jqXHR.status, processExitCode, responseText);
				},

				//attach custom event for ready state changes
				beforeSend: function (jqXHR, settings) {
					var self = this;
					var xhr = settings.xhr;
					settings.xhr = function () {
						var output = xhr();
						output.onreadystatechange = function () {
							if (typeof(self.readyStateChanged) == "function") {
								self.readyStateChanged(this);
							}
						};
						return output;
					};
				},

				//custom event fired via xhr-object
				readyStateChanged: function (xhr) {
					console.log('processWidget: readyStateChanged to ' + xhr.readyState);

					if (xhr.readyState == 3) {
						consoleContainer.empty();
						consoleContainer.html(settings.outputCallback.call(thisWidget, xhr.response));
					}
				},
			});
		});

		//assign buttons
		triggerButtons.click(function (event) {
			console.log('processWidget: executing via button click');
			event.preventDefault();
			thisWidget.trigger(settings.eventRunName);
			return false;
		});

		//check autorun
		var valAutorun = this.attr('data-autorun');
		if (valAutorun == '1' || valAutorun == 'true') {
			console.log('processWidget: executing autorun');
			this.trigger(settings.eventRunName);
		}

	};

	//default settings for widget
	$.fn.processWidget.defaultSettings = {
		eventRunName: 'processWidget::execute',
		buttonAttributeName: 'data-shell-widget-run',
		outputCallback: function (output) {
			return output.replace(/(?:\r\n|\r|\n)/g, '<br />');
		},
		completeCallback: function (httpStatusCode, processExitCode, fullOutput) {

		}
	};

} (jQuery));
