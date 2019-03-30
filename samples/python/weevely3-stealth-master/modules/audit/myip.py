from core.vectors import PhpCode, ShellCmd, ModuleExec, Os
from core.module import Module
from core import modules


class Myip(Module):
    """Get my ip."""

    def init(self):

        self.register_info(
            {
                'author': [
                    'Sander Ferdinand'
                ],
                'license': 'MIT'
            }
        )

    def run(self):
        result = PhpCode("""print $_SERVER['REMOTE_ADDR'];""").run()
        result = "$_SERVER['REMOTE_ADDR']: " + result
        return result.rstrip('\n')
