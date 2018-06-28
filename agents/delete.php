<?php
include('../auth/auth.php');
authenticate(1);
require('../config.php');
$link = mysqli_connect($DB_SERV, $DB_USER, $DB_PASS, $DB_NAME);

if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

$agentID = $link->real_escape_string($_POST["agentID"]);

$query = "DELETE FROM Agents WHERE AgentID = " . $agentID;
$stmt = $link->prepare($query);
$stmt->execute();

$query = "DELETE FROM AgentStandings WHERE AgentID = " . $agentID;
$stmt = $link->prepare($query);
$stmt->execute();

$query = "Update Relations SET AgentID = NULL WHERE AgentID = " . $agentID;
$stmt = $link->prepare($query);
$stmt->execute();

$query = "UPDATE Notes SET AgentID = NULL WHERE AgentID = " . $agentID;
$stmt = $link->prepare($query);
$stmt->execute();


header('Location: ' . $ROOT_URL . 'agents/index.php');

?>
