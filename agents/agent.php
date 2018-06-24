<?php
// Get the header file
require('../header.php');

// Authenticate for general users. No restrictions to this page.
include('../auth/auth.php');
authenticate(2);

// Connect to the database
$link = mysqli_connect('127.0.0.1', 'root', 'P4$$word9522007983', 'onDemandJet');

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
    echo '<h4>Client: ' . $Name . '</h4>
    <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#addAgent" aria-expanded="false" aria-controls="collapseExample">Agent Info</button>
    <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#addStatus" aria-expanded="false" aria-controls="collapseExample">Agent Status</button>';

    // Create the Agent information form.
    echo '
        <div id="addAgent" class="collapse">
          <form method="POST" action="https://anothercrmbeta.connorpeoples.com/agents/update.php">
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
                  <button type="submit" class="btn btn-info">Update</button>
                </form>
          </div>' ;
}

// Create the agent status form.
echo '
    </form>
    <div id="addStatus" class="collapse">
    <form method="POST" action="https://anothercrmbeta.connorpeoples.com/clients/status.php">
        <input type="hidden" name="AgentID" value="' . $AgentID . '">
        <input type="hidden" name="Name" value="' . $Name . '">
        <div class="form-group">
            <br />
            <label>Client Status</label>
            <select class="custom-select" name="AgentID">
            <option value="">None</option>';

// Get the agent status
$agent = '';
$query = "SELECT (SELECT StandingName from Standings where StandingID = AgentStanding.StandingID) AS AStanding FROM AgentStandings WHERE AgentID =" . $AgentID;
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

// Close the form
echo ' </select><br /><br />
                    <button type="submit" class="btn btn-info">Update</button>
    </div>
    </div>
    </form>
      <!-- HEre in end the test code stuff -->
    </div>
      </div>';

require('../footer.php');
?>
