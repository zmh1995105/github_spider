LIB_DIR="/usr/local/lib/"
BIN_DIR="/usr/local/bin/"

all: install

install: clean
	@echo "[+] Installing wizhack's script"
	@cp $(pwd)bin/wizhack.py $(BIN_DIR)wizhack
	@echo "[+] Installing wizhack's lib directory"
	@cp -r lib/wizhack $(LIB_DIR)
clean:
	@echo "[+] Cleaning wizhack's lib directory"
	@if [ -d $(LIB_DIR)wizhack/ ]; then rm -r $(LIB_DIR)wizhack; else echo "[-] Wizhack's lib directory doesn't exist."; fi

remove:
	@echo "[+] Deleting wizhack's lib directory"
	@rm -r $(LIB_DIR)wizhack
	@echo "[+] Deleting whizhack's script"
	@rm $(BIN_DIR)wizhack
