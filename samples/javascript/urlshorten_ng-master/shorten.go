package main

/*
 * the URL shortening code
 */

import (
	"crypto/rand"
	"math/big"
)

type ShortIdValidator func(shortened string) (valid bool, err error)

// length of generated short URL ID
const ShortLen = 6

type short_index uint

func Shorten() (shortid string) {
	const symbols = "abcdefghijklmnopqrstuvwxyz0123456789"
	for i := 0; i < ShortLen; i++ {
		n, err := rand.Int(rand.Reader, big.NewInt(int64(len(symbols))))
		if err != nil {
			shortid = ""
			return
		} else {
			index := n.Int64()
			shortid += string(symbols[index])
		}
	}
	return
}

// Generate a short code for the given URL.
// ShortIdValidator should return ok, err; ok should be true if the short ID
// is acceptable, and the function should take a short id.
func ShortenUrl(validator ShortIdValidator) (shortid string, err error) {
	for {
		var ok bool
		shortid = Shorten()
		ok, err = validator(shortid)
		if err != nil {
			break
		} else if ok {
			break
		}
	}
	return
}

func ValidateShortenedUrl(shortid string) (ok bool, err error) {
	url, err := lookupShortCode(shortid)
	if err != nil {
		return
	} else if len(url) == 0 {
		ok = true
	}
	return
}
