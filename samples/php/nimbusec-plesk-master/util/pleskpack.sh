#!/bin/bash
#
# Minimized Plesk extension packing script
#
# Usage: bash pleskpack.sh [<source_path>] [<dest_path>]
# Examples:
#
#   expects the current dir (pwd) to have an src/ folder; saves the zipped in $HOME/tmp
#
#       bash pleskpack.sh
#
#   expects /path/to/extension to have an src/ folder; saves the zipped in /home/tmp
#
#       bash pleskback.sh /path/to/extension /home/tmp
#

extension_name="nimbusec-agent-integration"

root=$1
destination=$2

# check root of project
if [[ ! $root ]]; then
    root=../
fi
root=$(realpath $root)

if [[ ! -d $root/src ]]; then
    >&2 printf "$root is not a valid plesk extension project\n"
    exit 1
fi

# check destination
if [[ ! $destination ]]; then
    destination="/tmp"
fi
destination=$(realpath $destination)

if [[ ! -d $destination ]]; then
    >&2 printf "$destination is not a valid directory\n"
    exit 1
fi

# start zipping
cd $root/src
zip -rq $destination/$extension_name.zip ./
cd - > /dev/null

printf "$destination/$extension_name.zip"

function realpath () {
    echo $(python -c 'import os,sys;print(os.path.realpath(sys.argv[1]))' $1)
}
