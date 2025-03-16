<?php

require __DIR__ . '/vendor/autoload.php';


$address = '127.0.0.1';
$port = 8080;

$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
$sock_id = spl_object_id($sock);
dump("Socket ID: " . $sock_id); // Socket ID

socket_connect($sock, $address, $port);

// socket_write($sock, "Hello from $address:$port");
while ($sock !== false) {

	if (socket_write($sock, "Hello from Socket ID: $sock_id") === false) {
		break;
	};

	$responce = socket_read($sock, 1024);
	if ($responce === false) {
		break;
	};
	dump("Server Response: $responce");
	break;
}
