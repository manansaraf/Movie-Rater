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

<style>
p
{
margin-left:150px;
}
</style>
	
<div style="width: 700px;">

<div id="main">
        <div class="content">
            <h1><p>All Movies</p></h1>
           
        
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

$link = mysql_connect('engr-cpanel-mysql.engr.illinois.edu', 'projectteamx_000', 'something') or die('Could not connect to server.' );

$selectResult = mysql_select_db ('projectteamx_projectDB', $link) or die('Could not select database.' );

$result = mysql_query("SELECT * FROM MyMovies");

$row = mysql_fetch_assoc($result);
while($row)
{
	$data = array("movieid" => $row["id"]);
	echo "<p><a href='moviePage.php?" . htmlentities(http_build_query($data)) ."'>". $row["title"] ."</a><br></p>";
	$row = mysql_fetch_assoc($result);
}


?>