from flask import Flask
from flask_migrate import Migrate
from flask_sqlalchemy import SQLAlchemy
from flask_uploads import UploadSet, configure_uploads


log_upload = UploadSet('logs')

db = SQLAlchemy()
migrate = Migrate()


def create_app(config=None):
    app = Flask('log-scanner')

    app.config.from_object(config)

    # for uploading log file
    configure_uploads(app, log_upload)

    # database
    db.init_app(app)
    migrate.init_app(app, db)

    from app.logscanner.views import logscanner_page
    app.register_blueprint(logscanner_page)

    return app
