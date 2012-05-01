<?php
$con = mysql_connect("localhost","web","Passw0rd01");
if (!$con)
{
die('Could not connect: ' . mysql_error());
}
mysql_select_db("my_db", $con);
$result = mysql_query("SELECT * FROM dash WHERE postid=".$_GET['p']);
while($row = mysql_fetch_array($result))
{
	$title = $row['title'];
	$content = $row['content'];
	$image = $row['image'];
	$user = $row['user'];
	$postid = $row['postid'];
}
mysql_close($con);

echo "<html><title></title><link rel=\"stylesheet\" type=\"text/css\" href=\"styles.css\" /></head><body>";
echo "<div class=\"header\">Edit Post</div>";
echo "<form action=\"index.php\" method=\"post\" enctype=\"multipart/form-data\"><br />";
echo "Title<br /><input type=\"text\" name=\"title\" value=\"";
echo $title;
echo "\" /><br />Body<br /><textarea name=\"content\" rows=\"4\" cols=\"25\" />";
echo $content;
echo "</textarea><br />";
echo "Embed Picture<br /><input type=\"text\" name=\"image\" value=\"";
echo $image;
echo "\"/><br />User<br /><input type=\"text\" name=\"user\" value=\"";
echo $user;
echo "\" /><br />";
echo "<input type=\"hidden\" name=\"postid\" value=\"";
echo $postid;
echo "\" />";
echo "<input type=\"hidden\" name=\"posttype\" value=\"edit\" />";
echo "<br /><input type=\"submit\" value=\"Save\" /><br />";
echo "</form></body></html>";
?>
