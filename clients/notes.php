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


$input_time = $_POST["followUpDate"] . ' ' . $_POST["followUpTime"];
preg_match_all("/\d*/", $input_time, $out);
$input_date = date_create(date(DATE_ATOM, mktime($out[0][6], $out[0][8], 00, $out[0][2], $out[0][4], $out[0][0])));
$input_date = date_sub($input_date, date_interval_create_from_date_string($_POST["followUpDiff"] . " hours"));
$utc_date = $input_date->format('Y-m-d H:i:s');

// Sanitize the input and add user to user DB
$query = "
	INSERT INTO Notes (ClientID, Note, AgentID) VALUES (
		" .	$link->real_escape_string($_POST["ClientID"])	. ",
		'" .	$link->real_escape_string($_POST["Note"])	. "',
		(SELECT AgentID FROM Agents WHERE Email = '" .	$_SESSION["email"] . "')
	)";
$stmt = $link->prepare($query);
$stmt->execute();

$query = "
	INSERT INTO Followup (AgentID, ClientID, FollowUpTime_UTC)
	VALUES ( (SELECT AgentID FROM Agents WHERE Email = '" .  $_SESSION["email"] . "'), ". $link->real_escape_string($_POST["ClientID"]) .", '". $utc_date ."' )
	";
$stmt = $link->prepare($query);
$stmt->execute();

header('Location: ' . $ROOT_URL . 'clients/client.php?name=' . $_POST["Name"]);
?>
