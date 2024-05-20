<?php
    $email = $_POST['email'];
    $userFirstName = $_POST['userFirstName'];
    $userLastName = $_POST['userLastName'];
    $userMInitial= $_POST['userMInitial'];
    $userName = $_POST['userName'];
    $password = $_POST['password'];

    $conn = new mysqli('localhost', 'root', '', 'sampledatabase');
    if ($conn->connect_errno){
        die('Connection Failed : ' .$conn->connect_error);
    }else{
        $stmt = $conn->prepare("insert into useraccount(userName, userPass) values(?,?)");
        $stmt->bind_param("ss", $userName, $password);
        $stmt->execute();
        echo 'Registered!';
        $stmt->close();
    }

    $user_id = mysqli_insert_id($conn);

    if($mysqli->connect_errno){
        die('Connection Failed : ' .$mysqli->connect_error);
    } else {
        $stmt = $conn->prepare("insert into userinfo(userMail, FirstName, LastName, MiddleInitial, userId) values(?,?,?,?,?)");
        $stmt->bind_param("ssssi", $email, $userFirstName, $userLastName, $userMInitial, $user_id);
        $stmt->execute();
        echo 'Registered!';
        $stmt->close();
        $conn->close();

    }
?>