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
<?php
	
	session_start();
	$userName = $_SESSION["userName"];
	$listName = $_GET["listName"];
	
	$link = mysql_connect('engr-cpanel-mysql.engr.illinois.edu', 'projectteamx_000', 'something') or 			
	die('Could not connect to server.' );	
	$selectResult = mysql_select_db ('projectteamx_projectDB', $link) or 
	die('Could not select database.' );
	
	echo "<center><div style=\"width: 700px;\">

<div id=\"main\">
        <div class=\"content\">
            <h1><center>Your movies in list ".$listName."<center></h1>
           
        
    </div>
</div></center>";
	
	$userID = mysql_query("SELECT id FROM Account WHERE userName='".$userName."'", $link);
	$userID = mysql_fetch_array($userID)['id'];
	
	$listID = mysql_query("SELECT listID FROM userLists WHERE accountID='".$userID."' 
		AND listName='".$listName."'", $link);

	$listID = mysql_fetch_array($listID)['listID'];
	$_SESSION["listID"] = $listID;
	$_SESSION["listName"] = $listName;
	$userListMovieID = mysql_query("SELECT movieID FROM userListMovies WHERE listID='".$listID."'", $link);
	$row = mysql_fetch_assoc($userListMovieID);
	while($row)
	{
		$movieID=$row["movieID"];
		//echo "<h3>".$movieID."</h3>";
		$movieName=mysql_query("SELECT * FROM MyMovies WHERE id='".$movieID."'", $link);
		$row1 = mysql_fetch_assoc($movieName);
		$data = array("movieid" => $row1["id"]);
		$subStringStart = strpos($row1["title"], '(');
		$movieTitleNoDate = substr($row1["title"], 0, $subStringStart - 1);
		echo"<center><form action=\"deleteMovieFromList.php?". htmlentities(http_build_query($data)) ."\" method=\"post\" form style=\"display: inline\">
	<input type=\"hidden\" name=\"userID\" value=\"<?=$userID?>\" >
	<input type=\"hidden\" name=\"listID\" value=\"<?=$listID?>\" >
	<input type=\"hidden\" name=\"movieID\" value=\"<?=$data?>\" >
	<input type=\"submit\" value=\"Delete Movie\" >
	</form>";
		echo "<a href='moviePage.php?" . htmlentities(http_build_query($data)) ."'>". 	
		$movieTitleNoDate ."</a><br></center>";
		
		$row = mysql_fetch_assoc($userListMovieID);
	}
?>
<html>
	<link type="text/css" rel="stylesheet" href="viewListMoviesStyle.css"/>
<body>
<center>
	<form action="addMovie.php" method="post">
	<input type="hidden" name="userID" value="<?=$userID?>" >
	<input type="hidden" name="listID" value="<?=$listID?>" >
	<input type="submit" value="Add Movie" >
	</form>
</center>
</body>
</html>
<?php
echo"<center>";
include 'listComparison.php';


?>