<?php
include 'index.php';
echo '<h3>User Name: "'.$_POST["userName"].'"</h3>';
echo '<h3>Password: "'.$_POST["password"].'"</h3>';


$link = mysql_connect('engr-cpanel-mysql.engr.illinois.edu', 'projectteamx_000', 'something') or die('Could not connect to server.' );

$selectResult = mysql_select_db ('projectteamx_projectDB', $link) or die('Could not select database.' );

mysql_query("SET AUTOCOMMIT=0");
mysql_query("START TRANSACTION");

$result = mysql_query("SELECT userName FROM Account WHERE userName='".$_POST["userName"]."'");

$row = mysql_fetch_row($result);

if(!$row)
{
	$result = mysql_query("INSERT INTO Account(userName, pass) VALUE ('".$_POST["userName"]."', '".$_POST["password"]."')", $link);
	mysql_query("COMMIT");
	echo '<h3>User added.</h3>';
}
else
{
	echo '<h3>User already exists.</h3>';
	mysql_query("ROLLBACK");
}

?>