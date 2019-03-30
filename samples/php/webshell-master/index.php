<?php

require 'class.php';
$config = require('config.php');
$app = new app($config);
$app->run()->show();