<?php
session_start();
// Access current session, retrieve email. If no email, redirect to home page.

function authenticate ($required_role) { 
	if ($_SESSION['email']) {
		/*
		  Retrieve user information from database. Roles.
		*/

		$link = mysqli_connect('127.0.0.1', 'root', 'P4$$word9522007983', 'onDemandJet');

		if (!$link) {
		    echo "Error: Unable to connect to MySQL." . PHP_EOL;
		    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
		    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
		    exit;
		}

		// Sanitize the input
		$email = $link->real_escape_string($_SESSION['email']);
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
		};
		
		if (!array_search($required_role, $roles)) {
			header('Location: https://anothercrmbeta.connorpeoples.com/crm');
		}

		return($roles);
	} else {
		header('Location: https://anothercrmbeta.connorpeoples.com/');
	}
}

?>
