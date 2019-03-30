setup: clean build
	@echo "Done!"

clean:
	@-rm js/wsh.js
	@echo Cleaned Out Libraries

build: js/wsh.js
	@echo Browserified code
js/wsh.js:
	browserify -o js/wsh.js src/main.js