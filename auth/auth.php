<?php
session_start();


// Access current session, retrieve email. If no email, redirect to home page.
function authenticate ($required_role) {
	require('../config.php');
	if ($_SESSION['email']) {
		/*
		  Retrieve user information from database. Roles.
		*/
		$link = mysqli_connect($DB_SERV, $DB_USER, $DB_PASS, $DB_NAME);

		if (!$link) {
		    echo "Error: Unable to connect to MySQL." . PHP_EOL;
		    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
		    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
		    exit;
		}

		// Sanitize the input
		$email = $link->real_escape_string($_SESSION['email']);

		// Get the user roles information from the database
		$query = "
			SELECT
				Auth.RoleID
			FROM
			     Auth
			     INNER JOIN Agents on Agents.AgentID = Auth.AgentID
			WHERE
			     Agents.email = '" . $email . "'";
		$stmt = $link->prepare($query);
		$stmt->execute();

		$roles = ['roles'];
		// Execute the query
		mysqli_stmt_bind_result($stmt, $hashed_pws);
		while ($stmt->fetch()) {
			array_push($roles, $hashed_pws);
		}

		if (!array_search($required_role, $roles)) {
			header('Location: ' . $ROOT_URL . '');
		}

		return($roles);
	} else {
		header('Location: ' . $ROOT_URL . '');
	}
}

?>
