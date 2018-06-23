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


// Sanitize the input and add user to user DB
$query = "
	INSERT INTO Notes (ClientID, Note, AgentID) VALUES (	
		" .	$link->real_escape_string($_POST["ClientID"])	. ",
		'" .	$link->real_escape_string($_POST["Note"])	. "',
		(SELECT AgentID FROM Agents WHERE Email = '" .	$_SESSION["email"] . "')
	)";
$stmt = $link->prepare($query);
$stmt->execute();

header('Location: https://anothercrmbeta.connorpeoples.com/clients/client.php?name=' . $_POST["Name"]);
?>
