<?php
require('../header.php');
include('../auth/auth.php');

$user_roles = authenticate(2);

if (array_search('1', $user_roles)) {
	 echo '
  <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#addAgent" aria-expanded="false" aria-controls="collapseExample">Add Agent</button>
	<div id="addAgent" class="collapse">
	<form method="POST" action="' . $ROOT_URL . 'agents/add.php">
	    <div class="form-group">
	      <label for="exampleInputEmail1">Agent Name</label>
	      <input type="input" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="John Doe" name="Name">
	    </div>
	    <div class="form-group">
	      <label for="exampleInputEmail1">Agent Email</label>
	      <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="John@Doe.Com" name="Email">
	    </div>
	    <div class="form-group">
	      <label for="exampleInputEmail1">Work Number</label>
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
	      <label for="exampleInputEmail1">Password</label>
	      <input type="Password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" name="Password">
	    </div>
	    <div class="form-group">
		  <input class="form-check-input" type="checkbox" value="on" id="admin" name="admin">
		  <label class="form-check-label" for="defaultCheck1">Set as administrator</label>
	    </div>
	    <button type="submit" class="btn btn-info">Submit</button>
	  </form>
	</div>';

}

echo '	</div>
</div>	<div style="width: 80%; margin-left:auto; margin-right:auto;">';

require('../config.php');
$link = mysqli_connect($DB_SERV, $DB_USER, $DB_PASS, $DB_NAME);

if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

if (array_search(1, $user_roles)) {
	$query = "SELECT Name, Email, WorkNumber, CellNumber, HomeNumber FROM Agents WHERE AgentID > 1";

} else {
	$query = "SELECT Name, Email, WorkNumber, CellNumber, HomeNumber FROM Agents WHERE AgentID in (
		SELECT AgentID FROM Agents WHERE Email = '". $_SESSION["email"] ."');";
}
$stmt = $link->prepare($query);
$stmt->execute();
mysqli_stmt_bind_result($stmt, $Name, $Email, $WorkNumber, $CellNumber, $HomeNumber);
while ($stmt->fetch()) {
	echo '
		<div class="card" style="width: 45%; margin:10px; float:left; height: 230px;">
			<a href="' . $ROOT_URL . 'agents/agent.php?name=' . $Name . '">
			  <div class="card-body">
			    <h5 class="card-title">' . $Name . '</h5>
			    <ul>
			      <li>Contact Email: ' . $Email . ' </li>
			      <li>Work Phone: ' . $WorkNumber . ' </li>
			      <li>Cell Phone: ' . $CellNumber . ' </li>
			      <li>Home Phone: ' . $HomeNumber . ' </li>
			    <ul>
			  </div>
			</a>
		</div>

	';
}
echo '</div>';
require('../footer.php'); ?>
