<?php
include 'pageHeader.php';
include 'rottentomatoes.php';
$link = mysql_connect('engr-cpanel-mysql.engr.illinois.edu', 'projectteamx_000', 'something') or die('Could not connect to server.' );

$selectResult = mysql_select_db ('projectteamx_projectDB', $link) or die('Could not select database.' );

$result = mysql_query("SELECT * FROM MyMovies");

$row = mysql_fetch_assoc($result);


$count = 0;

while($row && $count < 20)
{
	$data = array("movieid" => $row["id"]);
	echo "<a href='moviePage.php?" . htmlentities(http_build_query($data)) ."'>". $row["title"] ."</a><br>";
	
	
	$subStringStart = strpos($row["title"], '(');
	$movieTitleNoDate = substr($row["title"], 0, $subStringStart - 1);
	
	
	$rottentomatoes = new RottenTomatoes();
	$rottenMovieArray = $rottentomatoes->getMovieInfo($movieTitleNoDate);
	if($rottenMovieArray)
	{
	/*
		echo "Rotten Tomatoes User Rating: ". $rottenMovieArray['user_average_rating'] ." <br>";
		echo "Rotten Tomatoes Critic Rating: ". $rottenMovieArray['all_critics_average_rating'] . " <br>";
		
		echo "f:Rotten Tomatoes User Rating: ". floatval($rottenMovieArray['user_average_rating']) ." <br>";
		echo "f:Rotten Tomatoes Critic Rating: ". floatval($rottenMovieArray['all_critics_average_rating']) . " <br>";
		echo "f2:Rotten Tomatoes User Rating: ". (floatval($rottenMovieArray['user_average_rating']) / 5.0 ) ." <br>";
		echo "f2:Rotten Tomatoes User Rating: ". ((floatval($rottenMovieArray['user_average_rating']) / 5.0 ) * 100.0) ." <br>";
		echo "f2:Rotten Tomatoes User Rating: ". intval((floatval($rottenMovieArray['user_average_rating']) / 5.0 ) * 100.0) ." <br>";
		*/
		$rtur = ((floatval($rottenMovieArray['user_average_rating']) / 5.0 ) * 100.0);
		$rtcr = ((floatval($rottenMovieArray['all_critics_average_rating']) / 10.0 ) * 100.0);
	
		//echo "Rotten Tomatoes User Rating: ". $rtur ." <br>";
		//echo "Rotten Tomatoes Critic Rating: ". $rtcr . " <br>";
		
		$result2 = mysql_query("INSERT INTO websitesRates (movieId, websiteId, rating) VALUES (".$row["id"].", 2, ". $rtur .")");
		$result2 = mysql_query("INSERT INTO websitesRates (movieId, websiteId, rating) VALUES (".$row["id"].", 3, ". $rtcr .")");
	}
	
	$row = mysql_fetch_assoc($result);
	//$count = $count + 1;
}


?>