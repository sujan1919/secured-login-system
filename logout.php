<?php 
ob_start();
session_start();
include 'admin/db/config.php'; 
unset($_SESSION['customer']);
header("location: index.php"); 
?>