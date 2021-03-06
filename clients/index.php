<?php
require('../header.php');
include('../auth/auth.php');

$user_roles = authenticate(2);

if (array_search('2', $user_roles)) {
	 echo '
  <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#addClient" aria-expanded="false" aria-controls="collapseExample">Add Client</button>
	<div id="addClient" class="collapse">
	<form method="POST" action="' . $ROOT_URL . 'clients/add.php">
	    <div class="form-group">
	      <label for="exampleInputEmail1">Client Name</label>
	      <input type="input" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="John Doe" name="Name">
	    </div>
	    <div class="form-group">
	      <label for="exampleInputEmail1">Client Email</label>
	      <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="John@Doe.Com" name="Email">
	    </div>
	    <div class="form-group">
	      <label for="exampleInputEmail1">Work Phone</label>
	      <input type="input" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="123-456-7890" name="WorkNumber">
	    </div>
	    <div class="form-group">
	      <label for="exampleInputEmail1">Cell Number</label>
	      <input type="input" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="123-456-7890" name="CellNumber">
	    </div>
	    <div class="form-group">
	      <label for="exampleInputEmail1">Home Number</label>
	      <input type="input" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="123-456-7890" name="HomeNumber">
	    </div>
	    <div class="form-group">
	      <label for="exampleInputEmail1">Street Address</label>
	      <input type="input" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="123 Abc Street" name="StreetAddress">
	    </div>
	    <div class="form-group">
	      <label for="exampleInputEmail1">Suite</label>
	      <input type="input" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Unit 101" name="Suite">
	    </div>
	    <div class="form-group">
	      <label for="exampleInputEmail1">Zip Code</label>
	      <input type="input" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="12345" name="Zipcode">
	    </div>
	    <div class="form-group">
	      <label for="exampleInputEmail1">State</label>
	      <input type="input" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="MN" name="State">
	    </div>
	    <button type="submit" class="btn btn-info">Submit</button>
	  </form>
	</div>
	</div>
	</div>

	<div style="width: 80%; margin-left:auto; margin-right:auto;">';
}

require('../config.php');
		$link = mysqli_connect($DB_SERV, $DB_USER, $DB_PASS, $DB_NAME);

if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

if (array_search(1, $user_roles)) {
	$query =  "SELECT Name, Email, WorkNumber, HomeNumber, CellNumber, StreetAddress, Suite, ZipCode, State,
        (SELECT Name from Agents WHERE AgentID in (SELECT AgentID FROM Relations WHERE ClientID = Clients.ClientID)) as Agent FROM Clients";
} else {
	$query = "SELECT Name, Email, WorkNumber, HomeNumber, CellNumber, StreetAddress, Suite, ZipCode, State,
	(SELECT Name from Agents WHERE AgentID in (SELECT AgentID FROM Relations WHERE ClientID = Clients.ClientID)) as Agent FROM Clients WHERE ClientID in (SELECT ClientID FROM Relations WHERE AgentID in (SELECT AgentID FROM Agents WHERE email = '". $_SESSION["email"] ."'))";
}
$stmt = $link->prepare($query);
$stmt->execute();
mysqli_stmt_bind_result($stmt, $Name, $Email, $WorkNumber, $HomeNumber, $CellNumber, $StreetAddress, $Suite, $ZipCode, $State, $Agent);
while ($stmt->fetch()) {
	echo '
		<a style="color:black;" href="' . $ROOT_URL . 'clients/client.php?name=' . $Name . '">
		<div class="col-sm" style="margin-bottom: 2em; background-color: #ccc;">
		    <br />
		    <h5>' . $Name . '</h5>
		    <ul class="list-group list-group-flush">
		      <li class="list-group-item">Email: ' . $Email . ' </li>
		      <li class="list-group-item">Work #: ' . $WorkNumber . ' </li>
		      <li class="list-group-item">Cell #: ' . $CellNumber . ' </li>';

		/*
		      <li class="list-group-item">Home Phone: ' . $HomeNumber . ' </li>
		      <li class="list-group-item">Address: ' . $StreetAddress . ' </li>
		      <li class="list-group-item">Suite: ' . $Suite . ' </li>
		      <li class="list-group-item">ZipCode: ' . $ZipCode . ' </li>
		*/
		echo '	
		      <li class="list-group-item">State: ' . $State . ' </li>
		      <li class="list-group-item">Agent: ' . $Agent . ' </li>
		    <ul>
		  <br />
		</div>
		</a>
	';
}
echo '</div>';
require('../footer.php'); ?>
