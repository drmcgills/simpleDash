<?php
echo "<html><title></title><link rel=\"stylesheet\" type=\"text/css\" href=\"styles.css\" /><link rel=\"apple-touch-icon\" href=\"apple.png\"></head><body>";
echo "<div class=\"header\">SUPER AWESOME WEBSITE</div>";
echo "<div class=\"navlinks\"><a href=\"./\">Home</a> | ";
echo "<a href=\"./post.php\">New Post</a></div><br />";
if($_GET['p'] != NULL)
{
	hardlink($_GET['p']);
}
elseif($_GET['u'] != NULL)
{
	userposts($_GET['u']);
}
else
{
if(($_POST[title] != NULL) && (($_POST[content] != NULL) || ($_POST[image] != NULL)))
{
addpost();
}
printallposts();
}
echo "<a href=\"./post.php\">New Post</a>";
echo "</body></html>";
function prettydate($datevalue, $mode)
{
	#for mode "/" would mean 10/25/2011, "-" would mean 10-20-2011
	$year = substr($datevalue, 0, 4);
	$month = substr($datevalue, 5, 2);
	$day = substr($datevalue, 8, 2);
	switch($mode)
	{
		case "/":
		$rtnval = $month."/".$day."/".$year;
		break;
		case "-":
		$rtnval = $month."-".$day."-".$year;
		break;
	}	
	return $rtnval;
}
function hardlink($postid)
{
$con = mysql_connect("localhost","web","Passw0rd01");
if (!$con)
{
die('Could not connect: ' . mysql_error());
}
mysql_select_db("my_db", $con);
$result = mysql_query("SELECT * FROM dash WHERE postid=".$postid);
while($row = mysql_fetch_array($result))
{
	echo "<div class=\"post\"><div class=\"postheader\">" . $row['title'] . "</div>";
	echo "<div class=\"postbody\">" . $row['content'];
	if($row['image'] != "")
	{
		echo "<br /><img class=\"postimage\" src=\"" . $row['image'] . "\" />";
	}
	echo "</div>";
	if($row['time'] != "00:00:00")
	{
		echo "<div class=\"postdate\"><a href=\"editpost.php?p=" . $row['postid'] . "\">edit</a> Post #<a href=\"./?p=" . $row['postid'] . "\">" . $row['postid'] . "</a> on " . prettydate($row['date'], "-") . " at " . $row['time'] . " by <b>" . $row['user'] . "</b></div></div>";
	}
	else
	{
		echo "<div class=\"postdate\"><a href=\"editpost.php?p=" . $row['postid'] . "\">edit</a> Post #<a href=\"./?p=" . $row['postid'] . "\">" . $row['postid'] . "</a> on " . $row['date'] . " by <b>" . $row['user'] . "</b></div></div>";
	}
}
mysql_close($con);
}
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
$result = mysql_query("SELECT * FROM dash ORDER BY postid DESC");
while($row = mysql_fetch_array($result))
{
	echo "<div class=\"post\"><div class=\"postheader\">" . $row['title'] . "</div>";
	echo "<div class=\"postbody\">" . $row['content'];
	if($row['image'] != "")
	{
		echo "<br /><img class=\"postimage\" src=\"" . $row['image'] . "\" />";
	}
	echo "</div>";
	if($row['time'] != "00:00:00")
	{
		echo "<div class=\"postdate\">Post #<a href=\"./?p=" . $row['postid'] . "\">" . $row['postid'] . "</a> on " . prettydate($row['date'], "-") . " at " . $row['time'] . " by <b><a href=\"./?u=" . $row['user'] . "\">" . $row['user'] . "</a></b></div></div>";
	}
	else
	{
		echo "<div class=\"postdate\">Post #<a href=\"./?p=" . $row['postid'] . "\">" . $row['postid'] . "</a> on " . $row['date'] . " by <b><a href=\"./?u=" . $row['user'] . "\">" . $row['user'] . "</a></b></div></div>";
	}
}
mysql_close($con);
}
function addpost()
{
	if($_POST['posttype'] == "new")
	{
		$postdate = date(Y) . "-" . date(n) . "-" . date(j);
		$posttime = date(g) . ":" . date(i) . ":" . date(s);
		$stripwords = array("'");
		$content = str_replace($stripwords, "", $_POST['content']);
		if($_POST['user'] == NULL)
		{
			$postuser = "Default";
		}
		else
		{
			$postuser = $_POST['user'];
		}
		$con = mysql_connect("localhost","web","Passw0rd01");
		if (!$con)
		{
			die('Could not connect: ' . mysql_error());
		}
		mysql_select_db("my_db", $con);
		if($_POST['image'] != NULL)
		{
			$sql="INSERT INTO dash (date, title, content, user, time, image) VALUES ('$postdate','$_POST[title]','$content', '$_POST[user]', '$posttime', '$_POST[image]')";
		}
		else
		{
			$sql="INSERT INTO dash (date, title, content, user, time) VALUES ('$postdate','$_POST[title]','$content', '$_POST[user]', '$posttime')";
		}
		if (!mysql_query($sql,$con))
		{
			die('Error: ' . mysql_error());
		}
		mysql_close($con);
		echo "&nbsp;&nbsp;&nbsp;<b>1 Post submitted</b>";
	}
	elseif($_POST['posttype'] == "edit")
	{
		$con = mysql_connect("localhost","web","Passw0rd01");
		if (!$con)
		{
			die('Could not connect: ' . mysql_error());
		}
		mysql_select_db("my_db", $con);
		$title = $_POST['title'];
		$content = $_POST['content'];
		$user = $_POST['user'];
		$postid = $_POST['postid'];
		$image = $_POST['image'];
		$sql = "UPDATE dash SET `title`=\"" . $title . "\",`content`=\"" . $content . "\",`image`=\"" . $image . "\",`user`=\"" . $user . "\" WHERE `postid`=" . $postid;
		$sql2="UPDATE dash SET content = ".$_POST['content']." WHERE postid = 18";
		if (!mysql_query($sql,$con))
		{
			die('Error: ' . mysql_error() . "<br /><br />Query: " . $sql);
			
		}
		mysql_close($con);
		echo "&nbsp;&nbsp;&nbsp;<b>1 Post edited</b>";
	}
	else
	{
		echo "error";
	}
}
function userposts($username)
{
$con = mysql_connect("localhost","web","Passw0rd01");
if (!$con)
{
die('Could not connect: ' . mysql_error());
}
mysql_select_db("my_db", $con);
$result = mysql_query("SELECT * FROM dash WHERE user=\"" . $username . "\"ORDER BY postid DESC");
while($row = mysql_fetch_array($result))
{
	echo "<div class=\"post\"><div class=\"postheader\">" . $row['title'] . "</div>";
	echo "<div class=\"postbody\">" . $row['content'];
	if($row['image'] != "")
	{
		echo "<br /><img class=\"postimage\" src=\"" . $row['image'] . "\" />";
	}
	echo "</div>";
	if($row['time'] != "00:00:00")
	{
		echo "<div class=\"postdate\">Post #<a href=\"./?p=" . $row['postid'] . "\">" . $row['postid'] . "</a> on " . prettydate($row['date'], "-") . " at " . $row['time'] . " by <b>" . $row['user'] . "</b></div></div>";
	}
	else
	{
		echo "<div class=\"postdate\">Post #<a href=\"./?p=" . $row['postid'] . "\">" . $row['postid'] . "</a> on " . $row['date'] . " by <b>" . $row['user'] . "</b></div></div>";
	}
}
mysql_close($con);	
}
?>
