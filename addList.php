<?php

session_start();

$userName = $_SESSION["userName"];

$link = mysql_connect('engr-cpanel-mysql.engr.illinois.edu', 'projectteamx_000', 'something') or die('Could not connect to server.' );
$selectResult = mysql_select_db ('projectteamx_projectDB', $link) or die('Could not select database.' );

mysql_query("SET AUTOCOMMIT=0");
mysql_query("START TRANSACTION");

$result = mysql_query("SELECT userName FROM Account WHERE userName='".$userName."'");

$row = mysql_fetch_row($result);

if(!$row)
{
	echo '<h3>ERROR: User does not exist.</h3>';
	mysql_query("ROLLBACK");
}
else
{
	$userID = mysql_query("SELECT id FROM Account WHERE userName='".$userName."'", $link);
	$userID = mysql_fetch_array($userID)['id'];

	$result = mysql_query("INSERT INTO userLists(accountID, listName) VALUES ('".$userID."', '".$_POST["listName"]."')", $link);
	
	mysql_query("COMMIT");
	header( 'Location: viewLists.php' ) ;
}

?>