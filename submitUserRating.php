<?php
include 'pageHeader.php';
session_start();

$link = mysql_connect('engr-cpanel-mysql.engr.illinois.edu', 'projectteamx_000', 'something') or die('Could not connect to server.' );

$selectResult = mysql_select_db ('projectteamx_projectDB', $link) or die('Could not select database.' );

mysql_query("SET AUTOCOMMIT=0");
mysql_query("START TRANSACTION");

$result = mysql_query("SELECT * FROM userRates WHERE userId='".$_POST["userId"]."' AND movieId='".$_POST["movieId"]."'");

$row = mysql_fetch_assoc($result);

if(!$row)
{
	$result = mysql_query("INSERT INTO userRates(userId, movieId, rating) VALUE ('".$_POST["userId"]."', '".$_POST["movieId"]."', '".$_POST["rating"]."')", $link);
}
else
{
	$result = mysql_query("UPDATE userRates SET rating=".$_POST["rating"]." WHERE userId='".$_POST["userId"]."' AND movieId='".$_POST["movieId"]."'", $link);
}

mysql_query("COMMIT");
$data = array("movieid" => $_POST["movieId"]);
header("location:moviePage.php?".htmlentities(http_build_query($data)));


?>