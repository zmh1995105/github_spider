import glob

def search_files():
	Files=glob.glob("*.py")+glob.glob("*.pyw")
	return Files