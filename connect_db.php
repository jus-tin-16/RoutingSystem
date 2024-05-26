<?php
    session_start();
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db_name ="sampledatabase";
    $conn = new mysqli("localhost", "root", $password, $db_name);
    if (!$conn){
        die('Connection Failed : ' .mysql_error());
    }
?>