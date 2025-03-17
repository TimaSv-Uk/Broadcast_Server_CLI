<?php

require __DIR__ . '/vendor/autoload.php';

$climate = new League\CLImate\CLImate;

$address = '127.0.0.1';
$port = 8080;

$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
$sock_id = spl_object_id($sock);
dump("Socket ID: " . $sock_id); // Socket ID

socket_connect($sock, $address, $port);

// socket_write($sock, "Hello from $address:$port");
while ($sock !== false) {

	$input = $climate->input("Enter a messege to server, or abort connection [m/c]");
	$responce = $input->prompt();

	$climate->out($responce);
	if ($responce === "c") {
		$climate->out("Goodby");
		socket_close($sock);
		break;
	} else if ($responce === "m") {
		$messege_input = $climate->input("Enter a messege");

		$messege_to_server_responce = $messege_input->prompt();

		if (socket_write($sock, $messege_to_server_responce) === false) {
			$climate->out("Goodby");
			socket_close($sock);
			break;
		};

		$server_responce = socket_read($sock, 1024);
		if ($server_responce === false) {

			$climate->out("Goodby");
			socket_close($sock);
			break;
		};

		$climate->out("Server Response: $server_responce");
	}
}
