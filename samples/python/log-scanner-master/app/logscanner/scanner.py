import os
import re
from datetime import datetime
from urllib import parse
from zipfile import ZipFile, is_zipfile

from flask import current_app
from geolite2 import geolite2

from app import db
from app.logscanner.regex_scanner import sqli_scanner, file_inclusion_scanner, webshell_scanner
from .models import Entry, Attack


def scan_log(filename):
    scanners = {'sqli': sqli_scanner,
                'fileinc': file_inclusion_scanner,
                'webshell': webshell_scanner}
    if is_zipfile(filename):
        with ZipFile(filename) as z:
            for name in z.namelist():
                with z.open(name) as f:
                    scan_iis_log(f, scanners)
    else:
        with open(filename, 'rt', encoding='iso-8859-15') as f:
            scan_iis_log(f, scanners)

    os.unlink(filename)


def get_ip_country(ip):
    reader = geolite2.reader()
    try:
        return reader.get(ip)['registered_country']['names']['en']
    except:
        return None


def scan_iis_log(log, scanners):
    """
    Scan IIS log file for attacks

    :param log: log file
    :param scanners: list of scanner to scan attack in log file
    :return: None
    """
    # provided log file lines is ended with four integers
    end_line_regex = re.compile('\d+ \d+ \d+ \d+$')

    log_regex = re.compile(r'''
        (?P<date>\d{4}-\d{2}-\d{2})\ 
        (?P<time>\d{2}:\d{2}:\d{2})\ 
        (?P<sip>\d+\.\d+\.\d+\.\d+)\ 
        (?P<method>\w+)\ 
        (?P<uri_query>(.|\s)+?)\  
        (?P<sport>80|443)\ 
        (?P<username>.+)\ 
        (?P<cip>\d+\.\d+\.\d+\.\d+)\ 
        (?P<useragent>.+)\ 
        (?P<referer>(.|\s)+?)\ 
        (?P<status>\d+)\ 
        (?P<substatus>\d+)\ 
        (?P<win32status>\d+)\ 
        (?P<timetaken>\d+)''', re.IGNORECASE|re.MULTILINE|re.VERBOSE)

    with log as f:
        process_line = ''
        for i, line in enumerate(f):
            try:
                # ignore comment
                strline = line.decode('iso-8859-15') if type(line) == bytes else line
                if strline.startswith('#'): continue

                # line to process
                process_line += strline

                #if not re.search(end_line_regex, line): continue

                # accumulate process line if line is not ended properly
                match = re.match(log_regex, process_line)
                if not match: continue

                parsed_log = match.groupdict()
                # get query from uri_query
                uri = parsed_log['uri_query'].split(' ')[0]
                query = ' '.join(parsed_log['uri_query'].split(' ')[1:])
                country = get_ip_country(parsed_log['cip'])

                # insert into db
                entry = Entry(
                    timestamp=datetime.strptime('{} {}'.format(parsed_log['date'], parsed_log['time']),
                                                '%Y-%m-%d %H:%M:%S'),
                    sip=parsed_log['sip'],
                    method=parsed_log['method'],
                    uri=uri,
                    query=query,
                    sport=parsed_log['sport'],
                    username=parsed_log['username'],
                    cip=parsed_log['cip'],
                    useragent=parsed_log['useragent'],
                    referer=parsed_log['referer'],
                    status=parsed_log['status'],
                    substatus=parsed_log['substatus'],
                    win32status=parsed_log['win32status'],
                    timetaken=parsed_log['timetaken'],
                    country=country
                )

                db.session.add(entry)

                for label, scanner in scanners.items():
                    scan = scanner(parse.unquote(query))
                    if scan:
                        attack = Attack(entry=entry, ip=entry.cip, type=label, country=country)
                        db.session.add(attack)

                if i % 10000 == 0:
                    db.session.commit()

                # reset
                process_line = ''
            except Exception as e:
                current_app.logger.warning('Exception {}'.format(e))
        db.session.commit()
