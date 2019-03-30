# log-scanner
Scan IIS log for SQL injection, file inclusion and webshell attack.

## User Guide

### How to run

To run this application you need `docker` and `docker-compose`.
1. [docker installation](https://docs.docker.com/engine/installation/)
2. [docker-compose installation](https://docs.docker.com/compose/install/)
3. Clone this [repository](https://github.com/desdulianto/log-scanner.git)
4. Run with docker-compose:
- CD into cloned repository (defaults to `log-scanner`)
```sh
cd log-scanner
```
- Activate container:
```sh
docker-compose up -d
```
wait a bit for the container to be fully up
- Get IP address
```sh
docker inspect -f '{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' log-scanner
```
5. Access the application using browser to IP address from last step on port 5000, e.g. `http://<log-scanner-ip>:5000`

### Application menu
Access the web on http://<ip>:5000.

1. The application home page:
![Home](docs/images/home.png)

You can upload log file to scan from here. If the log size is big, please wait until the scanning process end (it can be a while, depends on your log file size).

2. Unique IP List
![Unique IP List](docs/images/uniq_ip.png)

You find unique IP list found in the log file. You can click the IP to view the activities of that IP.

![IP activities](docs/images/ip_activities.png)

Orange background signifies possible attack has been detected.

3. Unique IP - Country List
![Unique IP Country List](docs/images/uniq_ip_country.png)

You find unique IP with the registered country of that IP and number of hits. You can click the IP to view the activities of that IP.

4. Attacks List
![Attacks List](docs/images/attacks.png)

You will find all the attack detected on the log file. You can click the IP to view the activities of that IP.

This application currently detects three types of attack:
- SQL Inject (`sqli`)
- File inclusion (`fileinc`)
- Web shell (`webshell`)


## Development Guide

To start development on host machine, you will need to install:
1. `virtualenv`
2. `postgresql` for database

Use `virtualenv` to ease development environment.
1. Start new virtualenv:
```sh
mkvirtualenv log-scanner
```
or activate existing virtualenv.
2. Install the dependency packages:
```sh
pip install -r requirements.txt
```
3. Set environment variables:
- `export LOG_SCANNER_CONFIG=app.config.Development`
- `export LOG_SCANNER_SECRET_KEY=secret`
- `export LOG_SCANNER_UPLOAD=/tmp`
- `export LOG_SCANNER_DB_URI=postgres://postgres:postgres@localhost:5432/logscanner` or adjust to your `postgresql` configuration
- `export FLASK_APP=manage.py`
4. Create tables on database, from code root path:
```sh
flask db upgrade
```
5. Run the application:
```sh
flask run
```
6. Access the application using browser on `http://localhost:5000`

or you can using docker environment:

1. Edit the code like usual.
2. Run `docker-compose up -d --build` to build new image and activate the containers. You need to do this everytime you make changes to the source code.

