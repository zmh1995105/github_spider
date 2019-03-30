package main

import (
	"encoding/json"
	"flag"
	"fmt"
	"github.com/samgha/vipas/vipaser"
	"os"
	"os/signal"
	"path/filepath"
	"syscall"
)

var (
	signatureDB = flag.String("db", "https://raw.githubusercontent.com/emposha/PHP-Shell-Detector/master/shelldetect.db", "image file path")
	scanPath    = flag.String("path", "xiao.php.txt", "scan path")
)

func detect(path string, ch chan vipaser.Result, quit chan bool, errch chan error) {
	supportExt := map[string]bool{
		".php":  true,
		".asp":  true,
		".aspx": true,
		".txt":  true,
	}

	stat, err := os.Stat(path)
	if err != nil {
		fmt.Println(err)
		errch <- err
		quit <- false
		return
	}

	vp, err := vipaser.New(*signatureDB)
	if err != nil {
		fmt.Println(err)
		quit <- false
		return
	}
	if stat.IsDir() {
		filepath.Walk(path, func(path string, f os.FileInfo, err error) error {
			if f == nil {
				return nil
			}
			if f.IsDir() {
				return nil
			}
			if !supportExt[filepath.Ext(path)] {
				return nil
			}
			rs, err := vp.Detect(path, true)
			if err != nil {
				errch <- err
				quit <- false
				return err
			}
			ch <- rs
			return nil
		})
	} else {
		fmt.Println(path)
		if !supportExt[filepath.Ext(path)] {
			return
		}
		rs, err := vp.Detect(path, true)
		if err != nil {
			errch <- err
			quit <- false
			return
		}
		ch <- rs
	}
	quit <- true
}

func main() {
	flag.Parse()

	ch := make(chan vipaser.Result)
	doneChan := make(chan bool, 1)
	term := make(chan os.Signal, 1)
	errChan := make(chan error)

	signal.Notify(term, syscall.SIGINT, syscall.SIGTERM)

	go detect(*scanPath, ch, doneChan, errChan)

	for {
		select {
		case err := <-errChan:
			fmt.Println(err)
		case rs := <-ch:
			if str, err := json.MarshalIndent(rs, "", "  "); err == nil {
				fmt.Println((string)(str))
			}
			continue
		case <-term:
			close(doneChan)
		case <-doneChan:
			os.Exit(0)
		}
	}
}
