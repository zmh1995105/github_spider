FROM python:3.7

WORKDIR /app

ADD run /app/serve
ADD run.py /app/

RUN chmod +x /app/serve

ENTRYPOINT ["./serve"]

