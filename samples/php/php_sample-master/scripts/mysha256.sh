#!/bin/bash

if test $# -lt 2
then
    echo "Usage: $0 dir_name sha_file"
    exit 1
fi


find $1 -type f -name \*.php -exec sha256sum {} \; | sort | tee $2
