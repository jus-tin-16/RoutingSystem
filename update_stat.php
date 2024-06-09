<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db_name ="mydb";
    $conn = new mysqli("localhost", "root", $password, $db_name);
    if (!$conn){
        die('Connection Failed : ' .mysql_error());
    }

    if (isset($_POST['progress'])){
        $id = $_POST['id'];

        $sql = "UPDATE tasks SET status='inprogress' WHERE reportNo='$id'";

        if (mysqli_query($conn, $sql)){
            header("refresh:1; url=adminDashboard.php");
        } else {
            echo "Error";
        }
    } elseif (isset($_POST['complete'])) {
        $id = $_POST['id'];

        $sql = "UPDATE tasks SET status='completed' WHERE reportNo='$id'";

        if (mysqli_query($conn, $sql)){
            header("refresh:1; url=adminDashboard.php");
        } else {
            echo "Error";
        }
    }
?>
