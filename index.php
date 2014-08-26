<?php
session_start();
if(isset($_SESSION["userName"]))
{
	header("location:/viewLists.php");
}
?>

<html>
<head>
<link type="text/css" rel="stylesheet" href="side-menu.css"/>

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
            <a class="pure-menu-heading" href="#">CS 411</a>

            <ul>
                <li><a href="">Home</a></li>
              
            </ul>
        </div>
    </div>

    <div id="main">
        <div class="header">
            <h1>ProjectTeamX myMovies</h1>
           
        </div>

        <div class="content">
            <h2 class="content-subhead">Please Login</h2>
            <p>
               <script src="js/ui.js"></script>
		<form action="checkAccount.php" method="post">
		User Name: <input type="text" name="userName"><br>
		Password: <input type="password" name="password"><br>
		<input type="submit" value="Log in">
		</form>
		<a href="createAccount.php">Don''t have an account?</a>
            </p>

            
        </div>
    </div>
</div>






</div>

</html>
<html>
<center>