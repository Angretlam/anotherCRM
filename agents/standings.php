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


$StandingID = $link->real_escape_string($_POST["StandingID"]);

if (!$StandingID) {
	$StandingID = 'NULL';
}

error_log($StandingID);
// Sanitize the input and add user to user DB
$query = "
	UPDATE AgentStandings SET StandingID = " . $StandingID . "
	WHERE AgentID = '". $link->real_escape_string($_POST["AgentID"]) ."'";

$stmt = $link->prepare($query);
$stmt->execute();

header('Location: ' . $ROOT_URL . 'agents/agent.php?name=' . $_POST["Name"]);
?>
