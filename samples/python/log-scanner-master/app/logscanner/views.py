import flask_uploads
import os
from flask import Blueprint, render_template, request, flash, redirect, url_for
from sqlalchemy import func

from app.logscanner.scanner import scan_log
from app import log_upload, db
from .models import Entry, Attack

logscanner_page = Blueprint('log_scanner_page', __name__,
                            template_folder='templates')


@logscanner_page.route('/', endpoint='index')
def index():
    return render_template('index.html')


@logscanner_page.route('/uniq_ip', endpoint='uniq_ip')
def uniq_ip():
    entries = db.session.query(Entry.cip).distinct(Entry.cip).all()
    return render_template('list_ip.html', entries=entries)

@logscanner_page.route('/uniq_ip_country', endpoint='uniq_ip_country')
def uniq_ip_country():
    entries = db.session.query(Entry.cip, Entry.country,
                               func.count(Entry.cip))\
        .group_by(Entry.cip, Entry.country).all()
    return render_template('list_ip_country.html', entries=entries)


@logscanner_page.route('/ip_activity/<string:ip>', endpoint='ip_activity')
def ip_activity(ip):
    entries = db.session.query(Entry).filter_by(cip=ip).order_by(Entry.timestamp).all()
    return render_template('list_ip_activity.html', ip=ip, entries=entries)


@logscanner_page.route('/attacks', endpoint='attacks')
@logscanner_page.route('/attacks/<string:type>', endpoint='attacks')
def attacks(type=None):
    entries = db.session.query(Attack)
    if type is not None:
        entries = entries.filter_by(type=type).all()
    return render_template('list_attacks.html', type=type, entries=entries)


@logscanner_page.route('/upload', methods=['GET', 'POST'], endpoint='upload')
def upload():
    if request.method == 'POST':
        log_file = request.files.get('log_file', None)
        if log_file is None:
            flash('Log file not found!', 'error')
            return redirect(request.url)

        try:
            filename = log_upload.save(log_file)

            # send the file to be scanned
            scan_log(os.path.join(log_upload.config.destination, filename))

            flash('Log uploaded and scanned...', 'success')
        except flask_uploads.UploadNotAllowed:
            flash('File not allowed for upload', 'error')
        return redirect(url_for('.index'))
    return render_template('index.html')
