import os

from app import create_app

app = create_app(os.environ.get('LOG_SCANNER_CONFIG'))

if __name__ == '__main__':
    app.run()
