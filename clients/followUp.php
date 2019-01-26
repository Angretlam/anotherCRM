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

$query = "
	UPDATE Followup  SET Completed = 1 WHERE
		AgentID = " .	$link->real_escape_string($_POST["agentID"])	. " AND
		ClientID = " .	$link->real_escape_string($_POST["clientID"])	. " AND
		FollowUpID = " .	$link->real_escape_string($_POST["followUpID"]); 

$stmt = $link->prepare($query);
$stmt->execute();

header('Location: ' . $ROOT_URL . 'clients/client.php?name=' . $_POST["Name"]);
?>
