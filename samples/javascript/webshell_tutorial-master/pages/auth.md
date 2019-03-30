## Authentication and Sessions

Authentication and sessions are handled with the [`webshell/auth`](http://godoc.org/github.com/gokyle/webshell/auth)
package. 

### Password Based Authentication
The `auth` package will handle all password based authentication; you will need
to supply two functions: one function that takes a user identifier and returns
a pair of byte slices representing the stored password hash and salt; and a
second function that updates the stored hash and salt for a given user
identifier. If the update function doesn't create new users, a third function
capable of adding users to the database should be provided. For example:

```
func getUserAuth(username interface{}) (salt, hash []byte) {
        db, err := dbConnect()
        if err != nil {
                // error handling
        }
        defer db.Close()
        row := db.QueryRow("select salt, hash from users where username=?",
                username)
        err = row.Scan(&salt, &hash)
        if err != nil {
                // error handling
        }
        return
}
```

In order to make use of this function, we'll need to tell `auth` about it;
this is done by setting the LookupCredentials value in the package to our
function:

```
func init() {
        // other init code
        auth.LookupCredentials = getUserAuth
        // more init code
}
```

To check whether a password was authenticated, the `auth` package provides
`Authenticate`:

```
        // probably received username and password from webform
        if !auth.Authenticate(username, password) {
                // reject the login attempt
        }
        // user is logged in
```

What if we need to create a user or change the password? The `HashPass`
function takes a string password and returns `(salt, hash []byte)`:

```
func updateUserPass(username interface{}, salt, hash []byte) (err error) {
        db, err := dbConnect()
        if err != nil {
                return
        }
        defer db.Close()

        _, err = db.Exec("update users set salt=?,hash=? where username=?",
                salt, hash, username)
        return
}

// in the password-change function...
        if !auth.Authenticate(username, password) {
                // reject login attempt
        }
        salt, hash := auth.HashPass(new_password)
        if err := updateUserPass(username, salt, hash); err != nil {
                // handle the update failure
        }
        // user's password has been changed
```

The `auth` package aims to make password-based authentication as easy as
possible. It uses [PBKDF2](https://en.wikipedia.org/wiki/PBKDF2) with
HMAC-SHA1 and a high number of iterations. See the
[pbkdf2 package](https://github.com/gokyle/pbkdf2/) for more details.

### Sessions
The `auth` package can also handle basic authenticated sessions. Sessions
revolve around the `SessionStore` type:

```
var authStore auth.SessionStore
func init() {
        // other init code
        // create a session store with the name "example_app" for an app
        // that directly serves TLS (i.e. with `webshell.NewTLSApp(...)`)
        // and uses the default session length for sessions that don't
        // specify a different age.
        authStore = auth.CreateSessionStore("example_app", true, nil)
}

func authUser(w http.ResponseWriter, r *http.Request) {
        // load username, password, etc... from form
        // the_page should also be loaded as the byte slice content of the
        // page. This might occur after authentication if it is templated.

        // create a non-persistent (session-only) cookie and don't override
        // the max age.
        cookie, err := store.AuthSession(user, pass, false, "")
        if err != nil {
                // the user could not be authenticated due to something
                // other than a wrong password
        } else if cookie == nil {
                // bad password (or username)
        }
        // ensure you write the cookie before you finish sending the headers--
        // the cookie is sent as part of the headers.
        http.SetCookie(w, cookie)
        w.Write(the_page)
}
```

Once the session is over, the `DestroySession` method can be used to tear down
the sessions:

```
        // r is the *http.Request in the handler
        store.DestroySession(r)
```

Of course, if you have another means of authentication, you can force create a
new session:

```
        // create a non-persistent session
        cookie, err := store.NewSession()

        // create a persistent session for a week
        cookie, err := store.NewPSession("1w")
```

If you want to check whether a client has a valid session, use `CheckSession`:

```
        if !store.CheckSession(r) {
                // call the reauthentication code
        }
```

Finally, if you want to get the session ID (i.e. to correlate an auth session
some other data), use `SessionID`:

```
        session_id := store.SessionID(r)
```

That's all there is to it.
