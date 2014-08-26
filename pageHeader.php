<?php
ob_start();
session_start();
$userName = $_SESSION["userName"];
if(isset($_SESSION["userName"]))
{
	if(!isset($pageHeader))
	{
		echo "<p align=right>Logged in as ". $_SESSION["userName"] ." - <a href='viewLists.php?'>Home</a> - <a href='logOut.php?'>Log Out</a></p>";
		echo "<hr>";
		$pageHeader = TRUE;
	}
}
else
{
header("location:/");
}
?>