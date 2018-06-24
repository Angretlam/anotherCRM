<?php
include('../auth/auth.php');
authenticate(2);

require('../config.php');
		$link = mysqli_connect($DB_SERV, $DB_USER, $DB_PASS, $DB_NAME);

if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}


$agent = $link->real_escape_string($_POST["AgentID"]);

if (!$agent) {
	$agent = 'NULL';
}

error_log($agent);
// Sanitize the input and add user to user DB
$query = "
	UPDATE Relations SET AgentID = " . $agent . "
	WHERE ClientID = '". $link->real_escape_string($_POST["ClientID"]) ."'";

$stmt = $link->prepare($query);
$stmt->execute();

header('Location: ' . $ROOT_URL. 'clients/client.php?name=' . $_POST["Name"]);
?>
