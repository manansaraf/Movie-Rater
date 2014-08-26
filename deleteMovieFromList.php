<?php
	include 'pageHeader.php';
	session_start();
	$userName = $_SESSION["userName"];
	$listID=$_SESSION["listID"];
	$movieid=$_GET["movieid"];
	echo $movieid;
	$link = mysql_connect('engr-cpanel-mysql.engr.illinois.edu', 'projectteamx_000', 'something') or 			
	die('Could not connect to server.' );	
	$selectResult = mysql_select_db ('projectteamx_projectDB', $link) or 
	die('Could not select database.' );
	mysql_query("SET AUTOCOMMIT=0");
	mysql_query("START TRANSACTION");


	$result = mysql_query("DELETE FROM userListMovies WHERE listID ='".$listID."'AND movieID='".$movieid."';");
	mysql_query("COMMIT");
	header( 'Location: viewListMovies.php?listName='.$_SESSION["listName"]) ;





?>