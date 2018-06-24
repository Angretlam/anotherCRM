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

$test_agent = 0;
$query = "SELECT AgentID FROM Agents WHERE email = '" . $link->real_escape_string($_POST['Email']) . "'";
$stmt = $link->prepare($query);
$stmt->execute();
mysqli_stmt_bind_result($stmt, $agent_id);
while ($stmt->fetch()) {
	$test_agent = $agent_id;
}

if ($test_agent > 0) {
	error_log('Argh!');
	header('Location: ' . $ROOT_URL . 'agents/');
} else {
	// Sanitize the input and add user to user DB
	$query = "
		INSERT INTO Agents (Name, Email, WorkNumber, CellNumber, HomeNumber, Password)
		VALUES (
			'" .	$link->real_escape_string($_POST["Name"]) 	. "',
			'" .	$link->real_escape_string($_POST["Email"])	. "',
			'" .	$link->real_escape_string($_POST["WorkNumber"])	. "',
			'" .	$link->real_escape_string($_POST["CellNumber"])	. "',
			'" .	$link->real_escape_string($_POST["HomeNumber"])	. "',
			'" .	(password_hash($link->real_escape_string($_POST["Password"]), PASSWORD_BCRYPT))	. "')";

	$stmt = $link->prepare($query);
	$stmt->execute();

	// Fetch user from the DB

	$query = "SELECT AgentID FROM Agents WHERE email = '" . $link->real_escape_string($_POST['Email']) . "'";
	$stmt = $link->prepare($query);
	$stmt->execute();
	$test_agent = $agent_id;

	mysqli_stmt_bind_result($stmt, $agent_id);
	while ($stmt->fetch()) {
		$test_agent = $agent_id;
	}

	error_log($_POST['admin']);
	// Insert user into auth DB
	if ($_POST["admin"] == "on") {
		$query2 = "INSERT INTO Auth (AgentID, RoleID) VALUES (". $test_agent .", 1)";
		echo $query2;
		$stmt2 = $link->prepare($query2);
		$stmt2->execute();
	}

	$query3 = "INSERT INTO Auth (AgentID, RoleID) VALUES (" . $test_agent . ", 2)";
	echo query3;
	$stmt3 = $link->prepare($query3);
	$stmt3->execute();

	header('Location: ' . $ROOT_URL . 'agents/');
}
?>
