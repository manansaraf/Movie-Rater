<?php
session_start();
$link = mysql_connect('engr-cpanel-mysql.engr.illinois.edu', 'projectteamx_000', 'something') or die('Could not connect to server.' );
$selectResult = mysql_select_db ('projectteamx_projectDB', $link) or die('Could not select database.' );

$userName = $_SESSION["userName"];

$userID = mysql_query("SELECT id FROM Account WHERE userName='".$userName."'", $link);
$userID = mysql_fetch_array($userID)['id'];
mysql_query("SET AUTOCOMMIT=0");
mysql_query("START TRANSACTION");
$listName=''.$_GET["listName"].'';

$result=mysql_query("SELECT listName FROM userLists WHERE accountID='".$userID."' AND listName ='".$listName."'", $link);
$row = mysql_fetch_row($result);
if(!$row)
{
	echo '<h3>ERROR: List does not exist.</h3>';
	mysql_query("ROLLBACK");
}
else{
	$result = mysql_query("DELETE from userLists WHERE accountID='".$userID."' AND listName ='".$listName."'", $link);
	mysql_query("COMMIT");
	header( 'Location: viewLists.php' ) ;




}
?>