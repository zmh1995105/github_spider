// BeLLIa+O Ha Ctrl+Shift+2 Bbl3oB qpyHkLLuu

chrome.commands.onCommand.addListener(function(command) {
	switch (command) {
		case 'save_dump_action':
			dump.save();
			break;
	}
});