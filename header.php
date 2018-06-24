<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>On Demand Jet CRM - BETA</title>


    <!-- Bootstrap core CSS -->
    <link href="../../../../dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="jumbotron.css" rel="stylesheet">
  </head>

  <body>

    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
      <a class="navbar-brand" href="#">On Demand Jet CRM BETA</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>


<?php
session_start();
require('config.php');
if (!$_SESSION['authenticated']) {

    echo '
        <form class="form-inline my-2 my-lg-0" method="POST" action="https://anothercrmbeta.connorpeoples.com/auth/index.php">
          <input class="form-control mr-sm-2" type="text" placeholder="Email" aria-label="Username" name="email">
          <input class="form-control mr-sm-2" type="password" placeholder="Password" aria-label="Password" name="password">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Login</button>
        </form>';
} else {
                		$link = mysqli_connect($DB_SERV, $DB_USER, $DB_PASS, $DB_NAME);

                if (!$link) {
                    echo "Error: Unable to connect to MySQL." . PHP_EOL;
                    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
                    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
                    exit;
    }

	echo '
      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto"><!--
          <li class="nav-item active">
        	<a class="btn btn-info" href="#" role="button">Dashboard</a>
	</li>-->

		<div class="btn-group" style="margin-left: 10px;">
		  <a href="https://anothercrmbeta.connorpeoples.com/clients/index.php"><button type="button" class="btn btn-info">Clients</button></a>
		  <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		    <span class="sr-only">Toggle Dropdown</span>
		  </button>
		  <div class="dropdown-menu">';

                $query = "
                        SELECT
                            Clients.Name, Clients.ClientID
                        FROM
                            Clients
                        ORDER BY
                            Name";
                $stmt = $link->prepare($query);
                $stmt->execute();

                // Execute the query
                mysqli_stmt_bind_result($stmt, $name, $id);
                while ($stmt->fetch()) {
                       echo '<a class="dropdown-item" href="https://anothercrmbeta.connorpeoples.com/clients/client.php?name=' . $name . '">' . $name . '</a>';
                };

echo '</div>
		</div>
		<div class="btn-group" style="margin-left: 10px;">
		  <a href="https://anothercrmbeta.connorpeoples.com/agents/index.php"><button type="button" class="btn btn-info">Agents</button></a>
		  <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		    <span class="sr-only">Toggle Dropdown</span>
		  </button>
		  <div class="dropdown-menu">';


                // Sanitize the input
                $query = "
                        SELECT
                        	Agents.Name, Agents.AgentID
			                  FROM
                          Agents
			                  WHERE
                          AGENTID != 1
                        ORDER BY
                          Name
                        ";
                $stmt = $link->prepare($query);
                $stmt->execute();

                // Execute the query
                mysqli_stmt_bind_result($stmt, $name, $id);
                while ($stmt->fetch()) {
                       echo '<a class="dropdown-item" href="https://anothercrmbeta.connorpeoples.com/agents/agent.php?name=' . $name . '">' . $name . '</a>';
                };


	echo '
		  </div>
		</div>

        </ul>
        <form class="form-inline my-2 my-lg-0" method="POST" action="https://anothercrmbeta.connorpeoples.com/auth/logout.php">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Logout</button>
        </form>';
}
?>

        </div>
        </nav>

    <main role="main">

      <!-- Main jumbotron for a primary marketing message or call to action -->
      <div class="jumbotron">
        <div class="container">
