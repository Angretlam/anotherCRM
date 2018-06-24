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

$zipcode = $_POST["Zipcode"] ? $link->real_escape_string($_POST["Zipcode"]) : ' NULL ';

// Sanitize the input and add user to user DB
$query = "
	UPDATE Clients SET
		Email = '" .	$link->real_escape_string($_POST["Email"])	. "',
		WorkNumber = '" .	$link->real_escape_string($_POST["WorkNumber"])	. "',
		CellNumber = '" .	$link->real_escape_string($_POST["CellNumber"])	. "',
		HomeNumber = '" .	$link->real_escape_string($_POST["HomeNumber"])	. "',
		StreetAddress = '" .	$link->real_escape_string($_POST["StreetAddress"])	. "',
		Suite = '" .	$link->real_escape_string($_POST["Suite"])	. "',
		Zipcode = " .	$zipcode 				.	 ",
		State = '" .	$link->real_escape_string($_POST["State"])	. "'
	WHERE Name = '". $link->real_escape_string($_POST["Name"]) ."'";

$stmt = $link->prepare($query);
$stmt->execute();

header('Location: ' . $ROOT_URL . 'clients/client.php?name=' . $_POST["Name"]);
?>
