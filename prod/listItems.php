<?php
echo "<html><head><link href=\"styles.css\" rel=\"stylesheet\" type=\"text/css\" /><title>View Products</title></head>";
printallposts();
function printallposts()
{
$sqlusr = "web";
$sqlpwd = "Passw0rd01";
$con = mysql_connect("localhost",$sqlusr,$sqlpwd);
if (!$con)
{
die('Could not connect: ' . mysql_error());
}
mysql_select_db("my_db", $con);
$result = mysql_query("SELECT * FROM products");
while($row = mysql_fetch_array($result))
{
	echo "<div class=\"item\"><div class=\"itemheader\">" . $row['name'] . "</div><a class=\"popup\">";
	if($row['image'] == NULL)
	{
		echo "<img class=\"itemImage\" src=\"http://i.imgur.com/17hZv.jpg\" />";
	}
	else
	{
		echo "<img class=\"itemImage\" src=\"".$row['image']."\" />";
		
	}
	echo "<div class=\"itemprice\">".$row['price']."</div><span><ul>";
	for($i = 3; $i<=14; $i++){
		if($row[$i] != NULL)
		{
			echo"<li>".ucfirst(mysql_field_name($result, $i)).": ".$row[$i]."</li>";
		}
	}
	echo "</ul></span></a>";
	// echo "<div class=\"prodSpecs\"><ul>";
	// for($i = 3; $i<=13; $i++){
		// if($row[$i] != NULL)
		// {
			// echo"<li>".$row[$i]."</li>";
		// }
	// }
	// echo "</ul></div>";
	
	echo "</div>";
}
mysql_close($con);
}
?>