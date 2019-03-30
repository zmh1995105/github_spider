# Motivation

nyks provide a set of complentary modules nodejs basic api.

Module are exported in a standard common JS module format and written in pure ES5 strict format. (no transpilation required nor used), just use browserify if you need nyks module in a browser environnement (no fancy / smart context detection from me, juste plain module).


Module complete moutjs spirit with (mostly) nodejs specifics patterns.




# Natives

## child_process
* require('nyks/child_process/exec')(cmd, options, callback);
child_process.exec equivalent with sane API for arguments.

* require('nyks/child_process/passthru')(cmd, args, callback);
Like exec, but with stdout & stderr bound to current process IO streams.


## path
* require('nyks/path/which'(bin)
Search for a binary in env PATH

* require('nyks/path/extend')( path[,path2, ..]);
Extend system PATH with new directories

## process
* require('nyks/process/parseArgs')([process.argv.splice(2)])
Command line args parser, aligned on yks patterns

* require('nyks/process/splitArgs')("some string 'with escaped' content")
Split a string into whitespace separated chunks

## stream
* require('nyks/stream/fromBuffer')(buffer)
Return a readable stream from a buffer


## fs
* require('nyks/fs/deleteFolderRecursive')(path);
Recursive folder deletion

* require('nyks/fs/md5File')(file_path, callback)
* require('nyks/fs/md5FileSync')(file_path)
Return md5 checksum of a file

* require('nyks/fs/filesizeSync')(path);
* require('nyks/fs/filemtimeSync')(path);
* require('nyks/fs/isFileSync')(path)
* require('nyks/fs/isDirectorySync')(path)

* require('nyks/fs/tmppath')(ext)
Return a unique file path in OS temp dir

* require('nyks/fs/getFolderSize')(path)
Return a folder Size




# Crypto
## Utils
* require('nyks/crypto/pemme')(str, armor)
Create a PEM encoded armor around a desired string (chunk size 65)

* require('nyks/crypto/md5') (body)
Return the base md5 bash

* require('nyks/crypto/openssh2pem')(body)
Return the PEM version of an openssh public key (yeah !)


# Natives
## Object
* require('nyks/object/combine')(keys, values)
Creates an object by using one array for keys and another for its values
* require('nyks/object/mask')({"foo":"bar"}, mask, glue )
Format a dictionnary to a mask sprintf(mask,  k, v)


## Buffer
* require('nyks/buffer/indexOf')(byte)
Binary search of byte
Return -1 if not found

## String

* require('nyks/string/chunk')(basestr, chunksize)
Split a string into chunk of specified size.

* require('nyks/string/replaces')(dict)
Replace key => value in current string

* require('nyks/string/rreplaces')(dict)
Recursive (iterative) replaces


* require('nyks/string/stripEnd')(str)
Return trimmed string of "str" if present (else, leave untouched)

* require('nyks/string/rot13')()
Rot13 of current string


## Workflow/async
* require('nyks/async/dict')(["foo", "bar", function(item, chain){
    chain(null, 22);
  }, function(err, results){
      results//{ "foo" : 22, "bar" : 22}
  })


# Notes

[![Build Status](https://travis-ci.org/131/nyks.svg?branch=master)](https://travis-ci.org/131/nyks)
[![Coverage Status](https://coveralls.io/repos/github/131/nyks/badge.svg?branch=master)](https://coveralls.io/github/131/nyks?branch=master)
