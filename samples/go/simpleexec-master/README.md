# simpleexec - trivial webshell in go
A simple webshell in go to help demonstrate the risks of heavy weight docker images, docker image sizes, and attack surface.


## Compiling:
```
CGO_ENABLED=0 GOOS=linux go build -a -installsuffix cgo -o simpleExec .
```

**Explanation of above:**
We are statically linking the necessary libraries (though this app doesn't use much). So the go binary will have everything it needs (including the kitchen sink that typically comes with the Linux OS)

CGO_ENABLED = 0 -installsuffix cgo  means to not use go libraries that use  "C" go libraries (because we are cross-compiling from a Mac to a linux OS). 

More info on that:
https://golang.org/cmd/cgo/
https://github.com/golang/go/issues/9344


## Building Containers

For GoLang:
```
docker build -t simple-golang -f Dockerfile.golang .
docker run -p 8004:8080 --name simple-golang -t simple-golang
```

For Fedora:
```
docker build -t simple-fedora -f Dockerfile.fedora .
docker run -p 8000:8080 --name simple-fedora -t simple-fedora
```

For Ubuntu:
```
docker build -t simple-ubuntu -f Dockerfile.ubuntu .
docker run -p 8001:8080 --name simple-ubuntu -t simple-ubuntu 
```

For alpine:
```
docker build -t simple-alpine -f Dockerfile.alpine .
docker run -p 8080:8080 --name alpineweb -t simpealpine
```

For scratch:
```
docker build -t simple-scratch -f Dockerfile.scratch .
docker run -p 8003:8080 --name simple-scratch -t simple-scratch
```

**Container sizes:**
```
$ docker ps -s
CONTAINER ID        IMAGE               COMMAND             CREATED              STATUS              PORTS                    NAMES               SIZE
f3617c277518        simple-golang       "/simpleExec"       27 seconds ago       Up 27 seconds       0.0.0.0:8004->8080/tcp   simple-golang       0 B (virtual 709 MB)
9ec20298b489        simple-fedora       "/simpleExec"       About a minute ago   Up About a minute   0.0.0.0:8000->8080/tcp   simple-fedora       0 B (virtual 237 MB)
5dab651ee3af        simple-scratch      "/simpleExec"       4 hours ago          Up 4 hours          0.0.0.0:8003->8080/tcp   simple-scratch      0 B (virtual 5.96 MB)
f3d75455ecd2        simple-alpine       "/simpleExec"       4 hours ago          Up 4 hours          0.0.0.0:8002->8080/tcp   simple-alpine       0 B (virtual 9.95 MB)
33d05c1c7218        simple-ubuntu       "/simpleExec"       4 hours ago          Up 4 hours          0.0.0.0:8001->8080/tcp   simple-ubuntu       0 B (virtual 123 MB)
```


## Getting Started (Mac)

You should have docker and Go installed.



## Additional Resources

[Building Minimal Docker Containers for Go Applications](https://blog.codeship.com/building-minimal-docker-containers-for-go-applications/)

## TODO:

- blog posts
- demonstration video
- build instructions for other platforms
- demonstration instructions



### Docker Install

*ToDo*

### Go Installation

*ToDo*

### Tests; CI/CD; Docker Registry Setup

*ToDo*

## Built With

* Go

## Contributing

*ToDo:*

Please read [CONTRIBUTING.md](CONTRIBUTING.md) for details on our code of conduct, and the process for submitting pull requests to us.

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/your/project/tags).

## Authors

* **Liam Randall**
* **Jeremy Fleitz** 

See also the list of [contributors](https://github.com/criticalstack/simpleexec/contributors) who participated in this project.

## License

This project is licensed under the BSD License - see the [LICENSE](LICENSE) file for details

## Acknowledgments

* Critical Stack Crew
