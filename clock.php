<?php
$time = date(H).date(i);
$user = $_POST['user'];
if($_POST['inout'] == "in")
{
	clockin($_POST['user'], $time);
	echo $user . " clocked in at " . $time;
}
if($_POST['inout'] == "out")
{
	echo $user . " clocked out at " . $time;
	clockout($_POST['user'], $time);
}
function clockin($user, $time)
{
$con = mysql_connect("localhost","web","Passw0rd01");
if (!$con)
{
	die('Could not connect: ' . mysql_error());
}
mysql_select_db("my_db", $con);	
$sql = "INSERT INTO timecard (user, date, timein) VALUES ('$user.', CURDATE(), '$time')";
if (!mysql_query($sql,$con))
		{
			die('Error: ' . mysql_error());
		}
		mysql_close($con);
}
function clockout($user, $time)
{
$con = mysql_connect("localhost","web","Passw0rd01");
if (!$con)
{
	die('Could not connect: ' . mysql_error());
}
mysql_select_db("my_db", $con);	
$sql = "INSERT INTO timecard (user, date, timeout) VALUES ('$user.', CURDATE(), '$time')";
if (!mysql_query($sql,$con))
		{
			die('Error: ' . mysql_error());
		}
		mysql_close($con);
}

?>
