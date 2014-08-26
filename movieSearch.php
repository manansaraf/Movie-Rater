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

<center>	
<div style="width: 700px;">

<div id="main">
        <div class="content">
            <h1><center>Search a movie!<center></h1>
           
        
    </div>
</div>
</center>

	
	
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
if(isset($_SESSION["userName"]))
{
	//echo "<h3>Logged in as ". $_SESSION["userName"] ."</h3>";
}
else
{
header("location:/");
}
?>
<html>
	<body>
	<center>
	<form action="searchMovies.php" method="post">
	Movie Name: <input type="text" name="movieName"><br> 
	<input type="hidden" name="userName" value="<?=$userName?>" >
	<input type="submit" value="Search Movie" >
	</form>
	</center>

	</body>
</html>