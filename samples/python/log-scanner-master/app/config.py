import os


class Config:
    DEBUG = False
    TESTING = False
    SECRET_KEY = os.environ.get('LOG_SCANNER_SECRET_KEY')
    UPLOADED_LOGS_DEST = os.environ.get('LOG_SCANNER_UPLOAD', '/tmp')
    UPLOADED_LOGS_ALLOW = ('zip', 'log')
    SQLALCHEMY_TRACK_MODIFICATIONS = False
    SQLALCHEMY_DATABASE_URI = os.environ.get('LOG_SCANNER_DB_URI')

class Development(Config):
    DEBUG = True


class Testing(Config):
    Testing = True


class Production(Config):
    pass
