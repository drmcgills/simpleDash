<?php
if($_POST[prodName] != NULL)
{
	addpost();
}
else
{
	echo"<html>
		<head>
		<title>Add Item</title>
		<link href=\"styles.css\" rel=\"stylesheet\" type=\"text/css\" />
		</head>
		<body>
		<div class=\"pageHeader\">Add Item to Database</div>
		<form action=\"addItem.php\" method=\"post\">
		<ul class=\"prodSpecs\">
		<li>Name: <input type=\"text\" name=\"prodName\" /></li>
		<li>Model: <input type=\"text\" name=\"prodModel\" /></li>
		<li>Serial #: <input type=\"text\" name=\"prodSerial\" /></li>
		<li>Software: <input type=\"text\" name=\"prodSoftware\" /></li>
		<li>Applecare: <input type=\"text\" name=\"prodAppleCare\" /></li>
		<li>CPU: <input type=\"text\" name=\"prodCPU\" /></li>
		<li>RAM: <input type=\"text\" name=\"prodRAM\" /></li>
		<li>HDD: <input type=\"text\" name=\"prodHDD\" /></li>
		<li>HDD 2: <input type=\"text\" name=\"prodHDD2\" /></li>
		<li>Graphics: <input type=\"text\" name=\"prodGraphics\" /></li>
		<li>Battery Cycles: <input type=\"text\" name=\"prodBattCycles\" /></li>
		<li>Battery Condition: <input type=\"text\" name=\"prodBattCond\" /></li>
		<li>Accessories: <input type=\"text\" name=\"prodAccessories\" /></li>
		<li>Image (url): <input type=\"text\" name=\"prodImage\" /></li>
		<li><input type=\"submit\" id=\"submitBtn\" value=\"Submit\" /></li>
		</ul>
		</form>
		</body>
		</html>";
}

function addpost()
{
	$con = mysql_connect("localhost","web","Passw0rd01");
	if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db("my_db", $con);

		$sql="INSERT INTO products (name, model, serial, software, applecare, cpu, ram, hdd, hdd2, graphics, battcycles, battcond, accessories, image) 
				VALUES ('$_POST[prodName]','$_POST[prodModel]','$_POST[prodSerial]','$_POST[prodSoftware]','$_POST[prodApplecare]','$_POST[prodCPU]','$_POST[prodRAM]','$_POST[prodHDD]','$_POST[prodHDD2]','$_POST[prodGraphics]','$_POST[prodBattCycles]','$_POST[prodBattCond]','$_POST[prodAccessories]','$_POST[prodImage]')";
	if (!mysql_query($sql,$con))
	{
		die('Error: ' . mysql_error());
	}
	mysql_close($con);
	echo "<html><head><title>Product Added</title></head><body><h1>Product Added to Database</h1></body></html>";
}
?>
