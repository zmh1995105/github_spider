FROM python:3.6-slim

RUN mkdir /app
WORKDIR /app
ADD . /app/
RUN pip install -r requirements.txt
ENV LOG_SCANNER_CONFIG=app.config.Production
ENV LOG_SCANNER_UPLOAD=/tmp
ENV FLASK_APP=manage.py
EXPOSE 5000
CMD ["sh", "entrypoint.sh"]
