import re


def make_regex(regexes):
    """
    Compile regexes to be used in scanner.

    :param regexes: list of regex
    :return: compiled regex
    """
    return re.compile('(%s)' % ('|'.join(regexes)), re.IGNORECASE|re.MULTILINE)


def make_scanner(regex):
    """
    Make log scanner for scanning potential attack using regex rule.

    :param regex: regex rule for detecting attack in the log line
    :return: function that scan for the attack in log file using the regex
    """
    def scanner(line):
        return True if re.search(regex, line) else False
    return scanner


sqli_regex = make_regex([
    '--',                          # sql comment
    '\;',                          # end of statement
    '\/\*', '\*\/',                # block comment
    '(char|concat|cast|eval).*\(', # sql functions
])

file_inclusion_regex = make_regex([
    ':\/\/',      # protocol
    '(\.+\/)+',   # path ./ or ../
])

webshell_regex = make_regex([
    'cmd=',     # common query parameter
    'passwd',   # password file
    'system32'  # windows system32 directory
    'whoami',   # common command
    '\*\..*',   # file extension e.g. *.php
    '(\.+\/)+', # path ./ or ../
])

# scanners
sqli_scanner = make_scanner(sqli_regex)
file_inclusion_scanner = make_scanner(file_inclusion_regex)
webshell_scanner = make_scanner(webshell_regex)
