<?php
echo "<html><title></title><link rel=\"stylesheet\" type=\"text/css\" href=\"styles.css\" /></head><body>";
echo "<div class=\"header\">SUPER AWESOME WEBSITE</div>";
echo "<div class=\"subheader\">Timecard</div>";
echo "<div class=\"navlinks\"><a href=\"./\">Home</a><br />";
echo "<table><tr><td>User</td><td>Date</td><td>Time in</td><td>Time out</td><td>Total (minutes)</td>";
$con = mysql_connect("localhost","web","Passw0rd01");
if (!$con)
{
die('Could not connect: ' . mysql_error());
}
mysql_select_db("my_db", $con);
$result = mysql_query("SELECT * FROM timecard ORDER BY \"postid\" DESC");
while($row = mysql_fetch_array($result))
{
	$totaltime = $row['timeout']-$row['timein'];
	if($totaltime<0)
	{
		$totaltime = 0;
	}
	echo "<tr><td>".$row['user']."</td><td>".$row['date']."</td><td>".$row['timein']."</td><td>".$row['timeout']."</td><td>".$totaltime."</td></tr>";
}
mysql_close($con);
echo "</table></body></html>";
?>
