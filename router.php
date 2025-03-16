<?php

require_once('vendor/autoload.php');

$climate = new League\CLImate\CLImate;

$climate->out('This prints to the terminal.');

// print_r(php_sapi_name());
// if (php_sapi_name() == 'cli-server') {
// 	echo print_r("hello");
// }
