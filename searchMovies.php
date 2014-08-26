<?php
include 'pageHeader.php';



include 'movieSearch.php';

echo"<html>
<style>
p
{
margin-left:150px;
}
</style>";
echo '<p>Movie Name: "'.$_POST["movieName"].'"</p>';
//$userName = $_POST['userName'];
// $userName = $_SESSION["userName"];  Session

$link = mysql_connect('engr-cpanel-mysql.engr.illinois.edu', 'projectteamx_000', 'something') or die('Could not connect to server.' );

$selectResult = mysql_select_db ('projectteamx_projectDB', $link) or die('Could not select database.' );

$movie = sprintf('%s%s', '"', $_POST["movieName"]);

//echo "$movie";

$result = mysql_query("SELECT * FROM MyMovies WHERE title LIKE '".$_POST["movieName"]."%' OR title LIKE '".$movie."%' ");


//".$_POST["movieName"]."


// title AS MovieName

$row = mysql_fetch_assoc($result);


while($row)
{

	//echo 'Yo';

	$data = array("movieid" => $row["id"]);
	echo "<p><a href='moviePage.php?" . htmlentities(http_build_query($data)) ."'>". $row["title"] ."</a></p>";
	$row = mysql_fetch_assoc($result);
}

	//echo 'Yo2';


?>