<?php
include('../auth/auth.php');
authenticate(2);

$link = mysqli_connect('127.0.0.1', 'root', 'P4$$word9522007983', 'onDemandJet');

if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}


$AgentID = $link->real_escape_string($_POST["AgentID"]);

if (!$agent) {
	$agent = 'NULL';
}

error_log($agent);
// Sanitize the input and add user to user DB
$query = "
	UPDATE AgentStandings SET StandingID = " . $AgentID . "
	WHERE AgentID = '". $link->real_escape_string($_POST["AgentID"]) ."'";

$stmt = $link->prepare($query);
$stmt->execute();

header('Location: https://anothercrmbeta.connorpeoples.com/agents/agent.php?name=' . $_POST["Name"]);
?>
