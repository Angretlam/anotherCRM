<?php
require('../header.php');
include('../auth/auth.php');

authenticate(2);
require('../config.php');
		$link = mysqli_connect($DB_SERV, $DB_USER, $DB_PASS, $DB_NAME);

if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

$query = "SELECT ClientID, Name, Email, WorkNumber, HomeNumber, CellNumber, StreetAddress, Suite, ZipCode, State FROM Clients WHERE Name = '" . $link->real_escape_string($_GET['name']) . "'";
$stmt = $link->prepare($query);
$stmt->execute();
mysqli_stmt_bind_result($stmt, $ClientID, $Name, $Email, $WorkNumber, $HomeNumber, $CellNumber, $StreetAddress, $Suite, $ZipCode, $State);
while ($stmt->fetch()) {

echo '<h4>Client: ' . $Name . '</h4>
  <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#addAgent" aria-expanded="false" aria-controls="collapseExample">Client Info</button>
  <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#addNotes" aria-expanded="false" aria-controls="collapseExample">Add Note</button>
  <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#addRelation" aria-expanded="false" aria-controls="collapseExample">Agent Info</button>
  <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#addStatus" aria-expanded="false" aria-controls="collapseExample">Client Status</button>
        <div id="addAgent" class="collapse">
	<form method="POST" action="' . $ROOT_URL . 'clients/update.php">
		<input type="hidden" name="Name" value="' . $Name . '">
            <div class="form-group">
              <label for="exampleInputEmail1">Client Name</label>
              <input type="input" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="'. $Name .'" name="Name" disabled>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Client Email</label>
              <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="'. $Email .'" name="Email">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Work Phone</label>
              <input type="input" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="'. $WorkNumber .'" name="WorkNumber">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Cell Number</label>
              <input type="input" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="'. $CellNumber .'" name="CellNumber">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Home Number</label>
              <input type="input" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="'. $HomeNumber .'" name="HomeNumber">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Street Address</label>
              <input type="input" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="'. $StreetAddress .'" name="StreetAddress">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Suite</label>
              <input type="input" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="'. $Suite .'" name="Suite">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Zip Code</label>
              <input type="input" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="'. $ZipCode .'" name="Zipcode">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">State</label>
              <input type="input" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="'. $State .'" name="State">
            </div>
            <button type="submit" class="btn btn-info">Update</button>
          </form>
	</div>

	<div id="addNotes" class="collapse">
		<form method="POST" action="' . $ROOT_URL . 'clients/notes.php">
		    <div class="form-group">
		      <label for="exampleInputEmail1">Notes</label>
		    		<textarea name="Note" rows="4" style="width: 100%; margin-left: auto; margin-right: auto;"></textarea>
			</div>
			<input type="hidden" name="ClientID" value="'. $ClientID .'">
			<input type="hidden" name="Name" value="'. $Name .'">
            		<button type="submit" class="btn btn-info">Update</button>
		</form>
	</div>';
}

 echo '
        <div id="addRelation" class="collapse">
	<form method="POST" action="' . $ROOT_URL . 'clients/relations.php">
		<input type="hidden" name="ClientID" value="' . $ClientID . '">
			<input type="hidden" name="Name" value="'. $Name .'">
            <div class="form-group">
		<br />
		<label>Primary Agent</label>
		<select class="custom-select" name="AgentID">
		<option value="">None</option>
';

	$agent = '';
	$query = "SELECT (SELECT Name from Agents where AgentID = Relations.AgentID) AS AgentName FROM Relations WHERE ClientID = " . $ClientID;
	$stmt = $link->prepare($query);
	$stmt->execute();
	mysqli_stmt_bind_result($stmt, $agentName);
	while ($stmt->fetch()) {
              	$agent = $agentName;
	}

	$query = "SELECT AgentID, Name from Agents WHERE AgentID > 1";
	$stmt = $link->prepare($query);
	$stmt->execute();
	mysqli_stmt_bind_result($stmt, $agentID, $agentName);
	while ($stmt->fetch()) {
		if ($agentName == $agent) {
			echo '<option selected value="'. $agentID .'">'. $agentName .'</option>';
		} else {
			echo '<option value="'. $agentID .'">'. $agentName .'</option>';
		}
	}


 echo '</select><br /><br />
                        <button type="submit" class="btn btn-info">Update</button>
        </div>
        </div>
        </form>
        <div id="addStatus" class="collapse">
        <form method="POST" action="' . $ROOT_URL . 'clients/status.php">
                <input type="hidden" name="ClientID" value="' . $ClientID . '">
                        <input type="hidden" name="Name" value="'. $Name .'">
            <div class="form-group">
                <br />
                <label>Client Status</label>
                <select class="custom-select" name="AgentID">
                <option value="">None</option>
';

        $agent = '';
        $query = "SELECT (SELECT StatusName from Status where StatusID = ClientStatus.StatusID) AS CStatus FROM ClientStatus WHERE ClientID =" . $ClientID;
        $stmt = $link->prepare($query);
        $stmt->execute();
        mysqli_stmt_bind_result($stmt, $agentName);
        while ($stmt->fetch()) {
                $agent = $agentName;
        }

        $query = "SELECT StatusID, StatusName from Status WHERE StatusID > 0";
        $stmt = $link->prepare($query);
        $stmt->execute();
        mysqli_stmt_bind_result($stmt, $agentID, $agentName);
        while ($stmt->fetch()) {
                if ($agentName == $agent) {
                        echo '<option selected value="'. $agentID .'">'. $agentName .'</option>';
                } else {
                        echo '<option value="'. $agentID .'">'. $agentName .'</option>';
                }
        }


echo ' </select><br /><br />
            		<button type="submit" class="btn btn-info">Update</button>
	</div>
	</div>
	</form>
	  <!-- HEre in end the test code stuff -->
	</div>
      </div>
';

$query = "SELECT (SELECT Name FROM Agents WHERE AgentID = Notes.AgentID), Note, Date FROM Notes WHERE ClientID = ". $ClientID . " Order BY Date DESC";
$stmt = $link->prepare($query);
$stmt->execute();
mysqli_stmt_bind_result($stmt, $AgentID, $Note, $Date);

while ($stmt->fetch()) {

	echo'
	<div class="card" style="width: 80%; margin-bottom:10px; margin-left:auto; margin-right:auto;">
	  <div class="card-body">
	    <h5 class="card-title">'. $Date .'</h5>
	    <h6 class="card-title">'. $AgentID .'</h6>
	    <h6>Note</h6>
	    <p>'. $Note .'</p>
         </div>
	</div>';

}

require('../footer.php'); ?>
