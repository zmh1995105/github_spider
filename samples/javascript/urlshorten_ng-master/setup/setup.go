package main

import (
	"bitbucket.org/taruti/pbkdf2"
	"bufio"
	"crypto/rand"
	"database/sql"
	"flag"
	"fmt"
	_ "github.com/mattn/go-sqlite3"
	"log"
	"os"
	"strings"
)

const saltSize = 16

func die(err error, rv int) {
	fmt.Printf("[!] fatal: %s\n", err.Error())
	os.Exit(rv)
}

func main() {
	fDatabase := flag.String("d", "", "database file")
	fCreate := flag.Bool("c", false, "create the database file")
	fAddUser := flag.Bool("a", false, "add a user")
	fRemUser := flag.Bool("r", false, "remove a user")
	flag.Parse()
	if *fDatabase == "" {
		flag.PrintDefaults()
		os.Exit(1)
	}

	if !*fCreate && !*fAddUser && !*fRemUser {
		flag.PrintDefaults()
		os.Exit(1)
	}
	dbFile := *fDatabase
	db, err := sql.Open("sqlite3", dbFile)
	if err != nil {
		die(err, 1)
	}

	if *fCreate {
		fmt.Println("[+] creating ", dbFile)
		err = createDB(db)
		if err != nil {
			die(err, 1)
		}
	}

	if *fAddUser {
		err = addUser(db)
		if err != nil {
			die(err, 1)
		}
	}

	if *fRemUser {
		err = removeUser(db)
		if err != nil {
			die(err, 1)
		}
	}
}

func createDB(db *sql.DB) error {
	var err error
	os.Remove(os.Args[1])
	queries := []string{`create table shortened 
           (sid text primary key not null, url text not null)`,
		`create table users 
               (username text primary key not null,
                hashed text not null,
                salt text not null)`,
		`create table views (
                        sid text not null,
                        views integer not null,
                        primary key (sid))`,
		"delete from shortened",
		"delete from users",
		"delete from views"}
	for _, query := range queries {
		_, err := db.Exec(query)
		if err != nil {
			fmt.Printf("[!] %s: %s\n", query, err.Error())
			return err
		}
	}
	return err
}

func readPrompt(prompt string) (input string, err error) {
	fmt.Printf(prompt)
	rd := bufio.NewReader(os.Stdin)
	line, err := rd.ReadString('\n')
	if err != nil {
		return
	}
	input = strings.TrimSpace(line)
	return
}

func addUser(db *sql.DB) (err error) {
	fmt.Println("[+] adding user")
	var user, password string
	user, err = readPrompt("user name: ")
	if err != nil {
		return
	}
	password, err = readPrompt("password: ")
	if err != nil {
		return
	}
	salt := generateSalt(saltSize)
	if len(salt) != saltSize {
		fmt.Printf("[!] salt generation failed")
		return fmt.Errorf("failed to generate salt")
	}
	fmt.Printf("[+] adding user: '%s'\n", user)
	passHash := pbkdf2.HashPasswordWith([]byte(salt), password)
	query := "insert into users values (?, ?, ?)"
	res, err := db.Exec(query, user, passHash.Hash, passHash.Salt)

	var n int64
	if err != nil {
		return
	}
	if n, err = res.RowsAffected(); err != nil {
		return
	} else if n < 1 {
		fmt.Println("[!] failed to add user")
	} else {
		fmt.Println("[+] successfully added user ", user)
	}
	return nil
}

func removeUser(db *sql.DB) (err error) {
	var user string
	user, err = readPrompt("user name: ")
	if err != nil {
		return
	}
	res, err := db.Exec("delete from users where username = ?",
		user)
	if err != nil {
		return
	}
	var n int64
	if n, err = res.RowsAffected(); err != nil {
		return
	} else if n < 1 {
		err = fmt.Errorf("user not found")
	} else {
		fmt.Println("[+] successfully removed user ", user)
	}
	return
}

func generateSalt(chars int) (salt string) {
	saltBytes := make([]byte, chars)
	nRead, err := rand.Read(saltBytes)
	if err != nil {
		log.Println("error generating salt: ", err.Error())
	} else if nRead < chars {
		salt = ""
		log.Println("short read generating salt")
	} else {
		salt = string(saltBytes)
	}
	return
}
