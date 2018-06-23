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

$test_agent = 0;
$query = "SELECT Name FROM Clients WHERE Name = '" . $link->real_escape_string($_POST['Name']) . "'";
$stmt = $link->prepare($query);
$stmt->execute();
mysqli_stmt_bind_result($stmt, $agent_id);
while ($stmt->fetch()) {
	$test_agent = $agent_id;
}

$zipcode = $_POST["Zipcode"] ? $link->real_escape_string($_POST["Zipcode"]) : ' NULL ';

if ($test_agent > 0) {
	error_log('Argh!');
	header('Location: https://anothercrmbeta.connorpeoples.com/clients/');
} else {
	// Sanitize the input and add user to user DB
	$query = "
		INSERT INTO Clients (Name, Email, WorkNumber, CellNumber, HomeNumber, StreetAddress, Suite, Zipcode, State)
		VALUES (
			'" .	$link->real_escape_string($_POST["Name"]) 	. "',
			'" .	$link->real_escape_string($_POST["Email"])	. "',
			'" .	$link->real_escape_string($_POST["WorkNumber"])	. "',
			'" .	$link->real_escape_string($_POST["CellNumber"])	. "',
			'" .	$link->real_escape_string($_POST["HomeNumber"])	. "',
			'" .	$link->real_escape_string($_POST["StreetAddress"])	. "',
			'" .	$link->real_escape_string($_POST["Suite"])	. "',
			" .	$zipcode					. ",
			'" .	$link->real_escape_string($_POST["State"])	. "'
			)";;
	echo $query;
	$stmt = $link->prepare($query);
	$stmt->execute();

	$clientID = '';
	$query = "SELECT ClientID FROM Clients WHERE Name = '" . $link->real_escape_string($_POST["Name"]) . "'";
	$stmt = $link->prepare($query);
	$stmt->execute();
	mysqli_stmt_bind_result($stmt, $id);
	while ($stmt->fetch()) {
		$clientID = $id;
	}

	$query = "INSERT INTO Relations (ClientID, AgentID) Values (" . $clientID . ", 0)";
	$stmt = $link->prepare($query);
	$stmt->execute();


	$query = "INSERT INTO ClientStatus (ClientID, StatusID) Values (" . $clientID . ", 0)";
	$stmt = $link->prepare($query);
	$stmt->execute();

	header('Location: https://anothercrmbeta.connorpeoples.com/clients/');
	
}
?>
