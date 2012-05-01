<?php
echo "<html><title></title><link rel=\"stylesheet\" type=\"text/css\" href=\"styles.css\" /></head><body>";
echo "<div class=\"header\">SUPER AWESOME WEBSITE</div>";
echo "<div class=\"subheader\">Timecard</div>";
echo "<div class=\"navlinks\"><a href=\"./\">Home</a><br />";
$thetime = date(g) . ":" . date(i) . ":" . date(s) . " " . date(A);
echo $thetime;
echo "<form action=\"clock.php\" method=\"post\" name=\"timecard\">";
echo "ACTION:<br />";
echo "<div class=\"radiocontainer\">IN<input type=\"radio\" name=\"inout\"  value=\"in\" />";
echo "OUT<input type=\"radio\" name=\"inout\" value=\"out\" checked /></div><br />";
echo "USER:<br /><div class=\"radiocontainer\">";
echo printusrcode();
echo "</div><br /><input type=\"submit\" value=\"GO\" /></form></html>";
function printusrcode()
{
	$con = mysql_connect("localhost","web","Passw0rd01");
	if (!$con)
	{
	die('Could not connect: ' . mysql_error());
	}
	mysql_select_db("my_db", $con);
	$sql = "SELECT username FROM members ORDER BY id DESC";
	$result = mysql_query($sql);
	$printcount = 0;
	while($row = mysql_fetch_array($result))
	{	
		if(printcount == 0)
		{
			$usrcode .= "<input type=\"radio\" name=\"user\" value=\"";
			$usrcode .= $row['username'];
			$usrcode .= "\" checked />";
			$usrcode .= $row['username'];
			$usrcode .= " ";
		}
		else
		{
			$usrcode .= "<input type=\"radio\" name=\"user\" value=\"";
			$usrcode .= $row['username'];
			$usrcode .= "\" />";
			$usrcode .= $row['username'];
			$usrcode .= " ";
		}
		$printcount++;
	}
	if (!mysql_query($sql,$con))
	{
	die('Error: ' . mysql_error());
	}
	mysql_close($con);
	return $usrcode;
}
?>
