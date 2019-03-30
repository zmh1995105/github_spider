## Simple Go-based webshell for Docker
By default http server listens port 9090. <br />
If using GET commands have to be seperated by comma symbol i.e. `ls,-al,|,grep,Dockerfile`<br />
If using POST format: 
```json
{"command" : "ls -al | grep Dockerfile"}
```
#### Build Go binary
```sh
go build -o run run.go
```
#### Image build
```sh
docker build --tag webshell .
```
#### Docker image run
```sh
docker run -it --rm -p 9090:9090 --name webshell webshell
```
#### Usage
1. GET
- Shell command output:
```sh
curl -XGET <localhost>:9090/cat,run.py
```
- Python3 script execution
```sh
curl -XGET <localhost>:9090/python3,run.py
```
- Python3 direct command execution
```sh
curl -XGET <localhost>:9090/python3,-c,\'print\(\"foo\"\)\'
```
2. POST
- Shell command output:
```sh
curl -XPOST <localhost>:9090/ -d '{"command" : "cat run.py"}'
```
- Python3 script execution
```sh
curl -XPOST <localhost>:9090/ -d '{"command" : "python3 run.py"}'
```
- Python3 direct command execution
```sh
curl -XPOST <localhost>:9090/ -d '{"command":"python3 -c \"print(\\\"foo\\\")\" "}'
```
