package main

import (
	"database/sql"
	"fmt"
	_ "github.com/mattn/go-sqlite3"
)

var dbFile = "data/urlshorten.db"

func dbConnect() (db *sql.DB, err error) {
	db, err = sql.Open("sqlite3", dbFile)
	return
}

func lookupShortCode(sid string) (url string, err error) {
	if sid == "index.html" || sid == "/" {
		return "", fmt.Errorf("URL already exists")
	}
	db, err := dbConnect()
	if err != nil {
		return
	}
	defer db.Close()
	var rows *sql.Rows
	rows, err = db.Query("select url from shortened where sid=$1", sid)
	if err != nil {
		return
	}

	for rows.Next() {
		rows.Scan(&url)
	}
	err = rows.Err()
	return
}

func urlToSid(url string) (sid string, err error) {
	db, err := dbConnect()
	if err != nil {
		return
	}
	defer db.Close()
	var rows *sql.Rows
	rows, err = db.Query("select sid from shortened where url=?", url)
	if err != nil {
		return
	} else {
		for rows.Next() {
			rows.Scan(&sid)
		}
		err = rows.Err()
	}
	return
}

func getPassHash(username interface{}) (salt, hash []byte) {
	db, err := dbConnect()
	if err != nil {
		return
	}
	defer db.Close()
	query := "select * from users where username=?"
	rows, err := db.Query(query, username)
	if err != nil {
		return
	}

	var user string
	for rows.Next() {
		err = rows.Scan(&user, &hash, &salt)
		if err != nil {
			hash = []byte("")
			salt = []byte("")
			return
		}
	}
	if err = rows.Err(); err != nil {
		hash = []byte("")
		salt = []byte("")
		return
	}
	return
}

func insertShortened(sid, url string) (err error) {
	db, err := dbConnect()
	if err != nil {
		return
	}
	defer db.Close()
	_, err = db.Exec("insert into shortened values (?, ?)",
		sid, url)
	if err != nil {
		return
	}
	_, err = db.Exec("insert into views values (?, 0)", sid)
	return
}

func countShortened() (count int, err error) {
	db, err := dbConnect()
	if err != nil {
		return
	}
        defer db.Close()
	query := "select count(*) from shortened"
	rows := db.QueryRow(query)
	err = rows.Scan(&count)
	return
}

func updateSidViews(sid string) (err error) {
	db, err := dbConnect()
	if err != nil {
		return
	}
        defer db.Close()
	_, err = db.Exec("update views set views = views + 1 where sid=?",
		sid)
	return
}

func getSidViews(sid string) (count int, err error) {
	db, err := dbConnect()
	if err != nil {
		return
	}
        defer db.Close()
	rows := db.QueryRow("select views from views where sid=?", sid)
	err = rows.Scan(&count)
	return
}

func getAllViews() (count int, err error) {
	db, err := dbConnect()
	if err != nil {
		return
	}
        defer db.Close()
	rows := db.QueryRow("select sum(views) from views")
	err = rows.Scan(&count)
	return
}

func dbChangePass(username string, salt, hash []byte) (err error) {
	db, err := dbConnect()
	if err != nil {
		return
	}
        defer db.Close()
	res, err := db.Exec("update users set hashed=?,salt=? where username=?",
		hash, salt, username)
	var n int64
	if err != nil {
		return
	} else if n, err = res.RowsAffected(); err != nil {
		return
	} else if n != 1 {
		err = fmt.Errorf("database was not updated.")
	}
	return
}

func userExists(username string) (ok bool, err error) {
	db, err := dbConnect()
	if err != nil {
		return
	}
        defer db.Close()
	var n int
	rows := db.QueryRow("select count(*) from users where username=?",
		username)
	err = rows.Scan(&n)
	if err != nil {
		return
	}
	ok = (n == 1)
	return
}

func addUserToDb(username string, salt, hash []byte) (err error) {
	query := "insert into users values (?, ?, ?)"
	db, err := dbConnect()
	if err != nil {
		return
	}
        defer db.Close()
	_, err = db.Exec(query, username, hash, salt)
	return
}
