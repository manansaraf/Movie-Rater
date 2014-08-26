<?php
include 'pageHeader.php';
?>

<html>
<head>
<link type="text/css" rel="stylesheet" href="side-menu.css"/>
<div id="main">
        <div class="header">
            <h1>ProjectTeamX myMovies</h1>
           
        
    </div>
</div>
<div style="width: 500px; margin: 200px auto 0 auto;">
<h1> </h1>
</head>
<body>
<div id="layout">
    <!-- Menu toggle -->
    <a href="#menu" id="menuLink" class="menu-link">
        <!-- Hamburger icon -->
        <span></span>
    </a>

    <div id="menu">
        <div class="pure-menu pure-menu-open">
            <a class="pure-menu-heading" href="#">CS 411 Project</a>

            <ul>
                <li><a href="http://projectteamx.web.engr.illinois.edu">Home</a></li>
                <li><a href="http://projectteamx.web.engr.illinois.edu/viewLists.php?">My Movie Lists</a></li>
 		<li><a href="http://projectteamx.web.engr.illinois.edu/allMovies.php?">All Movies</a></li>
                <li><a href="http://projectteamx.web.engr.illinois.edu/movieSearch.php?">Search Movies</a></li>

                
            </ul>
        </div>
    </div>

    
</div>
</body>
</html>
<?php

session_start();

$link = mysql_connect('engr-cpanel-mysql.engr.illinois.edu', 'projectteamx_000', 'something') or die('Could not connect to server.' );

$selectResult = mysql_select_db ('projectteamx_projectDB', $link) or die('Could not select database.' );

$movieResult = mysql_query("SELECT * FROM MyMovies WHERE id=".$_GET["movieid"]."");

$movieRow = mysql_fetch_assoc($movieResult);

if($movieRow)
{
	$userRatingResult = mysql_query("SELECT * FROM userRates WHERE userId='".$_SESSION["userId"]."' AND movieId='".$movieRow["id"]."'");
	$userRatingRow = mysql_fetch_assoc($userRatingResult);
	
	$webRatingResult = mysql_query("SELECT * FROM websitesRates JOIN Websites ON Websites.id = websitesRates.websiteId  WHERE movieId='".$movieRow["id"]."'");
	$webRatingRow = mysql_fetch_assoc($webRatingResult);
	
	$subStringStart = strpos($movieRow["title"], '(');
	$movieTitleNoDate = substr($movieRow["title"], 0, $subStringStart - 1);
	$otherUserRating = mysql_query("SELECT avg(rating) FROM userRates WHERE movieid='".$movieRow["id"]."' AND userId<>'".$_SESSION["userId"]."'  GROUP BY movieid");
	$otherUserRow = mysql_fetch_assoc($otherUserRating);
	echo "<html>";
	echo "<head>";
	echo"<div class=\"content\">
            <h2 class=\"content-subhead\">".$movieTitleNoDate. " Ratings</h2>
            <p>";
        while($webRatingRow)
	{
		echo $webRatingRow["name"].": ".$webRatingRow["rating"]."<br>";
		$webRatingRow = mysql_fetch_assoc($webRatingResult);
	}
	
	echo "Other User Ratings: ".$otherUserRow["avg(rating)"];
	
	echo "<form action='submitUserRating.php' method='post'>";
	if($userRatingRow)
	{
		echo "Rating: <input type='text' name='rating' value=".$userRatingRow["rating"]."><br>";
	}
	else
	{
		echo "Rating: <input type='text' name='rating'><br>";
	}
	echo "<input type='hidden' name='userId' value='". $_SESSION["userId"] ."'/>";
	echo "<input type='hidden' name='movieId' value='". $movieRow["id"] ."'/> ";
	echo "<input type='submit'>";
	echo "</form>";    
        echo  "</p>
        </div>";
			
	
	

	
	$temp = mysql_query("SELECT userRates.movieId AS movieId, userRates.rating AS userRating, websiteId, websitesRates.rating AS siteRating, ABS(websitesRates.rating-userRates.rating) AS diff FROM userRates JOIN websitesRates WHERE userId='".$_SESSION["userId"]."' AND userRates.movieId=websitesRates.movieId ORDER BY websiteId");

	$temp2 =mysql_num_rows($temp);
	
	if(mysql_num_rows($temp) > 0){

	
		$closestResult=mysql_query("SELECT name, rating FROM (SELECT a1.websiteId AS id, AVG(diff) AS ave FROM (SELECT userRates.movieId AS movieId, userRates.rating AS userRating, websiteId, websitesRates.rating AS siteRating, ABS(websitesRates.rating-userRates.rating) AS diff FROM userRates JOIN websitesRates WHERE userId='".$_SESSION["userId"]."' AND userRates.movieId=websitesRates.movieId ORDER BY websiteId) AS a1 GROUP BY a1.websiteId ORDER BY ave ASC LIMIT 1) AS b1 JOIN Websites AS w JOIN websitesRates AS r WHERE b1.id=w.id AND r.movieId='".$movieRow["id"]."' AND r.websiteId=w.id");
		
		

		
		if($closestResult){
			$closestrow = mysql_fetch_assoc($closestResult);
			echo "The closest website rating to your previous ratings is  ". $closestrow["name"];
		}
		else
		{
			
		}
	}
	else
	{
	
	}
	
	echo "</head>";
	echo "</html>";
}

?>
