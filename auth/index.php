<?php
require('../config.php');
/*
    Get POST data from login submission form
*/
$email = $_POST["email"];
$password = $_POST["password"];

/*
  Retrieve user information from database. password.
*/


$link = mysqli_connect($DB_SERV, $DB_USER, $DB_PASS, $DB_NAME);

if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

// Sanitize the input
$email = $link->real_escape_string($email);
$query = "SELECT Password FROM Agents WHERE email = '" . $email . "'";
$stmt = $link->prepare($query);
$stmt->execute();

// Execute the query
mysqli_stmt_bind_result($stmt, $hashed_pws);
$hashed_pw = $stmt->fetch();

// Verify the PW withe BCRYPT
if (password_verify($password, $hashed_pws)) {
    echo 'Password verified';
    session_start();
    $_SESSION['authenticated'] = 'true';
    $_SESSION['email'] = $email;
} else {
    echo 'Password unverified';
}


mysqli_close($link);

header('Location: ' . $ROOT_URL . '');
?>
