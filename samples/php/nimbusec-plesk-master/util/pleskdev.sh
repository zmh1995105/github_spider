#!/bin/bash
#
# Plesk development deployer (Pdd)
#
# Usage: bash pleskdev.sh <params> [<source_path>]
# Params:
#       -d <domain> Name of the domain to create (without scheme)
#           e.g test.org or www.test.org
#
#       -f <files> A string of file paths to deploy on plesk seperated by ","
#           e.g /tmp/one.php,/tmp/two.php
#
#       -s <subdomain> A string of subdomain prefixes seperated by ","
#           e.g a,b,c,d which creates a.<domain>, b.<domain>, ...
#
# Example: bash pleskdev.sh -d test.at -f menace.php -s a,b,c
#
# Pdd starts and installs the given extension at <source_path> within a docker container (image: plesk/plesk) on port 8880.
# Given resources like domains, subdomains or resources will be installed on the container. If parameters are ommited, it will use predefined ones.
#
# Utilizes the pleskpack.sh to pack the extension correctly (expect it to be in the same directory)

plesk_domain_user="naive"
plesk_domain_pw="thisIsASecurePassword1249$"
plesk_domain_ip="172.17.0.2"

extension_name="nimbusec-agent-integration"
tmp=$HOME/tmp

# parse command line args
while [[ $# -gt 1 ]]
do
key="$1"

    case $key in
        -d)
        domain="$2"
        shift 
        ;;
        -f)
        IFS=', ' read -r -a files <<< "$2"
        shift 
        ;;
        -s)
        IFS=',' read -r -a subdomains <<< "$2"
        shift
        ;;
        *)
        ;;
    esac
shift
done

# set default values
if [[ ! $domain ]]; then
    domain="test.at"
fi

if [[ ! $subdomains ]]; then
    subdomains[0]="a"
    subdomains[1]="b"
    subdomains[2]="c"
fi

# check root of project
root=$1
if [[ ! $root ]]; then
    root=../
fi
root=$(realpath $root)

if [[ ! -d $root/src ]]; then
    >&2 printf "$root is not a valid plesk extension project\n"
    exit 1
fi

# zip project
mkdir -p $tmp
extension_zipped_path=$(bash pleskpack.sh $root $tmp)
printf "zipped archive at $extension_zipped_path\n"


# kill running docker instances
instances=$(docker ps --filter "ancestor=plesk/plesk" --format "{{.ID}}")
if [[ $instances ]]
then
    for instance in $instances
    do
        docker kill $instance > /dev/null
        docker rm $instance > /dev/null
        printf "killed running instance with ID $instance\n"
    done
fi

# start docker container
docker run -d -p 8880:8880 plesk/plesk > /dev/null
if [ $? -eq 0 ]
then
    id=$(docker ps --filter "ancestor=plesk/plesk" --format "{{.ID}}")
    printf "created new instance with ID $id\n"
else
    exit 1
fi

# copy extension
docker cp $extension_zipped_path "$id:/tmp"

# wait for copy to finish
sleep 2
docker exec $id "plesk" "bin" "extension" "--install" "/tmp/$extension_name.zip"

# create domain
docker exec $id "plesk" "bin" "domain" "-c" "$domain" "-hosting" "true" "-ip" "$plesk_domain_ip" "-login" "$plesk_domain_user" "-passwd" "$plesk_domain_pw"

# copy files to webspace
for file in "${files[@]}"
do
    dst="/var/www/vhosts/$domain/httpdocs"

    docker cp $file "$id:$dst"
    printf "successfully copied $file to $dst\n"
done

# create subdomaons
for subdomain in "${subdomains[@]}"
do
    docker exec $id "plesk" "bin" "subdomain" "-c" "$subdomain" "-domain" "$domain"
done

function realpath () {
    echo $(python -c 'import os,sys;print(os.path.realpath(sys.argv[1]))' $1)
}
