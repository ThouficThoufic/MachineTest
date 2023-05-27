<?php
// database Connection
// This line is establishing a connection to a MySQL database
$hostname = "localhost";
$username = "root";
$password = "";
$db =  "employee_management";
$conn = new mysqli($hostname,$username,$password,$db);

// Check for connection errors
if($conn->connect_error){
  die("connection error".$conn->connect_error);
}

// Start a new session
session_start();

// Turn on error reporting
error_reporting('1');
?>
