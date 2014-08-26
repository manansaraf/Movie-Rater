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

<center>
<div style="width: 500px; ">

<div id="main">
        <div class="content">
            <h1><center>Your Movie Lists.</center></h1>
           
        
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
	//$userName = $_POST['userName'];
	$userName = $_SESSION["userName"];
	
	$link = mysql_connect('engr-cpanel-mysql.engr.illinois.edu', 'projectteamx_000', 'something') or 			
	die('Could not connect to server.' );	
	$selectResult = mysql_select_db ('projectteamx_projectDB', $link) or 
	die('Could not select database.' );
	
	
	
	$userID = mysql_query("SELECT id FROM Account WHERE userName='".$userName."'", $link);
	$userID = mysql_fetch_array($userID)['id'];
	$userLists = mysql_query("SELECT listName FROM userLists WHERE accountID='".$userID."'", $link);
	while($row = mysql_fetch_array($userLists))
	{
		$data = array("listName" => $row["listName"]);
		echo"
           	 <center><a href='viewListMovies.php?" . htmlentities(http_build_query($data)) ."'>". $row["listName"] ."</a>";
		echo"<form action=\"deleteList.php?". htmlentities(http_build_query($data)) ."\" method=\"post\" style=\"display: inline\">
	<input type=\"hidden\" name=\"userID\" value=\"<?=$userID?>\" >
	<input type=\"hidden\" name=\"listID\" value=\"<?=$listID?>\" >
	<input type=\"hidden\" name=\"movieID\" value=\"<?=$data?>\" >
	<input type=\"submit\" value=\"Delete List\" >
	</form><br></center></html>";
		
            		

		
	}
?>
<html>
<head><br>
<center>
<form style="width: 400px;" action="addList.php" method="post">

	Add a list: <input type="text" name="listName"><br> 
	<input type="submit" value="Add List" >
</form>
<center>
</head>
</html>