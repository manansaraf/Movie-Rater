<?php
echo "<h3>Recomendations</h3>";

$link = mysql_connect('engr-cpanel-mysql.engr.illinois.edu', 'projectteamx_000', 'something') or 			
die('Could not connect to server.' );	
$selectResult = mysql_select_db ('projectteamx_projectDB', $link) or 
die('Could not select database.' );

$list1ID = $_SESSION["listID"];

$recomendationsQuerey = mysql_query("SELECT DISTINCT movieID, comparison FROM ListRecomendations WHERE list1ID = ". $list1ID ." AND comparison <> 1 ORDER BY comparison DESC LIMIT 10");

$row = mysql_fetch_assoc($recomendationsQuerey);
while($row)
{
	$movieID=$row["movieID"];
	$comparison=$row["comparison"];
	//echo "<h3>".$movieID."</h3>";
	$movieName=mysql_query("SELECT * FROM MyMovies WHERE id='".$movieID."'", $link);
	$row1 = mysql_fetch_assoc($movieName);
	$data = array("movieid" => $row1["id"]);
	$subStringStart = strpos($row1["title"], '(');
	$movieTitleNoDate = substr($row1["title"], 0, $subStringStart - 1);
	echo "<a href='moviePage.php?" . htmlentities(http_build_query($data)) ."'>". 	
	$movieTitleNoDate ./*"-".$comparison.*/"</a><br>";
	$row = mysql_fetch_assoc($recomendationsQuerey);
}

/*
$userName = $_SESSION["userName"];
	$listName = $_GET["listName"];
	
	
	
	
	
	
	
	
	
	
	
	
CREATE VIEW ListComparisons AS SELECT intersections.list1ID AS list1ID, intersections.list2ID AS list2ID, intersections.movieCount / ListSizes.listSize AS comparison FROM 
ListSizes 
JOIN
(SELECT list1.listID AS list1ID, list2.listID AS list2ID,  COUNT(DISTINCT list1.movieID) AS movieCount FROM 
(SELECT * FROM userListMovies) AS list1
JOIN 
(SELECT * FROM userListMovies) AS list2
ON list1.movieID = list2.movieID AND list1.listID <> list2.listID
GROUP BY list1.listID, list2.listID) AS intersections
ON intersections.list2ID = listID;

SELECT IntersectionSizes.list1ID AS list1ID, IntersectionSizes.list2ID AS list2ID, IntersectionSizes.movieCount / ListSizes.listSize AS comparison FROM 
ListSizes 
JOIN
IntersectionSizes
ON IntersectionSizes.list2ID = listID;

CREATE VIEW ListComparisons AS SELECT IntersectionSizes.list1ID AS list1ID, IntersectionSizes.list2ID AS list2ID, IntersectionSizes.movieCount / ListSizes.listSize AS comparison FROM 
ListSizes 
JOIN
IntersectionSizes
ON IntersectionSizes.list2ID = listID;
	
	CREATE VIEW ListIntersection AS SELECT list1.listID AS list1ID, list2.listID AS list2ID,  list1.movieID AS movieID FROM 
userListMovies AS list1
JOIN 
userListMovies AS list2
ON list1.movieID = list2.movieID AND list1.listID <> list2.listID


CREATE VIEW ListDifference AS SELECT DISTINCT ListProduct.list1ID AS list1ID, ListProduct.list2ID AS list2ID, ListProduct.movieID as movieID 
FROM ListProduct LEFT JOIN ListIntersection ON 
ListProduct.list1ID = ListIntersection.list1ID AND 
ListProduct.list2ID = ListIntersection.list2ID AND 
ListProduct.movie2ID = ListIntersection.movieID WHERE ListIntersection.movieID IS NULL


SELECT ListComparisons.list1ID AS list1ID, ListComparisons.list2ID AS list2ID, ListComparisons.comparison AS comparison, ListDifference.movieID AS movieID 
FROM ListComparisons 
JOIN ListDifference 
ON ListComparisons.list1ID = ListDifference.list1ID AND ListComparisons.list2ID = ListDifference.list2ID

CREATE VIEW ListRecomendations AS SELECT ListComparisons.list1ID AS list1ID, ListComparisons.list2ID AS list2ID, ListComparisons.comparison AS comparison, ListDifference.movieID AS movieID FROM ListComparisons JOIN ListDifference ON ListComparisons.list1ID = ListDifference.list1ID AND ListComparisons.list2ID = ListDifference.list2ID

	*/
?>