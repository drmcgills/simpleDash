<?php
echo "<html><title></title><link rel=\"stylesheet\" type=\"text/css\" href=\"styles.css\" /></head><body>";
echo "<h1>SUPER AWESOME WEBSITE</h1>";
if(userexists($_POST['uname']) > 0)
{
	echo "<div class=\"header\">user already exists</div>";
}
else
{
	if($_POST['pwd1'] == $_POST['pwd2'])
	{
		add($_POST['uname'],$_POST['pwd1']);
	}
	else
	{
		echo "<div class=\"header\">password mismatch</div>";
	}
}
function userexists($username)
{
		$count = 0;
		$con = mysql_connect("localhost","web","Passw0rd01");
		if (!$con)
		{
			die('Could not connect: ' . mysql_error());
		}
		mysql_select_db("my_db", $con);
		$sql = "SELECT * FROM members WHERE `username`=\"".$username."\"";
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result))
		{
			$count++;
		}
		if (!mysql_query($sql,$con))
		{
			die('Error: ' . mysql_error());
		}
		mysql_close($con);
		return $count;
}



function add($uname, $pass)
{
		$con = mysql_connect("localhost","web","Passw0rd01");
		if (!$con)
		{
			die('Could not connect: ' . mysql_error());
		}
		mysql_select_db("my_db", $con);
		$sql="INSERT INTO members (username, password) VALUES ('$uname','$pass')";
		if (!mysql_query($sql,$con))
		{
			die('Error: ' . mysql_error());
		}
		mysql_close($con);
		echo "User added";
}
/*
if(checkexists($_POST['uname']))
{
	if($_POST[pwd1] == $_POST[pwd2])
	{
		add($_POST[uname], $_POST[pwd1]);
	}
	else
	{
		echo "Password mismatch";
	}
	echo "</body></form>";
	
}
else
{
	echo "User already exists";
	echo checkexists($_POST['uname']);
}
function checkexists($uname)
{
	$con = mysql_connect("localhost","web","Passw0rd01");
	if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db("my_db", $con);
	$result = mysql_query("SELECT username FROM members WHERE username=\"".$uname."\"");

	if (!mysql_query($result,$con))
	{
		die('Errorrrr: ' . mysql_error());
	}

	if(mysql_num_rows($result) !== NULL)
	{
		#die("numrows = ".mysql_num_rows($result));
		$exists = true;
	}
	else
	{
		$exists = false;
	}

	return $exists;
}  
*/
?>
