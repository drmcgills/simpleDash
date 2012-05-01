<?php
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
echo "<html><title></title><link rel=\"stylesheet\" type=\"text/css\" href=\"styles.css\" /></head><body>";
echo "<div class=\"header\">New Post</div>";
echo "<form action=\"index.php\" method=\"post\" enctype=\"multipart/form-data\"><br />";
echo "Title<br /><input type=\"text\" name=\"title\" /><br />Body<br /><textarea name=\"content\" rows=\"4\" cols=\"25\" /></textarea><br />";
echo "Embed Picture<br /><input type=\"text\" name=\"image\" /><br />";
echo "User: ";
echo printusrcode();
echo "<br />";
echo "<input type=\"hidden\" name=\"posttype\" value=\"new\" />";
echo "<br /><input type=\"submit\" value=\"Post\" /><br />";
echo "</form></body></html>";
?>
