<html><title></title>
<link rel="stylesheet" type="text/css" href="styles.css" />
<link rel="apple-touch-icon" href="apple.png"></head>
<body>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="dash.js"></script>
<div class="header">SUPER AWESOME WEBSITE</div>
<div class="navlinks">
	<a href="./">Home</a>
	<a href="./?newpost">New Post</a>
</div>
<br />
<?php
#include("fns.php");
try
{
	$dbh = new PDO("mysql:host=localhost;dbname=my_db","web","Passw0rd01");
}
catch(PDOException $e)
{  
    echo $e->getMessage();  
}  
if(isset($_GET['p']))
{
	hardlink($_GET['p']);
}
elseif(isset($_GET['u']))
{
	userposts($_GET['u']);
}
elseif(isset($_GET['newpost']))
{
	newpost();
}
elseif(isset($_GET['edit']))
{
	editpost($_GET['id']);
}
else
{
	if((isset($_POST['title'])) && (isset($_POST['content']) || isset($_POST['image'])))
	{
		addpost();
	}
	printallposts();
}
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
	global $dbh;
	$sth = $dbh->prepare('SELECT * FROM dash WHERE postid=:postid');
	$sth->bindParam(':postid',$postid,PDO::PARAM_STR);
	$success = $sth->execute();
	if(!$success)
	{
		echo $sth->errorInfo();
	}
	while($row = $sth->fetch()) { ?>
		<div class="post"><div class="postheader"><?php echo $row['title'] ?></div>
		<div class="postbody"><?php echo $row['content'] ?>
		<?php
		if($row['image'] != "")
		{
			echo '<br /><img class="postimage" src="' . $row['image'] . '" />';
		}
		echo '</div>';
		if($row['time'] != '00:00:00') { ?>
			<div class="postdate">
				<a href="./?edit&id=<?php echo $row['postid'] ?>">edit</a>
				Post #<a href=./?p="<?php echo $row['postid'] ?>"><?php echo $row['postid'] ?></a>
				on <?php echo prettydate($row['date'], "-") ?>
				at <?php echo $row['time'] ?>
				by <b><a href="./?u=<?php echo $row['user'] ?>"><?php echo $row['user'] ?></a></b>
				</div>
			</div>
		<?php }
		else { ?>
			<div class="postdate">
				<a href="./?edit&id=<?php echo $row['postid'] ?>">edit</a>
				Post #<a href="<?php echo './?p='.$row['postid'] ?>"><?php echo $row['postid'] ?></a>
				on <?php echo prettydate($row['date'], "-") ?>
				by <b><a href="./?u=<?php echo $row['user'] ?>"><?php echo $row['user'] ?></a></b>
				</div>
			</div>
		<?php }
	}
}
function printallposts()
{
	global $dbh;
	$sth = $dbh->prepare('SELECT * FROM dash ORDER BY postid DESC');
	$success = $sth->execute();
	if(!$success)
	{
		echo $sth->errorInfo();
	}
	while($row = $sth->fetch()) { ?>
		<div class="post"><div class="postheader"><?php echo $row['title'] ?></div>
		<div class="postbody"><?php echo $row['content'] ?>
		<?php
		if($row['image'] != "")
		{
			echo '<br /><img class="postimage" src="' . $row['image'] . '" />';
		}
		echo '</div>';
		if($row['time'] != '00:00:00') { ?>
			<div class="postdate">
				<a href="./?edit&id=<?php echo $row['postid'] ?>">edit</a>
				Post #<a href="<?php echo './?p='.$row['postid'] ?>"><?php echo $row['postid'] ?></a>
				on <?php echo prettydate($row['date'], "-") ?>
				at <?php echo $row['time'] ?>
				by <b><a href="./?u=<?php echo $row['user'] ?>"><?php echo $row['user'] ?></a></b>
				</div>
			</div>
		<?php }
		else { ?>
			<div class="postdate">
				<a href="./?edit&id=<?php echo $row['postid'] ?>">edit</a>
				Post #<a href="<?php echo './?p='.$row['postid'] ?>"><?php echo $row['postid'] ?></a>
				on <?php echo prettydate($row['date'], "-") ?>
				by <b><a href="./?u=<?php echo $row['user'] ?>"><?php echo $row['user'] ?></a></b>
				</div>
			</div>
		<?php }
	}
}
function addpost()
{
	global $dbh;
	if($_POST['posttype'] == "new")
	{
		$postdate = date(Y) . "-" . date(n) . "-" . date(j);
		$posttime = date(g) . ":" . date(i) . ":" . date(s);
		$postuser = $_POST['user'] == NULL ? "Default" : $_POST['user'];
		$sth = $dbh->prepare("INSERT INTO dash (date, title, content, user, time, image) VALUES (?,?,?,?,?,?)");
		$data = array($postdate,$_POST['title'],$_POST['content'],$_POST['user'],$posttime,$_POST['image']);
		$success = $sth->execute($data);
		if (!$success)
		{
			echo $sth->errorInfo();
		}
		echo "&nbsp;&nbsp;&nbsp;<b>1 Post submitted</b>";
	}
	elseif($_POST['posttype'] == "edit")
	{
		$title = $_POST['title'];
		$content = $_POST['content'];
		$user = $_POST['user'];
		$postid = $_POST['postid'];
		$image = $_POST['image'];
		$sth = $dbh->prepare("UPDATE dash SET title=?,content=?,image=?,user=? WHERE postid=?");
		$data = array($_POST['title'],$_POST['content'],$_POST['image'],$_POST['user'],$_POST['postid']);
		$success = $sth->execute($data);
		if (!$success)
		{
			echo $sth->errorInfo();			
		}
		echo "&nbsp;&nbsp;&nbsp;<b>1 Post edited</b>";
	}
	else
	{
		echo "error";
	}
}
function userposts($username)
{
	global $dbh;
	$sth = $dbh->prepare("SELECT * FROM dash WHERE user=:user ORDER BY postid DESC");
	$sth->bindParam(':user',$username,PDO::PARAM_STR);
	$success = $sth->execute();
	while($row = $sth->fetch()) { ?>
		<div class="post"><div class="postheader"><?php echo $row['title'] ?></div>
		<div class="postbody"><?php echo $row['content'] ?>
		<?php
		if($row['image'] != "") { ?>
			<br /><img class="postimage" src="<?php echo $row['image'] ?>" />
		<?php }
		echo "</div>";
		if($row['time'] != '00:00:00') { ?>
			<div class="postdate">
				<a href="./?edit&id=<?php echo $row['postid'] ?>">edit</a>
				Post #<a href="<?php echo './?p='.$row['postid'] ?>"><?php echo $row['postid'] ?></a>
				on <?php echo prettydate($row['date'], "-") ?>
				at <?php echo $row['time'] ?>
				by <b><a href="./?u=<?php echo $row['user'] ?>"><?php echo $row['user'] ?></a></b>
				</div>
			</div>
		<?php }
		else { ?>
			<div class="postdate">
				<a href="./?edit&id=<?php echo $row['postid'] ?>">edit</a>
				Post #<a href="<?php echo './?p='.$row['postid'] ?>"><?php echo $row['postid'] ?></a>
				on <?php echo prettydate($row['date'], "-") ?>
				by <b><a href="./?u=<?php echo $row['user'] ?>"><?php echo $row['user'] ?></a></b>
				</div>
			</div>
		<?php }
	}
}
function newpost()
{
	// global $dbh;
	// $sth = $dbh->prepare('SELECT * FROM dash WHERE postid=:postid');
	// $sth->bindParam(':postid',$postid,PDO::PARAM_STR);
	// $success = $sth->execute();
	// if(!$success)
	// {
		// echo $sth->errorInfo();
	// }
	?>
		<form action="index.php" method="post" enctype="multipart/form-data" id="newpost">
			<div class="post">
				<div class="postheader"><input type="text" name="title" value="title" /></div>
				<div class="postbody">
					<textarea name="content">body content</textarea>
					<input type="hidden" name="posttype" value="new" />
					<input type="hidden" name="user" value="john" />
					<br />
					<input type="text" name="image" value="image url" /><input type="submit" />
				</div>
			</div>
		</form>
	<?php }
function editpost($postid)
{
	global $dbh;
	$sth = $dbh->prepare("SELECT * FROM dash WHERE postid=:postid");
	$sth->bindParam(':postid',$postid,PDO::PARAM_STR);
	$success = $sth->execute();
	while($row = $sth->fetch()){
	?>
		<form action="index.php" method="post" enctype="multipart/form-data">
			<div class="post">
				<div class="postheader"><input class="input" type="text" name="title" value="<?php echo $row['title'] ?>" /></div>
				<div class="postbody">
					<textarea name="content"><?php echo $row['content'] ?></textarea>
					<input type="hidden" name="posttype" value="edit" />
					<input type="hidden" name="user" value="john" />
					<input type="hidden" name="postid" value=" <?php echo $postid ?>" />
					<br />
					<input type="text" name="image" value="<?php echo $row['image'] ?>" /><input type="submit" value="commit" />
				</div>
			</div>
		</form>
	<?php }
}
function printapost($postid)
{

}
?>
</body></html>