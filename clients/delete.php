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

$clientID = $link->real_escape_string($_POST["clientID"]);

$query = "DELETE FROM Clients WHERE ClientID = " . $clientID;
$stmt = $link->prepare($query);
$stmt->execute();

$query = "DELETE FROM ClientStatus WHERE ClientID = " . $clientID;
$stmt = $link->prepare($query);
$stmt->execute();

$query = "DELETE FROM Relations WHERE ClientID = " . $clientID;
$stmt = $link->prepare($query);
$stmt->execute();

$query = "DELETE FROM Notes WHERE ClientID = " . $clientID;
$stmt = $link->prepare($query);
$stmt->execute();


header('Location: ' . $ROOT_URL . 'clients/index.php');

?>
