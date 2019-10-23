<?php

use Auto\Auto;

require __DIR__ . '/vendor/autoload.php';

var_dump((Auto::data())::name());

var_dump("===================================");

var_dump((Auto::data())::bankAccountNumber());