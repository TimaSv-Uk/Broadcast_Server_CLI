<?php

if (php_sapi_name() !== 'cli') {
	exit;
}

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
	$client_id = spl_object_id($client);
	if ($client === false) {
		dump(socket_strerror(socket_last_error($sock)));
		continue;
	}
	do {
		$input = socket_read($client, 1024);
		if ($input === false || trim($input) === '') {
			break;
		}
		dump($input);
		$output = socket_write($client, "Message was sent successfully from $client_id to $sock_id");
		if ($output === false) {
			break;
		}
	} while (true);
	socket_close($client);
} while (true);

socket_close($sock);
