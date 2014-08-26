<?php
session_start();
if(isset($_SESSION["userName"]))
{
	session_unset();
	header("location:/");
}
?>