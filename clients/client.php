<?php
require('../header.php');
include('../auth/auth.php');

$user_roles = authenticate(2);
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
  <button class="btn btn-warning" type="button" data-toggle="collapse" data-target="#addAgent" aria-expanded="false" aria-controls="collapseExample">Client Info</button>
  <button class="btn btn-warning" type="button" data-toggle="collapse" data-target="#addNotes" aria-expanded="false" aria-controls="collapseExample">Add Note</button>
  <button class="btn btn-warning" type="button" data-toggle="collapse" data-target="#addRelation" aria-expanded="false" aria-controls="collapseExample">Agent Info</button>
  <button class="btn btn-warning" type="button" data-toggle="collapse" data-target="#addStatus" aria-expanded="false" aria-controls="collapseExample">Client Status</button>';


if (array_search("1", $user_roles)) {
	echo '
		<button class="btn btn-danger" type="button" data-toggle="collapse" data-target="#deleteClient" aria-expanded="false" aria-controls="collapseExample">Delete Client</button>';
}

echo '<div id="addAgent" class="collapse">
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
            <button type="submit" class="btn btn-warning">Update</button>
          </form>
	</div>

	<div id="addNotes" class="collapse">
		<form method="POST" id="notes" action="' . $ROOT_URL . 'clients/notes.php">
		    <div class="form-group">
		      <label for="exampleInputEmail1"><h4>Notes</h4></label>
		    		<textarea name="Note" rows="4" style="width: 100%; margin-left: auto; margin-right: auto;"></textarea>
		<br />
		<br />
		<h4>Follow up date</h4>
		<input name="followUpDate" type="date" >
		<input name="followUpTime" type="time" >	
		<select name="followUpDiff" form="notes">
	<option timeZoneId="1" gmtAdjustment="GMT-12:00" useDaylightTime="0" value="-12">(GMT-12:00) International Date Line West</option>
	<option timeZoneId="2" gmtAdjustment="GMT-11:00" useDaylightTime="0" value="-11">(GMT-11:00) Midway Island, Samoa</option>
	<option timeZoneId="3" gmtAdjustment="GMT-10:00" useDaylightTime="0" value="-10">(GMT-10:00) Hawaii</option>
	<option timeZoneId="4" gmtAdjustment="GMT-09:00" useDaylightTime="1" value="-9">(GMT-09:00) Alaska</option>
	<option timeZoneId="5" gmtAdjustment="GMT-08:00" useDaylightTime="1" value="-8">(GMT-08:00) Pacific Time (US & Canada)</option>
	<option timeZoneId="6" gmtAdjustment="GMT-08:00" useDaylightTime="1" value="-8">(GMT-08:00) Tijuana, Baja California</option>
	<option timeZoneId="7" gmtAdjustment="GMT-07:00" useDaylightTime="0" value="-7">(GMT-07:00) Arizona</option>
	<option timeZoneId="8" gmtAdjustment="GMT-07:00" useDaylightTime="1" value="-7">(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
	<option timeZoneId="9" gmtAdjustment="GMT-07:00" useDaylightTime="1" value="-7">(GMT-07:00) Mountain Time (US & Canada)</option>
	<option timeZoneId="10" gmtAdjustment="GMT-06:00" useDaylightTime="0" value="-6">(GMT-06:00) Central America</option>
	<option timeZoneId="11" gmtAdjustment="GMT-06:00" useDaylightTime="1" value="-6">(GMT-06:00) Central Time (US & Canada)</option>
	<option timeZoneId="12" gmtAdjustment="GMT-06:00" useDaylightTime="1" value="-6">(GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
	<option timeZoneId="13" gmtAdjustment="GMT-06:00" useDaylightTime="0" value="-6">(GMT-06:00) Saskatchewan</option>
	<option timeZoneId="14" gmtAdjustment="GMT-05:00" useDaylightTime="0" value="-5">(GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
	<option timeZoneId="15" gmtAdjustment="GMT-05:00" useDaylightTime="1" value="-5">(GMT-05:00) Eastern Time (US & Canada)</option>
	<option timeZoneId="16" gmtAdjustment="GMT-05:00" useDaylightTime="1" value="-5">(GMT-05:00) Indiana (East)</option>
	<option timeZoneId="17" gmtAdjustment="GMT-04:00" useDaylightTime="1" value="-4">(GMT-04:00) Atlantic Time (Canada)</option>
	<option timeZoneId="18" gmtAdjustment="GMT-04:00" useDaylightTime="0" value="-4">(GMT-04:00) Caracas, La Paz</option>
	<option timeZoneId="19" gmtAdjustment="GMT-04:00" useDaylightTime="0" value="-4">(GMT-04:00) Manaus</option>
	<option timeZoneId="20" gmtAdjustment="GMT-04:00" useDaylightTime="1" value="-4">(GMT-04:00) Santiago</option>
	<option timeZoneId="21" gmtAdjustment="GMT-03:30" useDaylightTime="1" value="-3.5">(GMT-03:30) Newfoundland</option>
	<option timeZoneId="22" gmtAdjustment="GMT-03:00" useDaylightTime="1" value="-3">(GMT-03:00) Brasilia</option>
	<option timeZoneId="23" gmtAdjustment="GMT-03:00" useDaylightTime="0" value="-3">(GMT-03:00) Buenos Aires, Georgetown</option>
	<option timeZoneId="24" gmtAdjustment="GMT-03:00" useDaylightTime="1" value="-3">(GMT-03:00) Greenland</option>
	<option timeZoneId="25" gmtAdjustment="GMT-03:00" useDaylightTime="1" value="-3">(GMT-03:00) Montevideo</option>
	<option timeZoneId="26" gmtAdjustment="GMT-02:00" useDaylightTime="1" value="-2">(GMT-02:00) Mid-Atlantic</option>
	<option timeZoneId="27" gmtAdjustment="GMT-01:00" useDaylightTime="0" value="-1">(GMT-01:00) Cape Verde Is.</option>
	<option timeZoneId="28" gmtAdjustment="GMT-01:00" useDaylightTime="1" value="-1">(GMT-01:00) Azores</option>
	<option timeZoneId="29" gmtAdjustment="GMT+00:00" useDaylightTime="0" value="0">(GMT+00:00) Casablanca, Monrovia, Reykjavik</option>
	<option timeZoneId="30" gmtAdjustment="GMT+00:00" useDaylightTime="1" value="0">(GMT+00:00) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London</option>
	<option timeZoneId="31" gmtAdjustment="GMT+01:00" useDaylightTime="1" value="1">(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
	<option timeZoneId="32" gmtAdjustment="GMT+01:00" useDaylightTime="1" value="1">(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
	<option timeZoneId="33" gmtAdjustment="GMT+01:00" useDaylightTime="1" value="1">(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
	<option timeZoneId="34" gmtAdjustment="GMT+01:00" useDaylightTime="1" value="1">(GMT+01:00) Sarajevo, Skopje, Warsaw, Zagreb</option>
	<option timeZoneId="35" gmtAdjustment="GMT+01:00" useDaylightTime="1" value="1">(GMT+01:00) West Central Africa</option>
	<option timeZoneId="36" gmtAdjustment="GMT+02:00" useDaylightTime="1" value="2">(GMT+02:00) Amman</option>
	<option timeZoneId="37" gmtAdjustment="GMT+02:00" useDaylightTime="1" value="2">(GMT+02:00) Athens, Bucharest, Istanbul</option>
	<option timeZoneId="38" gmtAdjustment="GMT+02:00" useDaylightTime="1" value="2">(GMT+02:00) Beirut</option>
	<option timeZoneId="39" gmtAdjustment="GMT+02:00" useDaylightTime="1" value="2">(GMT+02:00) Cairo</option>
	<option timeZoneId="40" gmtAdjustment="GMT+02:00" useDaylightTime="0" value="2">(GMT+02:00) Harare, Pretoria</option>
	<option timeZoneId="41" gmtAdjustment="GMT+02:00" useDaylightTime="1" value="2">(GMT+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius</option>
	<option timeZoneId="42" gmtAdjustment="GMT+02:00" useDaylightTime="1" value="2">(GMT+02:00) Jerusalem</option>
	<option timeZoneId="43" gmtAdjustment="GMT+02:00" useDaylightTime="1" value="2">(GMT+02:00) Minsk</option>
	<option timeZoneId="44" gmtAdjustment="GMT+02:00" useDaylightTime="1" value="2">(GMT+02:00) Windhoek</option>
	<option timeZoneId="45" gmtAdjustment="GMT+03:00" useDaylightTime="0" value="3">(GMT+03:00) Kuwait, Riyadh, Baghdad</option>
	<option timeZoneId="46" gmtAdjustment="GMT+03:00" useDaylightTime="1" value="3">(GMT+03:00) Moscow, St. Petersburg, Volgograd</option>
	<option timeZoneId="47" gmtAdjustment="GMT+03:00" useDaylightTime="0" value="3">(GMT+03:00) Nairobi</option>
	<option timeZoneId="48" gmtAdjustment="GMT+03:00" useDaylightTime="0" value="3">(GMT+03:00) Tbilisi</option>
	<option timeZoneId="49" gmtAdjustment="GMT+03:30" useDaylightTime="1" value="3.5">(GMT+03:30) Tehran</option>
	<option timeZoneId="50" gmtAdjustment="GMT+04:00" useDaylightTime="0" value="4">(GMT+04:00) Abu Dhabi, Muscat</option>
	<option timeZoneId="51" gmtAdjustment="GMT+04:00" useDaylightTime="1" value="4">(GMT+04:00) Baku</option>
	<option timeZoneId="52" gmtAdjustment="GMT+04:00" useDaylightTime="1" value="4">(GMT+04:00) Yerevan</option>
	<option timeZoneId="53" gmtAdjustment="GMT+04:30" useDaylightTime="0" value="4.5">(GMT+04:30) Kabul</option>
	<option timeZoneId="54" gmtAdjustment="GMT+05:00" useDaylightTime="1" value="5">(GMT+05:00) Yekaterinburg</option>
	<option timeZoneId="55" gmtAdjustment="GMT+05:00" useDaylightTime="0" value="5">(GMT+05:00) Islamabad, Karachi, Tashkent</option>
	<option timeZoneId="56" gmtAdjustment="GMT+05:30" useDaylightTime="0" value="5.5">(GMT+05:30) Sri Jayawardenapura</option>
	<option timeZoneId="57" gmtAdjustment="GMT+05:30" useDaylightTime="0" value="5.5">(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
	<option timeZoneId="58" gmtAdjustment="GMT+05:45" useDaylightTime="0" value="5.75">(GMT+05:45) Kathmandu</option>
	<option timeZoneId="59" gmtAdjustment="GMT+06:00" useDaylightTime="1" value="6">(GMT+06:00) Almaty, Novosibirsk</option>
	<option timeZoneId="60" gmtAdjustment="GMT+06:00" useDaylightTime="0" value="6">(GMT+06:00) Astana, Dhaka</option>
	<option timeZoneId="61" gmtAdjustment="GMT+06:30" useDaylightTime="0" value="6.5">(GMT+06:30) Yangon (Rangoon)</option>
	<option timeZoneId="62" gmtAdjustment="GMT+07:00" useDaylightTime="0" value="7">(GMT+07:00) Bangkok, Hanoi, Jakarta</option>
	<option timeZoneId="63" gmtAdjustment="GMT+07:00" useDaylightTime="1" value="7">(GMT+07:00) Krasnoyarsk</option>
	<option timeZoneId="64" gmtAdjustment="GMT+08:00" useDaylightTime="0" value="8">(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
	<option timeZoneId="65" gmtAdjustment="GMT+08:00" useDaylightTime="0" value="8">(GMT+08:00) Kuala Lumpur, Singapore</option>
	<option timeZoneId="66" gmtAdjustment="GMT+08:00" useDaylightTime="0" value="8">(GMT+08:00) Irkutsk, Ulaan Bataar</option>
	<option timeZoneId="67" gmtAdjustment="GMT+08:00" useDaylightTime="0" value="8">(GMT+08:00) Perth</option>
	<option timeZoneId="68" gmtAdjustment="GMT+08:00" useDaylightTime="0" value="8">(GMT+08:00) Taipei</option>
	<option timeZoneId="69" gmtAdjustment="GMT+09:00" useDaylightTime="0" value="9">(GMT+09:00) Osaka, Sapporo, Tokyo</option>
	<option timeZoneId="70" gmtAdjustment="GMT+09:00" useDaylightTime="0" value="9">(GMT+09:00) Seoul</option>
	<option timeZoneId="71" gmtAdjustment="GMT+09:00" useDaylightTime="1" value="9">(GMT+09:00) Yakutsk</option>
	<option timeZoneId="72" gmtAdjustment="GMT+09:30" useDaylightTime="0" value="9.5">(GMT+09:30) Adelaide</option>
	<option timeZoneId="73" gmtAdjustment="GMT+09:30" useDaylightTime="0" value="9.5">(GMT+09:30) Darwin</option>
	<option timeZoneId="74" gmtAdjustment="GMT+10:00" useDaylightTime="0" value="10">(GMT+10:00) Brisbane</option>
	<option timeZoneId="75" gmtAdjustment="GMT+10:00" useDaylightTime="1" value="10">(GMT+10:00) Canberra, Melbourne, Sydney</option>
	<option timeZoneId="76" gmtAdjustment="GMT+10:00" useDaylightTime="1" value="10">(GMT+10:00) Hobart</option>
	<option timeZoneId="77" gmtAdjustment="GMT+10:00" useDaylightTime="0" value="10">(GMT+10:00) Guam, Port Moresby</option>
	<option timeZoneId="78" gmtAdjustment="GMT+10:00" useDaylightTime="1" value="10">(GMT+10:00) Vladivostok</option>
	<option timeZoneId="79" gmtAdjustment="GMT+11:00" useDaylightTime="1" value="11">(GMT+11:00) Magadan, Solomon Is., New Caledonia</option>
	<option timeZoneId="80" gmtAdjustment="GMT+12:00" useDaylightTime="1" value="12">(GMT+12:00) Auckland, Wellington</option>
	<option timeZoneId="81" gmtAdjustment="GMT+12:00" useDaylightTime="0" value="12">(GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>
	<option timeZoneId="82" gmtAdjustment="GMT+13:00" useDaylightTime="0" value="13">(GMT+13:00) Nuku\'alofa</option>
</select>	
		</div>
		<input type="hidden" name="ClientID" value="'. $ClientID .'">
		<input type="hidden" name="Name" value="'. $Name .'">
       		<button type="submit" class="btn btn-warning">Update</button>
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
                        <button type="submit" class="btn btn-warning">Update</button>
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
            		<button type="submit" class="btn btn-warning">Update</button>
	</div>
	</div>
	</form>
	
	 <div id="deleteClient" class="collapse">
        	<form method="POST" action="' . $ROOT_URL . 'clients/delete.php">
                	<input type="hidden" name="clientID" value="' . $ClientID . '">
                        <input type="hidden" name="Name" value="'. $Name .'">
			<br />
			<br />
			<button type="submit" class="btn btn-danger">Confirm Deletion</button>
		</form>
	</div>
	  <!-- HEre in end the test code stuff -->
	</div>
      </div>
';

echo '
	<div class="container">
	<h3>Follow ups:</h3>';

$query = "SELECT FollowUptime_UTC, ClientID, AgentID, FollowUpID FROM Followup WHERE ClientID = " . $ClientID . " AND Completed = 0 Order BY FollowUpTime_UTC";
$stmt = $link->prepare($query);
$stmt->execute();
mysqli_stmt_bind_result($stmt, $date, $clientID, $agentID, $followUpID);

$count = 0;

while ($stmt->fetch()) {
	echo ' 
	<div style="border: 2px solid black; padding: 10px; width: 45%; margin:10px; float:left;">
	<form action="followUp.php" method="POST">
        <input type="hidden" name="Name" value="'. $Name .'">
	<input type="hidden" name="clientID" value="'. $clientID .'">
	<input type="hidden" name="agentID" value="'. $agentID.'">
	<input type="hidden" name="followUpID" value="'. $followUpID .'">
	<div class="card" id="test'. $count .'">
	<script>
		Date.prototype.stdTimezoneOffset = function () {
		    var jan = new Date(this.getFullYear(), 0, 1);
		    var jul = new Date(this.getFullYear(), 6, 1);
		    return Math.max(jan.getTimezoneOffset(), jul.getTimezoneOffset());
		}

		Date.prototype.isDstObserved = function () {
		    return this.getTimezoneOffset() < this.stdTimezoneOffset();
		}

		
		var followUpTime =  new Date("' . $date . ' UTC");
		var today = new Date();
		
		if (today.isDstObserved()) { 
			var epochTime = followUpTime.setHours(followUpTime.getHours() - 1);
			var date = new Date( parseFloat( epochTime));
			followUpTime = new Date(date.getFullYear(), date.getMonth(), date.getDate(), date.getHours(), date.getMinutes(), date.getSeconds() );
		}
	
		var currentTime = new Date();
		document.getElementById("test'. $count .'").innerHTML = followUpTime;
		
		if (currentTime > followUpTime) {
			document.getElementById("test'. $count .'").setAttribute("style", "padding: 10px; margin-bottom: 10px;  color: red;");
		} else if (currentTime > followUpTime.setHours(followUpTime.getHours() - 3)) {
			document.getElementById("test'. $count .'").setAttribute("style", "padding: 10px; margin-bottom:10px; color: orange;");
		} else {
			document.getElementById("test'. $count .'").setAttribute("style", "padding: 10px; margin-bottom:10px; color: green;");
		}	
	</script>
	</div>
	<button type="submit" class="btn btn-danger">Confirm FollowUp</button>
	</form>
	</div>
	';
	$count = $count + 1;
}

echo '
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
