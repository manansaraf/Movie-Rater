<?php
session_start();
$link = mysql_connect('engr-cpanel-mysql.engr.illinois.edu', 'projectteamx_000', 'something') or die('Could not connect to server.' );
$selectResult = mysql_select_db ('projectteamx_projectDB', $link) or die('Could not select database.' );

$userName = $_SESSION["userName"];


$userID = $_SESSION[userId];
$listID=$_SESSION[listID];
mysql_query("SET AUTOCOMMIT=0");
mysql_query("START TRANSACTION");


$result1=mysql_query("SELECT listName FROM userLists WHERE accountID='".$userID."' AND listID ='".$listID."'", $link);
$row = mysql_fetch_row($result1);
if(!$row)
{
	echo '<h3>ERROR: List does not exist.</h3>';
	mysql_query("ROLLBACK");
}
else{
	$result = mysql_query("INSERT INTO userListMovies(listID,movieID) VALUE ('".$listID."', '".$_GET["movieid"]."')", $link);
	mysql_query("COMMIT");
	header( 'Location: viewListMovies.php?listName='.$_SESSION["listName"]) ;




}
?>