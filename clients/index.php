<?php 
require('../header.php');	 
include('../auth/auth.php');

$user_roles = authenticate(2);

if (array_search('2', $user_roles)) {
	 echo '
  <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#addClient" aria-expanded="false" aria-controls="collapseExample">Add Client</button> 
	<div id="addClient" class="collapse">
	<form method="POST" action="https://anothercrmbeta.connorpeoples.com/clients/add.php">
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

$link = mysqli_connect('127.0.0.1', 'root', 'P4$$word9522007983', 'onDemandJet');

if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

$query = "SELECT Name, Email, WorkNumber, HomeNumber, CellNumber, StreetAddress, Suite, ZipCode, State,
	(SELECT Name from Agents WHERE AgentID in (SELECT AgentID FROM Relations WHERE ClientID = Clients.ClientID)) as Agent FROM Clients";
$stmt = $link->prepare($query);
$stmt->execute();
mysqli_stmt_bind_result($stmt, $Name, $Email, $WorkNumber, $HomeNumber, $CellNumber, $StreetAddress, $Suite, $ZipCode, $State, $Agent);
while ($stmt->fetch()) {
	echo '
		<a style="color:black;" href="https://anothercrmbeta.connorpeoples.com/clients/client.php?name=' . $Name . '">
		<div class="card" style="width: 45%; margin:10px; background-color:#ee5; float:left;">
		  <div class="card-body">
		    <h5 class="card-title">' . $Name . '</h5>
		    <ul>
		      <li>Contact Email: ' . $Email . ' </li>
		      <li>Work Phone: ' . $WorkNumber . ' </li>
		      <li>Cell Phone: ' . $CellNumber . ' </li>
		      <li>Home Phone: ' . $HomeNumber . ' </li>
		      <li>Address: ' . $StreetAddress . ' </li>
		      <li>Suite: ' . $Suite . ' </li>
		      <li>ZipCode: ' . $ZipCode . ' </li>
		      <li>State: ' . $State . ' </li>
		      <li>Agent: ' . $Agent . ' </li>
		    <ul>
		  </div>
		</div>
		</a>
	';
}
echo '</div>';
require('../footer.php'); ?>
