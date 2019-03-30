#!/bin/bash

i=0
ls *.zip | \
    while read f
    do
	mkdir $i
	cd $i
	unzip ../$f
	cd ..
	let i=i+1
    done

	
		 
