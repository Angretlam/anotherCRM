<?php
// Get the header file
require('../header.php');

// Authenticate for general users. No restrictions to this page.
include('../auth/auth.php');
$user_roles = authenticate(2);

// Connect to the database
require('../config.php');
$link = mysqli_connect($DB_SERV, $DB_USER, $DB_PASS, $DB_NAME);

if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

// Get all the agent data from the database. Needs to be updated
$query = "SELECT AgentID, Name, Email, WorkNumber, HomeNumber, CellNumber FROM Agents WHERE Name = '" . $link->real_escape_string($_GET['name']) . "'";
$stmt  = $link->prepare($query);
$stmt->execute();
mysqli_stmt_bind_result($stmt, $AgentID, $Name, $Email, $WorkNumber, $HomeNumber, $CellNumber);

// For each item in the agent table, create the pages needed.
// while is required to prevent later queries from running out. Stupid PHP
while ($stmt->fetch()) {
    // Create the header buttons for the agent page.
    echo '<h4>Agent: ' . $Name . '</h4>
    <button class="btn btn-warning" type="button" data-toggle="collapse" data-target="#addAgent" aria-expanded="false" aria-controls="collapseExample">Agent Info</button>
    <button class="btn btn-warning" type="button" data-toggle="collapse" data-target="#addStatus" aria-expanded="false" aria-controls="collapseExample">Agent Status</button>';

    if (array_search('1', $user_roles)) {
      echo '  
	<button class="btn btn-danger" type="button" data-toggle="collapse" data-target="#updatePassword" aria-expanded="false" aria-controls="collapseExample">Agent Password</button>
	<button class="btn btn-danger" type="button" data-toggle="collapse" data-target="#deleteAgent" aria-expanded="false" aria-controls="collapseExample">Delete Agent</button>

	';
    }
    // Create the Agent warningrmation form.
    echo '
        <div id="addAgent" class="collapse">
          <form method="POST" action="' . $ROOT_URL . 'agents/update.php">
              <input type="hidden" name="Name" value="' . $Name . '">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Agent Name</label>
                    <input type="input" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="' . $Name . '" name="Name" disabled>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Agent Email</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="' . $Email . '" name="Email">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Work Phone</label>
                    <input type="input" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="' . $WorkNumber . '" name="WorkNumber">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Cell Number</label>
                    <input type="input" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="' . $CellNumber . '" name="CellNumber">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Home Number</label>
                    <input type="input" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="' . $HomeNumber . '" name="HomeNumber">
                  </div>
                  <button type="submit" class="btn btn-warning">Update</button>
                </form>
          </div>' ;
}

// Create the agent status form.

if (array_search('1', $user_roles) or $_SESSION["email"] == $Email) {
  echo '
      </form>
      <div id="addStatus" class="collapse">
      <form method="POST" action="' . $ROOT_URL . 'agents/standings.php">
          <input type="hidden" name="AgentID" value="' . $AgentID . '">
          <input type="hidden" name="Name" value="' . $Name . '">
          <div class="form-group">
              <br />
              <label>Client Status</label>
              <select class="custom-select" name="StandingID" >';
} else {
  echo '
      </form>
      <div id="addStatus" class="collapse">
      <form method="POST" action="' . $ROOT_URL . 'agents/standings.php">
          <input type="hidden" name="AgentID" value="' . $AgentID . '">
          <input type="hidden" name="Name" value="' . $Name . '">
          <div class="form-group">
              <br />
              <label>Client Status</label>
              <select class="custom-select" name="StandingID" disabled>';
}

// Get the agent status
$agent = '';
$query = "SELECT (SELECT StandingName from Standings where StandingID = AgentStandings.StandingID) AS AStanding FROM AgentStandings WHERE AgentID =" . $AgentID;
$stmt  = $link->prepare($query);
error_log($AgentID);
$stmt->execute();
mysqli_stmt_bind_result($stmt, $agentName);
while ($stmt->fetch()) {
    $agent = $agentName;
}

// Generate the select options for the agent status
$query = "SELECT StandingID, StandingName from Standings WHERE StandingID > 0";
$stmt  = $link->prepare($query);
$stmt->execute();
mysqli_stmt_bind_result($stmt, $standingID, $standingName);

// Iterate through the results. If the results of the select options query
// matches the agent status, make that the select value
while ($stmt->fetch()) {
    if ($standingName == $agent) {
        echo '<option selected value="' . $standingID . '">' . $standingName . '</option>';
    } else {
        echo '<option value="' . $standingID . '">' . $standingName . '</option>';
    }
}

// Create agent password change form.
echo ' </select><br /><br />
                    <button type="submit" class="btn btn-warning">Update</button>
    </div>
    </div>
    </form>
    <div id="updatePassword" class="collapse">
    <form method="POST" action="' . $ROOT_URL . 'auth/update.php">
        <input type="hidden" name="AgentID" value="' . $AgentID . '">
        <input type="hidden" name="Name" value="' . $Name . '">
        <div class="form-group">
            <label>New Password</label>
            <input type="password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="" name="passwd">
          ';


// Close the form
if (array_search('1', $user_roles) or $_SESSION["email"] == $Email) {
  echo '
	<br />
        <button type="submit" class="btn btn-danger">Update Password</button>
      </div>
      </div>
      </form>
        <!-- HEre in end the test code stuff -->';
} else {
  echo ' </select><br /><br />
      </div>
      </div>
      </form>
        <!-- HEre in end the test code stuff -->';

}

echo '
         <div id="deleteAgent" class="collapse">
                <form method="POST" action="' . $ROOT_URL . 'agents/delete.php">
                        <input type="hidden" name="agentID" value="' . $AgentID . '">
                        <br />
                        <br />
                        <button type="submit" class="btn btn-danger">Confirm Deletion</button>
                </form>
        </div>

</div> </div> <div class="container"> <h4>Client list:</h4>';

// Add the clients related to this agent.
$query = "SELECT (SELECT Name FROM Clients WHERE ClientID = Relations.ClientID) as ClientName FROM Relations WHERE AgentID = ". $AgentID . " Order BY ClientName";
$stmt = $link->prepare($query);
$stmt->execute();
mysqli_stmt_bind_result($stmt, $ClientName);

while ($stmt->fetch()) {

	echo'
	  <div class="card" style="width: 40%; margin-bottom:10px; margin-left:auto; margin-right:auto;">
      <a href="' . $ROOT_URL . 'clients/client.php?name=' . $ClientName . '">
        <div class="card-body">
  	      <h6 class="card-title">'. $ClientName .'</h6>
        </div>
      </a>
	  </div>';
}

echo '</div>';

require('../footer.php');
?>
