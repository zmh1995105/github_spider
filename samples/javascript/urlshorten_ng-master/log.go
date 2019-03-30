package main

import (
	"fmt"
	"net/http"
	"os"
	"path/filepath"
	"regexp"
	"time"
)

const (
	logdate_fmt   = "20060102"
	timestamp_fmt = "2006-01-02T15:04:05Z"
)

var (
	error_logfile  string
	ipScrub        = regexp.MustCompile("^([^:]):.*$")
	access_logfile = "logs/access"
)

func getTimestamp() string {
	return time.Now().Format(timestamp_fmt)
}

func getClientIp(r *http.Request) string {
	if r.Header.Get("X-Real-Ip") == "" {
		return r.RemoteAddr
	} else {
		return r.Header.Get("X-Real-Ip")
	}
	return r.RemoteAddr
}

func LogRequest(page *Page, r *http.Request) {
	client_ip := getClientIp(r)
	timestamp := getTimestamp()
	log_line := fmt.Sprintf("%s %s %s %s\n", client_ip, timestamp,
		r.Method, r.URL.Path)
	fmt.Printf(log_line)
	if err := writeLogEntry(access_logfile, log_line); err != nil {
		fmt.Printf("[!] error writing to %s: %s\n",
			logfileName(access_logfile), err.Error())
	}
}

func LogError(page *Page, r *http.Request) {
	client_ip := getClientIp(r)
	timestamp := getTimestamp()
	log_line := fmt.Sprintf("%s %s %s %s [!] %s\n", client_ip, timestamp,
		r.Method, r.URL.Path, page.Msg)
	fmt.Printf(log_line)
	if err := writeLogEntry(error_logfile, log_line); err != nil {
		fmt.Printf("[!] error writing to %s: %s\n",
			logfileName(error_logfile), err.Error())
	}
}

func logfileName(logfile string) string {
	tmpname := fmt.Sprintf("%s-%s.log", logfile,
		time.Now().Format(logdate_fmt))
	name, err := filepath.Abs(tmpname)
	if err != nil {
		name = filepath.Base(tmpname)
	}
	return name
}

func nonExist(logfile string) string {
	return fmt.Sprintf("open %s: no such file or directory", logfile)
}

func writeLogEntry(logfile, line string) (err error) {
	logfile = logfileName(logfile)
	file, err := os.OpenFile(logfile, os.O_WRONLY|os.O_APPEND, 0600)
	if err != nil && err.Error() == nonExist(logfile) {
		file, err = os.Create(logfile)
	}

	if err != nil {
		return
	}
	defer file.Close()

	_, err = file.WriteString(line)
	return
}
