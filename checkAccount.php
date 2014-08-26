<?php

//echo '<h3>User Name: "'.$_POST["userName"].'"</h3>';
//echo '<h3>Password: "'.$_POST["password"].'"</h3>';


$link = mysql_connect('engr-cpanel-mysql.engr.illinois.edu', 'projectteamx_000', 'something') or die('Could not connect to server.' );

$selectResult = mysql_select_db ('projectteamx_projectDB', $link) or die('Could not select database.' );

$result = mysql_query("SELECT * FROM Account WHERE userName='".$_POST["userName"]."' AND pass='".$_POST["password"]."'");

$row = mysql_fetch_assoc($result);

if(!$row)
{
	echo '<h3>Invalid Log In.</h3>';
}
else
{
	//echo "<h3>Logged in as ". $row["userName"] ."</h3>";
	session_start();
	$_SESSION["userName"] = $row["userName"];
	$_SESSION["pass"] = $row["pass"];
	$_SESSION["userId"] = $row["id"];
	header("location:viewLists.php");
}

?>