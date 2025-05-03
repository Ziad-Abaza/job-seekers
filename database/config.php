<?php
$host = "localhost";
$user = "root";
$password ="";
$database = "job_seekers_db";     

$conn = mysqli_connect($host,$user,$password,$database);
if (!$conn) {
    die("Connection failed: ". mysqli_connect_error());
    }

?>
