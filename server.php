<?php

require __DIR__ . '/vendor/autoload.php';


$address = '127.0.0.1';
$port = 8080;

$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
$sock_id = spl_object_id($sock);
dump("Socket ID: " . $sock_id); // Socket ID

socket_bind($sock, $address, $port);

socket_listen($sock, 5);

dump("Server listening on $address:$port...\n");
do {
	$client = socket_accept($sock);
	if ($client === false) {
		dump(socket_strerror(socket_last_error($sock)));
		continue;
	}
	$input = socket_read($client, 1024);
	if ($input === false) {

		dump(socket_strerror(socket_last_error($client)));
		socket_close($client);
		continue;
	}
	dump($input);

	$input = socket_write($client, "Messege was send succesfuly to $sock_id");

	socket_close($client);
} while (true);

socket_close($sock);
