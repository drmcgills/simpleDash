<?php
$postdate = date(Y) . "-" . date(n) . "-" . date(j);
$con = mysql_connect("localhost","web","Passw0rd01");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db("my_db", $con);
$sql="INSERT INTO dash (date, title, content, user)
VALUES
('$postdate','$_POST[title]','$_POST[content]', 'John')";
if (!mysql_query($sql,$con))
  {
  die('Error: ' . mysql_error());
  }
mysql_close($con);
?>
