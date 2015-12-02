<style>
body {
	background: #EEEEEE;
	text-align: center;
	font-family: "Trebuchet MS", Helvetica, sans-serif;
}

div.cls {
		display: inline-block;
		background-color: #FFFFFF;
		padding: 18px 5px;
		border-bottom: 2px solid #D2D2D2;
		border-right: 2px solid #D2D2D2;
		margin: 0;
		margin-right: 2px;
		min-width: 90px;
}

#subname {
		min-width: 440px;
		margin: 0;
		text-align: left;
}

#time {
		text-align: right;
		margin: 0;
}
#center {
	width: 90%;
	margin: auto;
	text-align:center;
}

#boxtips {
	width: 350px;
	display: inline-block;
	color: white;
	background-color: #00BCD4;
	padding: 18px 5px;
	border-bottom: 2px solid #D2D2D2;
	margin: 0;
}

#boxtips a {
	color: white;
}
a {
	text-decoration: none;
}
</style>
<h1>Project AIUB Sections+</h1>

<?php

//functions
function addhttp($url) {
    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = "http://" . $url;
    }
    return $url;
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

$id = $name = $email = $fbid = "";
$form_classid = array('sec1','sec2','sec3','sec4','sec4','sec5','sec6','sec7','sec8');
$peerinput = array('roll_id','name','email','fbid');
$peer_data = array();
$arr_classid = array();

if(strlen(test_input($_POST["roll_id"]))<8)
	{
	exit("<div style=\"text-align:center;margin-top: 10px;\">Please enter your Roll / ID properly.<br>
		<a style=\"font-size:30px;
	background-color: #FF4136;
	border: 1px solid white;
	display: inline-block;
	color: white;\" href=\"index.php\">CLICK HERE to go back and try again.</a></div>");
	}

if ($_SERVER["REQUEST_METHOD"] == "POST" AND strlen(test_input($_POST["roll_id"]))<13) {

	echo "<div id=\"boxtips\">";

//MYSQL STUFF HERE
$mysqli = new mysqli("hostname.com", "username", "password", "database");
$id =  $mysqli->real_escape_string(test_input($_POST["roll_id"]));

//DELETE IF USER WANTS TO CHANGE
if($_POST["change"] =="yes")
{
$sql = "DELETE FROM peers_list WHERE roll_id = '$id'";
$result = $mysqli->query($sql) or trigger_error($mysqli->error."[$sql]");
}


$sql = "SELECT * FROM peers_list WHERE roll_id = '$id'";
$result = $mysqli->query($sql) or trigger_error($mysqli->error."[$sql]");

if($result->num_rows == 0) 
	{
     // row not found, do stuff...
	$newguy = 'yes';
	echo "Hey Newguy :)<br>";
	
	//Validate and prepare his inputs
	foreach ($peerinput as $value)
		{ 
			if ($_POST[$value] != "")
			{
				if($value == "name")
				{
				$peer_data[$value] =  "'".$mysqli->real_escape_string(test_input($_POST[$value]))."'";
				}
				else 
				{
				$peer_data[$value] =  "'".$mysqli->real_escape_string(test_input($_POST[$value]))."'";
				}
			}
			else echo "You did not enter : ".  $value. "<br>";
		}
		$name = $mysqli->real_escape_string(test_input($_POST["name"]));
		$id = $mysqli->real_escape_string(test_input($_POST["roll_id"]));
		$email = $mysqli->real_escape_string(test_input($_POST["email"]));
		$fbid = addhttp($mysqli->real_escape_string(test_input($_POST["fbid"])));


	foreach($form_classid as $value)
				{
					if(ctype_digit(test_input($_POST[$value])))
					{
  					$arr_classid[$value] = test_input($_POST[$value]);
  					$peerinput[] = $value;  //WTF does this do? Why doesnt it work without this???
  					$peer_data[$value] = $arr_classid[$value];
					}
					else if(test_input($_POST[$value]) != "") 
						{
							echo test_input($_POST[$value]). "<- is not a VALID CLASS ID<br>
								<div style=\"text-align:center;margin-top: 10px;\"><a href=\"index.php\">Back</a></div>";
						$arr_classid[sec1] = NULL; 
						}
				}

		if(count(array_unique($arr_classid))<count($arr_classid))
		{
    		// Array has duplicates
    		echo "Please DO NOT enter the same class id TWICE.
			<div style=\"text-align:center;margin-top: 10px;\"><a href=\"index.php\">Back</a></div>";
    		$arr_classid[sec1] = NULL; 
		}

} 
else {
	$newguy = 'No';
	$row = mysqli_fetch_array($result);
	echo "Welcome back ";
	$id = $row["roll_id"];
	$name = $row["name"];
	$email = $row["email"];
	$fbid = addhttp($row["fbid"]);
	

	//get old data
	foreach($form_classid as $value)
	{
		if($row[$value] != "" AND $row[$value] != "00000")
					{
					$arr_classid[$value] = $row[$value];
  					$peerinput[] = $value;
					}
	
	}


    // do other stuff...
}

echo  $name. " :)<br>". "<br> " . $id . "<br> ". $email ."<br> ". "Facebook: <a href=\"".$fbid."\">".$fbid."</a><br>";
foreach ($arr_classid as $secs => $value)
{
	echo str_replace("sec","Subject ",$secs). " ID = ".$value. "<br>";
}


}

else 
	{
		echo "Invald Roll / ID.
			<div style=\"text-align:center;margin-top: 10px;\"><a href=\"index.php\">Back</a></div>";
			$arr_classid[sec1] = NULL; 
	}


//If new registration, ADD TO DATABASE
if($newguy == 'yes' AND isset($arr_classid[sec1])) {

		$impkeys_peer_data = implode(",", array_keys($peer_data));
		$impvals_peer_data = implode(",", $peer_data);


				$sql_update = "INSERT INTO peers_list  ($impkeys_peer_data)
								VALUES ($impvals_peer_data)";
		
		if(($mysqli->query($sql_update)) == TRUE)
		{
			echo "<div style=\"text-align:center;margin-top: 10px;\">
			Your details were successfully saved. :)</div><br>";
		} 
		else trigger_error($mysqli->error."[$sql_update]");
	
}

echo "</div><div style=\"text-align:center;margin-top: 10px;\">Your Routine: </div>";
echo "<div id=\"center\"> ";



//Display Routine for "sec[n]" data
if(isset($arr_classid[sec1]))
{ 
$classids = join(',',$arr_classid);
$sql = "SELECT *
FROM aiub_sfall_15
WHERE class_id IN ($classids)
ORDER BY FIELD(class_day, 'SATURDAY', 'SUNDAY', 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY','saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'), class_starts_h ASC, class_starts ASC";

$result = $mysqli->query($sql) or trigger_error($mysqli->error."[$sql]");

echo "<div class=\"cls\">Day</div><div id=\"time\" class=\"cls\">Starts</div><div id=\"time\" class=\"cls\">Ends</div><div class=\"cls\">Class ID</div><div id=\"subname\" class=\"cls\">Subject / Section</div><div class=\"cls\">Type</div><div class=\"cls\">Room</div><br>";

while($row = mysqli_fetch_array($result)) 
{
				
				$arr_sub_name[$row[class_id]] = $row[sub_name];
				echo "<div class=\"cls\">". $row[class_day]. " </div>";
				echo "<div id=\"time\" class=\"cls\">". $row[class_starts]." ".$row[class_starts_h]. " </div>";
				echo "<div id=\"time\" class=\"cls\">". $row[class_ends]. " ".$row[class_ends_h]. "</div>";
				echo "<div class=\"cls\">". $row[class_id] . "</div>";
				echo "<div id=\"subname\" class=\"cls\">". $row[sub_name]. " </div>";
				echo "<div class=\"cls\">". $row[class_type]. " </div>";
				echo "<div class=\"cls\">". $row[class_loc]. "</div>";
				echo "<br>";
}


//Find people in class
	echo "<br>Also in your classes(Who have submitted their info here):<br>";

foreach ($form_classid as $secnumber){
$sql = "SELECT $secnumber,roll_id,name,email,fbid
FROM peers_list
WHERE $secnumber IN ($classids)";
$result = $mysqli->query($sql) or trigger_error($mysqli->error."[$sql]");

if($result->num_rows > 0)
{


	$count = 0;
	while($row = mysqli_fetch_array($result))
	{
		if($row['roll_id']!= $id)
		{
			if ($count == 0) 
				{
					echo  "In Class: ".$row[$secnumber]. " " . $arr_sub_name[$row[$secnumber]]. "<br>";
					$count = 1;
				}
			echo "<div id=\"boxtips\">";
			echo "Name: ". $row['name'] . "<br> ID: ". $row['roll_id'] .
			"<br>Email: ". $row['email'] ."<br> "
			. "<a href=\"".$row['fbid']."\">".$row['fbid']."</a></div><br>";
		}

	}

}

}
echo "Tell your friends and fellow AIUBians to submit their info here to fill up this database.<br> Then all of us can connect with each other and find out which classes we have togather. :) ";


}
else echo "<br>Please enter ATLEAST FIRST TWO Subjects properly.<br>You can Leave the rest empty if you do not have more than two classes.<br><div style=\"text-align:center;margin-top: 10px;\"><a href=\"index.php\">Back</a></div><br>";


echo "</div><br><div style=\"text-align:center;margin-top: 10px;\">Developed by <a href=\"http://sohan.cf\">Sohan Chowdhury</a></div>";
//
?>