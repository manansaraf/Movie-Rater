<?php
include 'pageHeader.php';
?>

<html>
<head>
<link type="text/css" rel="stylesheet" href="side-menu.css"/>
<div id="main">
        <div class="header">
            <h1><center>ProjectTeamX myMovies</center></h1>
           
        
    </div>
</div>

	



	
	
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



<html>
<style>
p
{
margin-left:20px;
}
</style>
	<body>
		<center>
	<form action="addMovie.php" method="post">
	Movie Name: <input type="text" name="movieName"><br> 
	<input type="hidden" name="userName" value="<?=$userName?>" >
	<input type="submit" value="Search Movie" >
	</form></center>
	</body>
</html>
<?php
//echo "<h3>".$_SESSION["listID"]."</h3>";
//	echo '<h3>Movie Name: "'.$_POST["movieName"].'"</h3>';
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
echo"<html>
<style>
p
{
margin-left:150px;
}
</style>";
while($row)
{

	//echo 'Yo';
	
	$data = array("movieid" => $row["id"]);
	echo "<p><a href='addMovieToList.php?" . htmlentities(http_build_query($data)) ."'>". $row["title"] ."</a></p>";
	$row = mysql_fetch_assoc($result);
}
echo"</html>";
	//echo 'Yo2';






?>