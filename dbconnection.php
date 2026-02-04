<?php
// mysqli_report(MYSQLI_REPORT_OFF);
// error_reporting(E_ALL);
// ini_set('display_errors',1);
$hostname = 'localhost';
$username = 'root';
$password = '';
$dbname   = 'auth';

$conn = mysqli_connect($hostname, $username, $password, $dbname);

// if (!$conn) {
//     die("Database connection failed: " . mysqli_connect_error());
// }

// echo "Connection successful";
