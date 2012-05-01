<?php
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
		// if($row['time'] != '00:00:00')
		// { 
			// echo '<div class="postdate"><a href="editpost.php?p=' . $row['postid'] . '">edit</a> Post #<a href="./?p=' . $row['postid'] . '">' . $row['postid'] . '</a> on ' . prettydate($row['date'], "-") . ' at ' . $row['time'] . ' by <b>' . $row['user'] . '</b></div></div>';
		// }
		// else
		// {
			// echo '<div class="postdate"><a href="editpost.php?p=' . $row['postid'] . '">edit</a> Post #<a href="./?p=' . $row['postid'] . '">' . $row['postid'] . '</a> on ' . $row['date'] . ' by <b>' . $row['user'] . '</b></div></div>';
		// }
		if($row['time'] != '00:00:00') { ?>
			<div class="postdate">
				<a href="editpost.php?p="<?php echo $row['postid'] ?>">edit</a>
				Post #<a href=./?p="<?php echo $row['postid'] ?>"><?php echo $row['postid'] ?></a>
				on <?php echo prettydate($row['date'], "-") ?>
				at <?php echo $row['time'] ?>
				by <b><a href="./?u=<?php echo $row['user'] ?>"><?php echo $row['user'] ?></b></a>
				</div>
			</div>
		<?php }
		else { ?>
			<div class="postdate">
				<a href="editpost.php?p="<?php echo $row['postid'] ?>">edit</a>
				Post #<a href="<?php echo './?p='.$row['postid'] ?>"><?php echo $row['postid'] ?></a>
				on <?php echo prettydate($row['date'], "-") ?>
				by <b><a href="./?u=<?php echo $row['user'] ?>"><?php echo $row['user'] ?></b></a>
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
				<a href="editpost.php?p="<?php echo $row['postid'] ?>">edit</a>
				Post #<a href="<?php echo './?p='.$row['postid'] ?>"><?php echo $row['postid'] ?></a>
				on <?php echo prettydate($row['date'], "-") ?>
				at <?php echo $row['time'] ?>
				by <b><a href="./?u=<?php echo $row['user'] ?>"><?php echo $row['user'] ?></b></a>
				</div>
			</div>
		<?php }
		else { ?>
			<div class="postdate">
				<a href="editpost.php?p="<?php echo $row['postid'] ?>">edit</a>
				Post #<a href="<?php echo './?p='.$row['postid'] ?>"><?php echo $row['postid'] ?></a>
				on <?php echo prettydate($row['date'], "-") ?>
				by <b><a href="./?u=<?php echo $row['user'] ?>"><?php echo $row['user'] ?></b></a>
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
				<a href="editpost.php?p="<?php echo $row['postid'] ?>">edit</a>
				Post #<a href="<?php echo './?p='.$row['postid'] ?>"><?php echo $row['postid'] ?></a>
				on <?php echo prettydate($row['date'], "-") ?>
				at <?php echo $row['time'] ?>
				by <b><a href="./?u=<?php echo $row['user'] ?>"><?php echo $row['user'] ?></b></a>
				</div>
			</div>
		<?php }
		else { ?>
			<div class="postdate">
				<a href="editpost.php?p="<?php echo $row['postid'] ?>">edit</a>
				Post #<a href="<?php echo './?p='.$row['postid'] ?>"><?php echo $row['postid'] ?></a>
				on <?php echo prettydate($row['date'], "-") ?>
				by <b><a href="./?u=<?php echo $row['user'] ?>"><?php echo $row['user'] ?></b></a>
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
		<form action="index.php" method="post" enctype="multipart/form-data">
			<div class="post">
				<div class="postheader"><input type="text" name="title" value="title" /></div>
				<div class="postbody">
					<input type="textarea" name="content">body content</textarea>
					<br />
					<input type="hidden" name="user" value="john" />
					<input type="text" name="image" value="image url" /><input type="submit" />
				</div>
			</div>
		</form>
	<?php}