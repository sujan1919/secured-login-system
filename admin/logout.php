<?php 
ob_start();
session_start();
include 'db/config.php'; 
unset($_SESSION['admin']);
header("location: login.php"); 
?>