<?php
  //Script for updating the password for an individual.
  require('auth.php');
  authenticate(1);

  if ($_SESSION['email']) {
    // connect to the DB
		$link = mysqli_connect($DB_SERV, $DB_USER, $DB_PASS, $DB_NAME);

		if (!$link) {
		    echo "Error: Unable to connect to MySQL." . PHP_EOL;
		    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
		    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
		    exit;
		}

		// Sanitize the input
		$AgentID = $link->real_escape_string($_POST['AgentID']);
    $passwd = $link->real_escape_string($_POST['passwd']);
    $email = $link->real_escape_string($_SESSION['email']);
    // Re-Crypt the password
    $dbPasswd = password_hash($AgentID, PASSWORD_BCRYPT);

		// Get the user roles information from the database
		$query = "
			UPDATE
				Agents
			SET
        Password = '" . $dbPasswd . "'
			WHERE
			     Agents.Email = '" . $email . "'";
		$stmt = $link->prepare($query);
		$stmt->execute();

		header('Location: ' . $ROOT_URL . '/agents/index.php');
	} else {
    	header('Location: ' . $ROOT_URL . '');
  }

 ?>
