<?php
$servername = "localhost";
$username = "0898095";
$password = "80abu7hw";
$database = "prj_2016_2017_medialab_ns_t1";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error);
?>